<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_Base {
	public $id;
	public $data;
	public $name;
	public $group;
	public $owner;
	public $icon;
	protected $ci;
	
	
	public function Widget_Base($name, $group, $icon) {
		$this->ci = get_instance();
		$this->name = $name;
		$this->group = $group;
		$this->icon = $icon;
	}
	
	public function get() {
		
	}
	
	public function config() {
		
	}
	
	public function create() {
	
	}
	public function delete() {
	
	}
	
	public function has_permission($user_id) {
		return false;
	}
	
	protected function update() {
		$this->ci->widgetmodel->update_widget($this);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */