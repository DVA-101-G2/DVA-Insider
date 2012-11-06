<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends CI_Controller {
	private $widget;

	public function __construct() {
		parent::__construct();
		$this->load->model('widgetmodel');
		if($this->uri->segment(2) == "listgroup" || $this->uri->segment(2) == "create")
			return;	
			
		$widget_id = $this->uri->segment(3);
		
		if(!$widget_id || !is_numeric($widget_id)) {
			show_404();
			exit;
		}
		
		$this->widget = $this->widgetmodel->get_widget($widget_id);
		
		if(!$this->widget){
			show_404();
			exit;
		}
    }
	
	public function config() {
		if($this->widget->has_permission($this->session->userdata('user_id'))) {
			$this->load->library('form_validation');
			$this->widget->config();
		}
		else
			show_404();
	}
	
	public function delete() {
		if($this->widget->has_permission($this->session->userdata('user_id'))) {
			$this->widget->delete();
			$this->widgetmodel->delete_widget($this->widget);
			echo $widget->id;
		}
		else
			show_404();
	}
	
	public function get() {
		$this->widget->get();
	}
	
	public function listgroup() {
		$group = $this->uri->segment(3);
		if(preg_match('/^[A-Za-z]+$/', $group) === false) {
			show_404();
			return;
		}
		$widgets = $this->widgetmodel->list_all_widgets($group);
		if(!$widgets) {
			show_404();
			return;
		}
		$json = array();
		foreach($widgets as $widget) {
			$json[get_class($widget)] = array(
				'name' => $widget->name,
				'icon' => $widget->icon
			);
		}
		
		echo json_encode($json);
	}
	
	public function create() {
		$widget_group = $this->uri->segment(3);
		$widget_name = $this->uri->segment(4);
		$owner = $this->uri->segment(5);
		if(preg_match('/^[A-Za-z]+$/', $widget_group) === false || preg_match('/^[A-Za-z]+$/', $widget_name) === false) {
			show_404();
			return;
		}
		$widget = $this->widgetmodel->create_widget($widget_group, $widget_name, $owner);
		if($widget->has_permission($this->session->userdata('user_id'))) {
			echo $this->widgetmodel->save_widget($widget)->id;
		}
		else
			show_404();
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */