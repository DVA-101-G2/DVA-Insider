<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Widgetmodel extends CI_Model {
	public function Widgetmodel() {
		parent::__construct();
		define("WIDGET_PATH", APPPATH.'widgets/');
		require_once WIDGET_PATH.'widget_base.php';
		require_once WIDGET_PATH.'user_widget.php';
	}
	
	public function get_widget($widgetid) {
		$this->db->where('widget_id', $widgetid);
		$query = $this->db->get('widgets');
		
		if($query->num_rows == 0) {
			return false;
		}
		
		$row = $query->row();
		
		if(!$this->load_widget($row->widget_group, $row->widget_name))
			return false;
		
		$widget = new $row->widget_name;
		$widget->id = $widgetid;
		$widget->owner = $row->widget_owner;
		$widget->data = unserialize($row->widget_data);
		return $widget;
	}

	public function update_widget($widget) {
		$this->db->where('widget_id', $widget->id);
		$this->db->update('widgets', array('widget_data' => serialize($widget->data)));
	}
	
	public function delete_widget($widget) {
		$this->db->delete('widgets', array('widget_id' => $widget->id));
	}
	
	public function list_all_widgets($group) {
		if ($handle = opendir(WIDGET_PATH.$group.'/')) {
			$return = array();
			while (false !== ($entry = readdir($handle))) {
				if($entry == '.' || $entry == '..' || $entry == '') continue;
				require_once WIDGET_PATH.$group.'/'.$entry;
				$class_name = ucfirst(str_replace('.php', '', $entry));
				$return[] = new $class_name;
			}
			return $return;
		}
		else
			return false;
	}
	
	public function get_all_widgets($group, $owner) {
		$this->db->where('widget_group', $group);
		$this->db->where('widget_owner', $owner);
		return $this->db->get('widgets')->result();
	}
	
	public function create_widget($group, $name, $owner) {
		if(!$this->load_widget($group, $name))
			return false;
		
		$widget = new $name;
		$widget->owner = $owner;
		$widget->data = new stdclass;
		
		return $widget;
	}
	
	public function save_widget($widget) {
		$data = array(
			'widget_name' => get_class($widget),
			'widget_owner' => $widget->owner,
			'widget_group' => $widget->group,
			'widget_data' => serialize($widget->data)
		);
		$this->db->insert('widgets', $data);
		$widget->id = $this->db->insert_id();
		$widget->create();
		return $widget;
	}
	
	
	
	private function load_widget($group, $name) {
		$path = WIDGET_PATH.$group.'/'.$name.'.php';
		if(!realpath($path)){
			return false;
		}
		require_once $path;
		return true;
	}

}