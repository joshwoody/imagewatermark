<?php
/**
 *
 * Image Watermark. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Josh Woody, joshwoody.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace joshwoody\imagewatermark\acp;

/**
 * Image Watermark ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\joshwoody\imagewatermark\acp\main_module',
			'title'		=> 'ACP_IMAGEWATERMARK_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_IMAGEWATERMARK_TITLE',
					'auth'	=> 'ext_joshwoody/imagewatermark && acl_a_board',
				),
			),
		);
	}
}
