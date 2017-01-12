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
		global $config, $request, $template, $user;

		$user->add_lang_ext('joshwoody/imagewatermark', 'common');
		$this->tpl_name = 'acp_imagewatermark_body';
		$this->page_title = $user->lang('ACP_DEMO_TITLE');
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

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
		));
	}
}
