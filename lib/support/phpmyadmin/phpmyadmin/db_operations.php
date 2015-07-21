<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * handles miscellaneous db operations:
 *  - move/rename
 *  - copy
 *  - changing collation
 *  - changing comment
 *  - adding tables
 *  - viewing PDF schemas
 *
 * @package PhpMyAdmin
 */

/**
 * requirements
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/mysql_charsets.inc.php';

/**
 * functions implementation for this script
 */
require_once 'libraries/operations.lib.php';

// add a javascript file for jQuery functions to handle Ajax actions
$response = PMA_Response::getInstance();
$header = $response->getHeader();
$scripts = $header->getScripts();
$scripts->addFile('db_operations.js');

$sql_query = '';

/**
 * Rename/move or copy database
 */
/** @var PMA_String $pmaString */
$pmaString = $GLOBALS['PMA_String'];
if (/*overload*/mb_strlen($GLOBALS['db'])
    && (! empty($_REQUEST['db_rename']) || ! empty($_REQUEST['db_copy']))
) {
    if (! empty($_REQUEST['db_rename'])) {
        $move = true;
    } else {
        $move = false;
    }

    if (! isset($_REQUEST['newname'])
        || ! /*overload*/mb_strlen($_REQUEST['newname'])
    ) {
        $message = PMA_Message::error(__('The database name is empty!'));
    } else {
        $_error = false;
        if ($move || ! empty($_REQUEST['create_database_before_copying'])) {
            PMA_createDbBeforeCopy();
        }

        // here I don't use DELIMITER because it's not part of the
        // language; I have to send each statement one by one

        // to avoid selecting alternatively the current and new db
        // we would need to modify the CREATE definitions to qualify
        // the db name
        PMA_runProcedureAndFunctionDefinitions($GLOBALS['db']);

        // go back to current db, just in case
        $GLOBALS['dbi']->selectDb($GLOBALS['db']);

        $tables_full = $GLOBALS['dbi']->getTablesFull($GLOBALS['db']);

        include_once "libraries/plugin_interface.lib.php";
        // remove all foreign key constraints, otherwise we can get errors
        $export_sql_plugin = PMA_getPlugin(
            "export",
            "sql",
            'libraries/plugins/export/',
            array(
                'single_table' => isset($single_table),
                'export_type'  => 'database'
            )
        );

        // create stand-in tables for views
        $views = PMA_getViewsAndCreateSqlViewStandIn(
            $tables_full, $export_sql_plugin, $GLOBALS['db']
        );

        // copy tables
        $sqlConstratints = PMA_copyTables(
            $tables_full, $move, $GLOBALS['db']
        );

        // handle the views
        if (! $_error) {
            PMA_handleTheViews($views, $move, $GLOBALS['db']);
        }
        unset($views);

        // now that all tables exist, create all the accumulated constraints
        if (! $_error && count($sqlConstratints) > 0) {
            PMA_createAllAccumulatedConstraints($sqlConstratints);
        }
        unset($sqlConstratints);

        if (! PMA_DRIZZLE && PMA_MYSQL_INT_VERSION >= 50100) {
            // here DELIMITER is not used because it's not part of the
            // language; each statement is sent one by one

            PMA_runEventDefinitionsForDb($GLOBALS['db']);
        }

        // go back to current db, just in case
        $GLOBALS['dbi']->selectDb($GLOBALS['db']);

        // Duplicate the bookmarks for this db (done once for each db)
        PMA_duplicateBookmarks($_error, $GLOBALS['db']);

        if (! $_error && $move) {
            /**
             * cleanup pmadb stuff for this db
             */
            include_once 'libraries/relation_cleanup.lib.php';
            PMA_relationsCleanupDatabase($GLOBALS['db']);

            // if someday the RENAME DATABASE reappears, do not DROP
            $local_query = 'DROP DATABASE '
                . PMA_Util::backquote($GLOBALS['db']) . ';';
            $sql_query .= "\n" . $local_query;
            $GLOBALS['dbi']->query($local_query);

            $message = PMA_Message::success(
                __('Database %1$s has been renamed to %2$s.')
            );
            $message->addParam($GLOBALS['db']);
            $message->addParam($_REQUEST['newname']);
        } elseif (! $_error) {
            $message = PMA_Message::success(
                __('Database %1$s has been copied to %2$s.')
            );
            $message->addParam($GLOBALS['db']);
            $message->addParam($_REQUEST['newname']);
        } else {
            $message = PMA_Message::error();
        }
        $reload     = true;

        /* Change database to be used */
        if (! $_error && $move) {
            $GLOBALS['db'] = $_REQUEST['newname'];
        } elseif (! $_error) {
            if (isset($_REQUEST['switch_to_new'])
                && $_REQUEST['switch_to_new'] == 'true'
            ) {
                $GLOBALS['PMA_Config']->setCookie('pma_switch_to_new', 'true');
                $GLOBALS['db'] = $_REQUEST['newname'];
            } else {
                $GLOBALS['PMA_Config']->setCookie('pma_switch_to_new', '');
            }
        }
    }

    /**
     * Database has been successfully renamed/moved.  If in an Ajax request,
     * generate the output with {@link PMA_Response} and exit
     */
    if ($GLOBALS['is_ajax_request'] == true) {
        $response = PMA_Response::getInstance();
        $response->isSuccess($message->isSuccess());
        $response->addJSON('message', $message);
        $response->addJSON('newname', $_REQUEST['newname']);
        $response->addJSON(
            'sql_query',
            PMA_Util::getMessage(null, $sql_query)
        );
        $response->addJSON('db', $GLOBALS['db']);
        exit;
    }
}

