<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tracking configuration for database
 *
 * @package PhpMyAdmin
 */

/**
 * Run common work
 */
require_once 'libraries/common.inc.php';

require_once './libraries/tracking.lib.php';

//Get some js files needed for Ajax requests
$response = PMA_Response::getInstance();
$header   = $response->getHeader();
$scripts  = $header->getScripts();
$scripts->addFile('jquery/jquery.tablesorter.js');
$scripts->addFile('db_tracking.js');

/**
 * If we are not in an Ajax request, then do the common work and show the links etc.
 */
require 'libraries/db_common.inc.php';
$url_query .= '&amp;goto=tbl_tracking.php&amp;back=db_tracking.php';

// Get the database structure
$sub_part = '_structure';
require 'libraries/db_info.inc.php';

// Work to do?
//  (here, do not use $_REQUEST['db] as it can be crafted)
if (isset($_REQUEST['delete_tracking']) && isset($_REQUEST['table'])) {

    PMA_Tracker::deleteTracking($GLOBALS['db'], $_REQUEST['table']);
    PMA_Message::success(
        __('Tracking data deleted successfully.')
    )->display();

} elseif (isset($_REQUEST['submit_create_version'])) {

    PMA_createTrackingForMultipleTables($_REQUEST['selected']);
    PMA_Message::success(
        sprintf(
            __(
                'Version %1$s was created for selected tables,'
                . ' tracking is active for them.'
            ),
            htmlspecialchars($_REQUEST['version'])
        )
    )->display();

} elseif (isset($_REQUEST['submit_mult'])) {

    if (! empty($_REQUEST['selected_tbl'])) {
        if ($_REQUEST['submit_mult'] == 'delete_tracking') {

            foreach ($_REQUEST['selected_tbl'] as $table) {
                PMA_Tracker::deleteTracking($GLOBALS['db'], $table);
            }
            PMA_Message::success(
                __('Tracking data deleted successfully.')
            )->display();

        } elseif ($_REQUEST['submit_mult'] == 'track') {

            echo PMA_getHtmlForDataDefinitionAndManipulationStatements(
                'db_tracking.php' . $url_query,
                0,
                $GLOBALS['db'],
                $_REQUEST['selected_tbl']
            );
            exit;
        }
    } else {
        PMA_Message::notice(
            __('No tables selected.')
        )->display();
    }
}

// Get tracked data about the database
$data = PMA_Tracker::getTrackedData($_REQUEST['db'], '', '1');

// No tables present and no log exist
if ($num_tables == 0 && count($data['ddlog']) == 0) {
    echo '<p>' . __('No tables found in database.') . '</p>' . "\n";

    if (empty($db_is_system_schema)) {
        include 'libraries/display_create_table.lib.php';
    }
    exit;
}

// ---------------------------------------------------------------------------
$cfgRelation = PMA_getRelationsParam();

// Prepare statement to get HEAD version
$all_tables_query = ' SELECT table_name, MAX(version) as version FROM ' .
     PMA_Util::backquote($cfgRelation['db']) . '.' .
     PMA_Util::backquote($cfgRelation['tracking']) .
     ' WHERE db_name = \'' . PMA_Util::sqlAddSlashes($_REQUEST['db']) . '\' ' .
     ' GROUP BY table_name' .
     ' ORDER BY table_name ASC';

$all_tables_result = PMA_queryAsControlUser($all_tables_query);

