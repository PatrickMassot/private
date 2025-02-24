<?php
/**
 * @brief private, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\private;

use dcCore;
use dcNsProcess;
use Dotclear\Plugin\Uninstaller\Uninstaller;

class Uninstall extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::UNINSTALL);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init || !dcCore::app()->plugins->moduleExists('Uninstaller')) {
            return false;
        }

        $module = My::id();

        $ns = My::id(); // Namespace for blog settings
        // $ws = My::id(); // Workspace for user preferences

        // $cache = My::id(); // Cache sub-folder
        // $var   = My::id(); // Var sub-folder

        // Database table name
        // $table = dcCore::app()->prefix . 'private';

        $user_actions = [

            // Cache
            'caches' => [
                // ['empty', $cache],  // Empty cache folder
                // ['delete', $cache], // Delete cache folder
            ],

            // Var
            'vars' => [
                // ['delete', implode(DIRECTORY_SEPARATOR, ['plugins', $var])],    // Delete var plugin folder
                // ['delete', implode(DIRECTORY_SEPARATOR, ['themes', $var])],     // Delete var theme folder
            ],

            // Blog settings
            'settings' => [
                ['delete_local', $ns],      // Delete local settings
                ['delete_global', $ns],     // Delete global settings
                ['delete_all', $ns],        // Delete all settings

                // ['delete_related', 'ns:id;ns:id;'], // Delete specific setting(s)
            ],

            // User preferences
            'preferences' => [
                // ['delete_local', $ws],      // Delete user preferences
                // ['delete_global', $ws],     // Delete global preferences
                // ['delete_all', $ws],        // Delete all preferences

                // ['delete_related', 'ns:id;ns:id;'], // Delete specific preference(s)
            ],

            // Version (module)
            'versions' => [
                ['delete', $module],    // Delete module version
            ],

            // Table (database)
            'tables' => [
                // ['empty', $table],      // Empty table
                // ['delete', $table],     // Delete table
            ],

            // Plugin or Theme
            (dcCore::app()->plugins->getDefines(['id' => $module]) ? 'plugins' : 'themes') => [
                ['delete', $module],    // Same as plugin/theme Delete button in plugin/theme management
            ],

            // Logs
            'logs' => [
                // ['delete_all', $module],    // Empty log table
            ],

        ];

        foreach ($user_actions as $cleaner => $task) {
            foreach ($task as $action) {
                Uninstaller::instance()->addUserAction($cleaner, $action[0], $action[1]);
            }
        }

        // Direct actions — WARNING: will delete without user confirmation !!!
        // Use when module is deleted from another action (other than theme/plugin management form)

        $direct_actions = [
            // Cache
            'caches' => [
                // ['empty', $cache],  // Empty cache folder
                // ['delete', $cache], // Delete cache folder
            ],

            // Var
            'vars' => [
                // ['delete', implode(DIRECTORY_SEPARATOR, ['plugins', $var])],    // Delete var plugin folder
                // ['delete', implode(DIRECTORY_SEPARATOR, ['themes', $var])],     // Delete var theme folder
            ],

            // Blog settings
            'settings' => [
                // ['delete_local', $ns],      // Delete local settings
                // ['delete_global', $ns],     // Delete global settings
                // ['delete_all', $ns],        // Delete all settings

                // ['delete_related', 'ns:id;ns:id;'], // Delete specific setting(s)
            ],

            // User preferences
            'preferences' => [
                // ['delete_local', $ws],      // Delete user preferences
                // ['delete_global', $ws],     // Delete global preferences
                // ['delete_all', $ws],        // Delete all preferences

                // ['delete_related', 'ns:id;ns:id;'], // Delete specific preference(s)
            ],

            // Version (module)
            'versions' => [
                ['delete', $module],    // Delete module version
            ],

            // Table (database)
            'tables' => [
                // ['empty', $table],      // Empty table
                // ['delete', $table],     // Delete table
            ],

            // Plugin or Theme
            (dcCore::app()->plugins->getDefines(['id' => $module]) ? 'plugins' : 'themes') => [
                ['delete', $module],    // Same as plugin/theme Delete button in plugin/theme management
            ],

            // Logs
            'logs' => [
                // ['delete_all', $module],    // Empty log table
            ],

        ];

        foreach ($direct_actions as $cleaner => $task) {
            foreach ($task as $action) {
                Uninstaller::instance()->addDirectAction($cleaner, $action[0], $action[1]);
            }
        }

        return true;
    }
}
