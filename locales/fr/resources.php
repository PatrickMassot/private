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
if (!isset(dcCore::app()->resources['help']['privatemode'])) {
    dcCore::app()->resources['help']['privatemode'] = __DIR__ . '/help/help.html';
}