// If a HEAD version exists
if ($GLOBALS['dbi']->numRows($all_tables_result) > 0) {
    ?>
    <div id="tracked_tables">
    <h3><?php echo __('Tracked tables');?></h3>

    <form method="post" action="db_tracking.php" name="trackedForm"
        id="trackedForm" class="ajax">
    <?php
    echo PMA_URL_getHiddenInputs($GLOBALS['db'])
    ?>
    <table id="versions" class="data">
    <thead>
    <tr>
        <th></th>
        <th><?php echo __('Table');?></th>
        <th><?php echo __('Last version');?></th>
        <th><?php echo __('Created');?></th>
        <th><?php echo __('Updated');?></th>
        <th><?php echo __('Status');?></th>
        <th><?php echo __('Action');?></th>
        <th><?php echo __('Show');?></th>
    </tr>
    </thead>
    <tbody>
    <?php

    // Print out information about versions

    $delete = PMA_Util::getIcon('b_drop.png', __('Delete tracking'));
    $versions = PMA_Util::getIcon('b_versions.png', __('Versions'));
    $report = PMA_Util::getIcon('b_report.png', __('Tracking report'));
    $structure = PMA_Util::getIcon('b_props.png', __('Structure snapshot'));

    $style = 'odd';
    while ($one_result = $GLOBALS['dbi']->fetchArray($all_tables_result)) {
        list($table_name, $version_number) = $one_result;
        $table_query = ' SELECT * FROM ' .
             PMA_Util::backquote($cfgRelation['db']) . '.' .
             PMA_Util::backquote($cfgRelation['tracking']) .
             ' WHERE `db_name` = \'' . PMA_Util::sqlAddSlashes($_REQUEST['db'])
             . '\' AND `table_name`  = \'' . PMA_Util::sqlAddSlashes($table_name)
             . '\' AND `version` = \'' . $version_number . '\'';

        $table_result = PMA_queryAsControlUser($table_query);
        $version_data = $GLOBALS['dbi']->fetchArray($table_result);

        $tmp_link = 'tbl_tracking.php' . $url_query . '&amp;table='
            . htmlspecialchars($version_data['table_name']);
        $delete_link = 'db_tracking.php' . $url_query . '&amp;table='
            . htmlspecialchars($version_data['table_name'])
            . '&amp;delete_tracking=true&amp';
        $checkbox_id = "selected_tbl_"
            . htmlspecialchars($version_data['table_name']);
        ?>
        <tr class="noclick <?php echo $style;?>">
            <td class="center">
                <input type="checkbox" name="selected_tbl[]"
                class="checkall" id="<?php echo $checkbox_id;?>"
                value="<?php echo htmlspecialchars($version_data['table_name']);?>"/>
            </td>
            <th>
                <label for="<?php echo $checkbox_id;?>">
                    <?php echo htmlspecialchars($version_data['table_name']);?>
                </label>
            </th>
            <td class="right"><?php echo $version_data['version'];?></td>
            <td><?php echo $version_data['date_created'];?></td>
            <td><?php echo $version_data['date_updated'];?></td>
            <td>
            <?php
                $state = PMA_getVersionStatus($version_data);
                $options = array(
                    0 => array(
                        'label' => __('not active'),
                        'value' => 'deactivate_now',
                        'selected' => ($state != 'active')
                    ),
                    1 => array(
                        'label' => __('active'),
                        'value' => 'activate_now',
                        'selected' => ($state == 'active')
                    )
                );
                echo PMA_Util::toggleButton(
                    $tmp_link . '&amp;version=' . $version_data['version'],
                    'toggle_activation',
                    $options,
                    null
                );
            ?>
            </td>
            <td>
            <a class="delete_tracking_anchor ajax" href="<?php echo $delete_link;?>" >
            <?php echo $delete; ?></a>
        <?php
        echo '</td>'
            . '<td>'
            . '<a href="' . $tmp_link . '">' . $versions . '</a>'
            . '&nbsp;&nbsp;'
            . '<a href="' . $tmp_link . '&amp;report=true&amp;version='
            . $version_data['version'] . '">' . $report . '</a>'
            . '&nbsp;&nbsp;'
            . '<a href="' . $tmp_link . '&amp;snapshot=true&amp;version='
            . $version_data['version'] . '">' . $structure . '</a>'
            . '</td>'
            . '</tr>';
        if ($style == 'even') {
            $style = 'odd';
        } else {
            $style = 'even';
        }
    }
    unset($tmp_link);
    ?>
    </tbody>
    </table>
    <?php
    echo PMA_Util::getWithSelected($pmaThemeImage, $text_dir, "trackedForm");
    echo PMA_Util::getButtonOrImage(
        'submit_mult', 'mult_submit', 'submit_mult_delete_tracking',
        __('Delete tracking'), 'b_drop.png', 'delete_tracking'
    );
    ?>
    </form>
    </div>
    <?php
}

