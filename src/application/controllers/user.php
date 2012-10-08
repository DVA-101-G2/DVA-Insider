<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	
	public function index() {
		//Troligtvis kan vi ha användarprofilen här så vi kan använda /user/<id_nummer> här
	}
	
	public function register() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'E-postadress', 'required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('password', 'Lösenord', 'required|min_length[5]|max_length[18]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Bekräfta Lösenord', 'required');
		$this->form_validation->set_rules('firstname', 'Förnamn', 'required|max_length[25]');
		$this->form_validation->set_rules('surname', 'Efternamn', 'required|max_length[25]');
		
		if (!$this->form_validation->run()) {
			$this->load->view('user/register');
		}
		else {
			$fields = $this->usermodel->register(
				$this->input->post('email'),
				$this->input->post('password'),
				array(
					'user_firstname' => htmlentities($this->input->post('firstname')),
					'user_surname' => htmlentities($this->input->post('surname'))
				)
			);
			$this->load->library('email', array('mailtype' => 'html'));
			$this->email->from('noreply@dvainsider.se');
			$this->email->to($this->input->post('email')); 
			$this->email->subject('Verifikation av epostaddress');
			$this->email->message($this->load->view('user/email_authentication', $fields, true));	
			$this->email->send();
			
			echo "Registering gjordes och ett e-postmeddelande har skickats till den angivna e-postadressen med instuktioner om hur du slutför registeringen.";
		}
	}
	
	public function email_authentication() {
		$userid = $this->uri->segment(3);
		$verifycode = $this->uri->segment(4);
		if(!$userid || !$verifycode) {
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