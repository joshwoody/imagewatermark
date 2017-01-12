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
 * Image Watermark ACP module.
 */
class main_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_root_path;

		$user->add_lang_ext('joshwoody/imagewatermark', 'common');
		$this->tpl_name = 'acp_imagewatermark_body';
		$this->page_title = $user->lang('ACP_IMAGEWATERMARK_TITLE');
		add_form_key('imagewatermark');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('imagewatermark'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('watermark_file', $request->variable('watermark_file', 0));

			trigger_error($user->lang('ACP_WATERMARK_SETTING_SAVED') . adm_back_link($this->u_action));
		}

                // fetch list of possible images
                $img_path =  'images';
                if ($dir = @opendir($phpbb_root_path . $img_path))
		{
			while (($file = readdir($dir)) !== false)
			{
				if (is_file($phpbb_root_path . $img_path . '/' . $file) && preg_match('#\.png$#i', $file))
				{
                                    $template->assign_block_vars('watermark_file_loop', array(
                                        // Do not use $phpbb_root_path
                                        'PATH'  => $img_path . '/' . $file,
                                    ));
				}
			}
			closedir($dir);
                }


		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
		));
	}
}