$sep = $GLOBALS['cfg']['NavigationTreeTableSeparator'];

// Get list of tables
$table_list = PMA_Util::getTableList($GLOBALS['db']);

$my_tables = array();

// For each table try to get the tracking version
foreach ($table_list as $key => $value) {
    // If $value is a table group.
    if (array_key_exists(('is' . $sep . 'group'), $value)
        && $value['is' . $sep . 'group']
    ) {
        foreach ($value as $temp_table) {
            // If $temp_table is a table with the value for 'Name' is set,
            // rather than a property of the table group.
            if (is_array($temp_table)
                && array_key_exists('Name', $temp_table)
            ) {
                $tracking_version = PMA_Tracker::getVersion(
                    $GLOBALS['db'],
                    $temp_table['Name']
                );
                if ($tracking_version == -1) {
                    $my_tables[] = $temp_table['Name'];
                }
            }
        }
    } else { // If $value is a table.
        if (PMA_Tracker::getVersion($GLOBALS['db'], $value['Name']) == -1) {
            $my_tables[] = $value['Name'];
        }
    }
}

// If untracked tables exist
if (count($my_tables) > 0) {
    ?>
    <h3><?php echo __('Untracked tables');?></h3>
    <form method="post" action="db_tracking.php" name="untrackedForm"
        id="untrackedForm" class="ajax">
    <?php
    echo PMA_URL_getHiddenInputs($GLOBALS['db'])
    ?>
    <table id="noversions" class="data">
    <thead>
    <tr>
        <th></th>
        <th style="width: 300px"><?php echo __('Table');?></th>
        <th><?php echo __('Action');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Print out list of untracked tables

    $style = 'odd';

    foreach ($my_tables as $key => $tablename) {
        $checkbox_id = "selected_tbl_"
            . htmlspecialchars($tablename);
        if (PMA_Tracker::getVersion($GLOBALS['db'], $tablename) == -1) {
            $my_link = '<a href="tbl_tracking.php' . $url_query
                . '&amp;table=' . htmlspecialchars($tablename) . '">';
            $my_link .= PMA_Util::getIcon('eye.png', __('Track table'));
            $my_link .= '</a>';
            ?>
            <tr class="noclick <?php echo $style;?>">
            <td class="center">
                <input type="checkbox" name="selected_tbl[]"
                    class="checkall" id="<?php echo $checkbox_id;?>"
                    value="<?php echo htmlspecialchars($tablename);?>"/>
            </td>
            <th>
                <label for="<?php echo $checkbox_id;?>">
                    <?php echo htmlspecialchars($tablename);?>
                </label>
            </th>
            <td><?php echo $my_link;?></td>
            </tr>
            <?php
            if ($style == 'even') {
                $style = 'odd';
            } else {
                $style = 'even';
            }
        }
    }
    ?>
    </tbody>
    </table>
    <?php
    echo PMA_Util::getWithSelected($pmaThemeImage, $text_dir, "untrackedForm");
    echo PMA_Util::getButtonOrImage(
        'submit_mult', 'mult_submit', 'submit_mult_track',
        __('Track table'), 'eye.png', 'track'
    );
    ?>
    </form>
    <?php
}
// If available print out database log
if (count($data['ddlog']) > 0) {
    $log = '';
    foreach ($data['ddlog'] as $entry) {
        $log .= '# ' . $entry['date'] . ' ' . $entry['username'] . "\n"
            . $entry['statement'] . "\n";
    }
    echo PMA_Util::getMessage(__('Database Log'), $log);
}

?>
