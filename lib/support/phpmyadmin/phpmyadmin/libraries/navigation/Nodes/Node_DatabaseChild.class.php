<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functionality for the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Represents a node that is a concrete child of a database node
 *
 * @package PhpMyAdmin-Navigation
 */
abstract class Node_DatabaseChild extends Node
{
    /**
     * Returns HTML for hide button displayed infront of the database child node
     *
     * @return String HTML for hide button
     */
    public function getHtmlForControlButtons()
    {
        $ret = '';
        $cfgRelation = PMA_getRelationsParam();
        if (isset($cfgRelation['navwork']) && $cfgRelation['navwork']) {
            $db   = $this->realParent()->real_name;
            $item = $this->real_name;
            $ret  = '<span class="navItemControls">'
                . '<a href="navigation.php'
                . PMA_URL_getCommon()
                . '&hideNavItem=true'
                . '&itemType=' . urlencode($this->getItemType())
                . '&itemName=' . urlencode($item)
                . '&dbName=' . urlencode($db) . '"'
                . ' class="hideNavItem ajax">'
                . PMA_Util::getImage('lightbulb_off.png', __('Hide'))
                . '</a></span>';
        }
        return $ret;
    }

    /**
     * Returns the type of the item represented by the node.
     *
     * @return string type of the item
     */
    protected abstract function getItemType();
}
?>
