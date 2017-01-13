<?php
/**
 *
 * Image Watermark. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Josh Woody, joshwoody.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_WATERMARK_SETTING_SAVED'	        => 'Image Watermark settings updated',

        'WATERMARK_FILE'                        => 'Watermark File',
        'WATERMARK_FILE_EXPLAIN'                => 'File must be a PNG image, and must already exist in `images` directory.',

        'NONE'      => 'None',

));
