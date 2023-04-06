<?php
/**
 * @brief PrivateMode, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Osku and contributors
 *
 * @copyright Osku
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class tplPrivate
{
    public static function PrivateMsg($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return '<?php echo ' . sprintf($f, 'dcCore::app()->blog->settings->private->message') . '; ?>';
    }

    public static function PrivateReqPage()
    {
        return '<?php echo(isset($_SERVER[\'REQUEST_URI\'])
            ? \\Dotclear\\Helper\\Html\\Html::escapeHTML($_SERVER[\'REQUEST_URI\'])
            : dcCore::app()->blog->url); ?>';
    }
}
