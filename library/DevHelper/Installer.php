<?php

class DevHelper_Installer
{
    /* Start auto-generated lines of code. Change made will be overwriten... */

    protected static $_tables = array();
    protected static $_patches = array();

    public static function install($existingAddOn, $addOnData)
    {
        $db = XenForo_Application::get('db');

        foreach (self::$_tables as $table) {
            $db->query($table['createQuery']);
        }

        foreach (self::$_patches as $patch) {
            $tableExisted = $db->fetchOne($patch['showTablesQuery']);
            if (empty($tableExisted)) {
                continue;
            }

            $existed = $db->fetchOne($patch['showColumnsQuery']);
            if (empty($existed)) {
                $db->query($patch['alterTableAddColumnQuery']);
            }
        }

        self::installCustomized($existingAddOn, $addOnData);
    }

    public static function uninstall()
    {
        $db = XenForo_Application::get('db');

        foreach (self::$_patches as $patch) {
            $tableExisted = $db->fetchOne($patch['showTablesQuery']);
            if (empty($tableExisted)) {
                continue;
            }

            $existed = $db->fetchOne($patch['showColumnsQuery']);
            if (!empty($existed)) {
                $db->query($patch['alterTableDropColumnQuery']);
            }
        }

        foreach (self::$_tables as $table) {
            $db->query($table['dropQuery']);
        }

        self::uninstallCustomized();
    }

    /* End auto-generated lines of code. Feel free to make changes below */

    public static function installCustomized($existingAddOn, $addOnData)
    {
        // customized install script goes here
    }

    public static function uninstallCustomized()
    {
        // customized uninstall script goes here
    }

    public static function checkAddOnVersion()
    {
        if (XenForo_Application::isRegistered('addOns')) {
            $addOns = XenForo_Application::get('addOns');
            $versionId = $addOns['devHelper'];

            $xml = file_get_contents(dirname(__FILE__) . '/addon-DevHelper.xml');
            if (preg_match('#version_id="(?<id>\d+)"#', $xml, $matches)) {
                if ($versionId < $matches['id']) {
                    return false;
                }
            }
        }

        return true;
    }

}