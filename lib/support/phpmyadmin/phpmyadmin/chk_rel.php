<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Displays status of phpMyAdmin configuration storage
 *
 * @package PhpMyAdmin
 */

require_once 'libraries/common.inc.php';

// If request for creating all PMA tables.
if (isset($_REQUEST['create_pmadb'])) {
    PMA_fixPMATables($GLOBALS['db']);
}

$cfgRelation = PMA_getRelationsParam();
// If request for creating missing PMA tables.
if (isset($_REQUEST['fix_pmadb'])) {
    PMA_fixPMATables($cfgRelation['db']);
}

$response = PMA_Response::getInstance();
$response->addHTML(
    PMA_getRelationsParamDiagnostic($cfgRelation)
);

?>
