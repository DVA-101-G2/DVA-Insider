<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget {
	private $name = "";
	private $icon = "";
	public $c;
	
	
	public function Widget() {
		$this->c =& get_instance();
	}
	
	public function icon() {
		
	}
	
	public function config() {
		
	}
	
	protected function set_icon($icon_path) {
		$this->icon = $icon_path;
	}
	
	protected function set_name($name) {
		$this->name = $name;
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */