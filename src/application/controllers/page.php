<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index() {
		//Migration
		$this->load->library('migration');
		$this->migration->latest();
		
		$this->load->view('header');
		$this->load->view('page/start');
		$this->load->view('footer');
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */