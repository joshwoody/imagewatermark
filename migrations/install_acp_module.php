<?php
/**
 *
 * Image Watermark. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Josh Woody, joshwoody.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace joshwoody\imagewatermark\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['watermark_file']);
	}

        // TODO: I'm not sure this ext works on 3.1.x
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('watermark_file', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_IMAGEWATERMARK_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_IMAGEWATERMARK_TITLE',
				array(
					'module_basename'	=> '\joshwoody\imagewatermark\acp\main_module',
                                        'modes'     => array('settings')
				),
			)),
		);
	}
}
