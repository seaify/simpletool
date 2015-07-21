<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Blob SQL Transformations plugin for phpMyAdmin
 *
 * @package    PhpMyAdmin-Transformations
 * @subpackage SQL
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/* Get the sql transformations interface */
require_once 'libraries/plugins/transformations/abstract/'
    . 'SQLTransformationsPlugin.class.php';

/**
 * Handles the sql transformation for blob data
 *
 * @package    PhpMyAdmin-Transformations
 * @subpackage SQL
 */
class Text_Octetstream_Sql extends SQLTransformationsPlugin
{
    /**
     * Gets the plugin`s MIME type
     *
     * @return string
     */
    public static function getMIMEType()
    {
        return "Text";
    }

    /**
     * Gets the plugin`s MIME subtype
     *
     * @return string
     */
    public static function getMIMESubtype()
    {
        return "Octetstream";
    }
}
?>