/**
 * Settings for relations stuff
 */

$cfgRelation = PMA_getRelationsParam();

/**
 * Check if comments were updated
 * (must be done before displaying the menu tabs)
 */
if (isset($_REQUEST['comment'])) {
    PMA_setDbComment($GLOBALS['db'], $_REQUEST['comment']);
}

require 'libraries/db_common.inc.php';
$url_query .= '&amp;goto=db_operations.php';

// Gets the database structure
$sub_part = '_structure';
require 'libraries/db_info.inc.php';
echo "\n";

if (isset($message)) {
    echo PMA_Util::getMessage($message, $sql_query);
    unset($message);
}

$_REQUEST['db_collation'] = PMA_getDbCollation($GLOBALS['db']);
$is_information_schema = $GLOBALS['dbi']->isSystemSchema($GLOBALS['db']);

$response->addHTML('<div id="boxContainer" data-box-width="300">');

if (!$is_information_schema) {
    if ($cfgRelation['commwork']) {
        /**
         * database comment
         */
        $response->addHTML(PMA_getHtmlForDatabaseComment($GLOBALS['db']));
    }

    $response->addHTML('<div class="operations_half_width">');
    ob_start();
    include 'libraries/display_create_table.lib.php';
    $content = ob_get_contents();
    ob_end_clean();
    $response->addHTML($content);
    $response->addHTML('</div>');

    /**
     * rename database
     */
    if ($GLOBALS['db'] != 'mysql') {
        $response->addHTML(PMA_getHtmlForRenameDatabase($GLOBALS['db']));
    }

    // Drop link if allowed
    // Don't even try to drop information_schema.
    // You won't be able to. Believe me. You won't.
    // Don't allow to easily drop mysql database, RFE #1327514.
    if (($is_superuser || $GLOBALS['cfg']['AllowUserDropDatabase'])
        && ! $db_is_system_schema
        && (PMA_DRIZZLE || $GLOBALS['db'] != 'mysql')
    ) {
        $response->addHTML(PMA_getHtmlForDropDatabaseLink($GLOBALS['db']));
    }
    /**
     * Copy database
     */
    $response->addHTML(PMA_getHtmlForCopyDatabase($GLOBALS['db']));

    /**
     * Change database charset
     */
    $response->addHTML(PMA_getHtmlForChangeDatabaseCharset($GLOBALS['db'], $table));

    if (! $cfgRelation['allworks']
        && $cfg['PmaNoRelation_DisableWarning'] == false
    ) {
        $message = PMA_Message::notice(
            __('The phpMyAdmin configuration storage has been deactivated. %sFind out why%s.')
        );
        $message->addParam(
            '<a href="' . $cfg['PmaAbsoluteUri']
            . 'chk_rel.php' . $url_query . '">',
            false
        );
        $message->addParam('</a>', false);
        /* Show error if user has configured something, notice elsewhere */
        if (!empty($cfg['Servers'][$server]['pmadb'])) {
            $message->isError(true);
        }
    } // end if
} // end if (!$is_information_schema)

$response->addHTML('</div>');

// not sure about displaying the PDF dialog in case db is information_schema
if ($cfgRelation['pdfwork'] && $num_tables > 0) {
    // We only show this if we find something in the new pdf_pages table
    $test_query = '
         SELECT *
           FROM ' . PMA_Util::backquote($GLOBALS['cfgRelation']['db'])
            . '.' . PMA_Util::backquote($cfgRelation['pdf_pages']) . '
          WHERE db_name = \'' . PMA_Util::sqlAddSlashes($GLOBALS['db']) . '\'';
    $test_rs = PMA_queryAsControlUser(
        $test_query,
        false,
        PMA_DatabaseInterface::QUERY_STORE
    );
} // end if

?>
