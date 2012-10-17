<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	
	public function index() {
		$this->load->view('header');
		$this->load->view('user/profile');
		$this->load->view('footer');
	}
	
	public function register() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'E-postadress', 'required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('password', 'Lösenord', 'required|min_length[5]|max_length[18]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Bekräfta Lösenord', 'required');
		$this->form_validation->set_rules('firstname', 'Förnamn', 'required|max_length[25]');
		$this->form_validation->set_rules('surname', 'Efternamn', 'required|max_length[25]');
		
		$this->form_validation->set_error_delimiters('', '');
		
		$this->form_validation->set_message('required', 'Detta fält måste fyllas i.');
		$this->form_validation->set_message('valid_email', 'Detta fält måste innehålla en giltig e-postadress.');
		$this->form_validation->set_message('is_unique', 'E-postadressen är redan registrerad, för mer information kontakta support@dvainsider.se.');
		$this->form_validation->set_message('min_length', '<!-- %s -->Detta fält måste vara längre än %s tecken.');
		$this->form_validation->set_message('max_length', '<!-- %s -->Detta fält får inte vara längre än %s tecken.');
		$this->form_validation->set_message('matches', 'Lösenorden matchar inte.');
		
		if (!$this->form_validation->run()) {
			$this->load->view('user/register');
		}
		else {
			$fields = $this->usermodel->register(
				$this->input->post('email'),
				$this->input->post('password'),
				array(
					'user_firstname' => htmlspecialchars($this->input->post('firstname')),
					'user_surname' => htmlspecialchars($this->input->post('surname'))
				)
			);
			$this->load->library('email', array('mailtype' => 'html'));
			$this->email->from('noreply@dvainsider.se');
			$this->email->to($this->input->post('email')); 
			$this->email->subject('Verifikation av epostaddress');
			$this->email->message($this->load->view('user/email_authentication', $fields, true));	
			$this->email->send();
			
			$this->load->view('user/register_success');
		}
	}
	
	public function image() {
		$userid = $this->uri->segment(3);
		if(!($userimage = $this->usermodel->get_user_image($userid))) {
			show_404();
			return;
		}
		$this->output->set_content_type('image/png')->set_output($userimage);
	}
	
	public function login() {
		$this->load->helper('form');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if(!$email OR !$password) {
			$this->load->view('user/login');
		}
		elseif($user = $this->usermodel->login($email, $password)) {
			$this->session->set_userdata('user_id', $user->user_id);
			$data['success'] = true;
			$this->load->view('user/login', $data);
		}
		else {
			$data['error'] = true;
			$this->load->view('user/login', $data);
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('');
	}
	
	public function email_authentication() {
		$userid = $this->uri->segment(3);
		$verifycode = $this->uri->segment(4);
		if(!$userid OR !$verifycode) {
			show_404();
			return;
		}
		
		if($this->usermodel->verify_email($userid, $verifycode)) {
			echo "Verifikation lyckades.";
		}
		else {
			echo "Verifikation mislyckades.";
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */