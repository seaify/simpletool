<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Renders data dictionary
 *
 * @package PhpMyAdmin
 */

/**
 * Gets the variables sent or posted to this script, then displays headers
 */
require_once 'libraries/common.inc.php';

if (! isset($selected_tbl)) {
    include 'libraries/db_common.inc.php';
    include 'libraries/db_info.inc.php';
}

$response = PMA_Response::getInstance();
$header   = $response->getHeader();
$header->enablePrintView();

/**
 * Gets the relations settings
 */
$cfgRelation  = PMA_getRelationsParam();

require_once 'libraries/transformations.lib.php';
require_once 'libraries/Index.class.php';

/**
 * Check parameters
 */
PMA_Util::checkParameters(array('db'));

/**
 * Defines the url to return to in case of error in a sql statement
 */
$err_url = 'db_sql.php' . PMA_URL_getCommon(array('db' => $db));

if ($cfgRelation['commwork']) {
    $comment = PMA_getDbComment($db);

    /**
     * Displays DB comment
     */
    if ($comment) {
        echo '<p>' . __('Database comment:')
            . ' <i>' . htmlspecialchars($comment) . '</i></p>';
    } // end if
}

/**
 * Selects the database and gets tables names
 */
$GLOBALS['dbi']->selectDb($db);
$tables = $GLOBALS['dbi']->getTables($db);

$count  = 0;
foreach ($tables as $table) {
    $comments = PMA_getComments($db, $table);

    echo '<div>' . "\n";

    echo '<h2>' . htmlspecialchars($table) . '</h2>' . "\n";

    /**
     * Gets table informations
     */
    $show_comment = PMA_Table::sGetStatusInfo($db, $table, 'TABLE_COMMENT');

    /**
     * Gets table keys and retains them
     */
    $GLOBALS['dbi']->selectDb($db);
    $indexes = $GLOBALS['dbi']->getTableIndexes($db, $table);
    list($primary, $pk_array, $indexes_info, $indexes_data)
        = PMA_Util::processIndexData($indexes);

    /**
     * Gets columns properties
     */
    $columns = $GLOBALS['dbi']->getColumns($db, $table);

    // Check if we can use Relations
    list($res_rel, $have_rel) = PMA_getRelationsAndStatus(
        ! empty($cfgRelation['relation']), $db, $table
    );

    /**
     * Displays the comments of the table if MySQL >= 3.23
     */
    if (!empty($show_comment)) {
        echo __('Table comments:') . ' ';
        echo htmlspecialchars($show_comment) . '<br /><br />';
    }

    /**
     * Displays the table structure
     */

    echo '<table width="100%" class="print">';
    echo '<tr><th width="50">' . __('Column') . '</th>';
    echo '<th width="80">' . __('Type') . '</th>';
    echo '<th width="40">' . __('Null') . '</th>';
    echo '<th width="70">' . __('Default') . '</th>';
    if ($have_rel) {
        echo '    <th>' . __('Links to') . '</th>' . "\n";
    }
    echo '    <th>' . __('Comments') . '</th>' . "\n";
    if ($cfgRelation['mimework']) {
        echo '    <th>MIME</th>' . "\n";
    }
    echo '</tr>';
    $odd_row = true;
    foreach ($columns as $row) {

        if ($row['Null'] == '') {
            $row['Null'] = 'NO';
        }
        $extracted_columnspec
            = PMA_Util::extractColumnSpec($row['Type']);

        // reformat mysql query output
        // set or enum types: slashes single quotes inside options
        if ('set' == $extracted_columnspec['type']
            || 'enum' == $extracted_columnspec['type']
        ) {
            $type_nowrap  = '';

        } else {
            $type_nowrap  = ' class="nowrap"';
        }
        $type = htmlspecialchars($extracted_columnspec['print_type']);
        $attribute     = $extracted_columnspec['attribute'];
        if (! isset($row['Default'])) {
            if ($row['Null'] != 'NO') {
                $row['Default'] = '<i>NULL</i>';
            }
        } else {
            $row['Default'] = htmlspecialchars($row['Default']);
        }
        $column_name = $row['Field'];

        echo '<tr class="';
        echo $odd_row ? 'odd' : 'even'; $odd_row = ! $odd_row;
        echo '">';
        echo '<td class="nowrap">';
        echo htmlspecialchars($column_name);

        if (isset($pk_array[$row['Field']])) {
            echo ' <em>(' . __('Primary') . ')</em>';
        }
        echo '</td>';
        echo '<td' . $type_nowrap . ' lang="en" dir="ltr">' . $type . '</td>';
        echo '<td>';
        echo (($row['Null'] == 'NO') ? __('No') : __('Yes'));
        echo '</td>';
        echo '<td class="nowrap">';
        if (isset($row['Default'])) {
            echo $row['Default'];
        }
        echo '</td>';

        if ($have_rel) {
            echo '    <td>';
            if ($foreigner = PMA_searchColumnInForeigners($res_rel, $column_name)) {
                echo htmlspecialchars(
                    $foreigner['foreign_table']
                    . ' -> '
                    . $foreigner['foreign_field']
                );
            }
            echo '</td>' . "\n";
        }
        echo '    <td>';
        if (isset($comments[$column_name])) {
            echo htmlspecialchars($comments[$column_name]);
        }
        echo '</td>' . "\n";
        if ($cfgRelation['mimework']) {
            $mime_map = PMA_getMIME($db, $table, true);

            echo '    <td>';
            if (isset($mime_map[$column_name])) {
                echo htmlspecialchars(
                    str_replace('_', '/', $mime_map[$column_name]['mimetype'])
                );
            }
            echo '</td>' . "\n";
        }
        echo '</tr>';
    } // end foreach
    $count++;
    echo '</table>';
    // display indexes information
    if (count(PMA_Index::getFromTable($table, $db)) > 0) {
        echo PMA_Index::getView($table, $db, true);
    }
    echo '</div>';
} //ends main while

/**
 * Displays the footer
 */
echo PMA_Util::getButton();

?>
