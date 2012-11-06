<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Widget extends Widget_Base {
	public function User_Widget($name, $group, $icon) {
		parent::Widget_Base($name, $group, $icon);
	}
	
	public function has_permission($user_id) {
		return $user_id == $this->owner;
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */