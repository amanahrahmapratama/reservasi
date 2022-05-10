<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('setting/Setting_model');
	}

	public function general()
	{
		$ret = $this->ci->Setting_model->get_setting(array('category_id' => SETTING_GENERAL));
		return $ret;
	}

	public function email()
	{
		$ret = $this->ci->Setting_model->get_setting(array('category_id' => SETTING_EMAIL));
		return $ret;
	}

	public function image()
	{
		$ret = $this->ci->Setting_model->get_setting(array('category_id' => SETTING_IMAGE));
		return $ret;
	}
}

/* End of file Setting.php */
/* Location: .//Applications/MAMP/htdocs/jatayu/panelapp/libraries/Setting.php */
