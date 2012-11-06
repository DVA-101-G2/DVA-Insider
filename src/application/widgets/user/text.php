<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Text extends User_Widget {
	public function Text() {
		parent::User_Widget("Text", "user", "text");
	}
	
	public function get() {
		$this->ci->load->view("widgets/user/text", $this->data);
	}
	
	public function config() {
		$content = $this->ci->input->post('content');
		if(!$content) {
			$this->ci->load->view("widgets/user/text_config", array('form' => true, 'data' => $this->data));
		}
		else
		{
			$this->data->content = $content;
			$this->update();
			$this->ci->load->view("widgets/user/text_config", array('form' => false));
		}
	}
	
	public function create() {
		$this->data->content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta, odio vel venenatis dapibus, mi tortor pretium quam, a aliquet enim libero in felis. Phasellus a mi enim, in aliquam lorem. Morbi pulvinar, purus a sollicitudin ornare, odio neque pretium libero, a faucibus dui mi vel nunc. Fusce quis lectus massa. Maecenas at ipsum non enim fringilla laoreet non et arcu. Donec in eros leo, eu fermentum dui. Proin tempor felis eu turpis fermentum quis laoreet dolor gravida. In nisl odio, eleifend quis adipiscing a, semper vel odio.

Fusce enim lorem, dapibus vel varius non, rhoncus ac felis. Morbi sollicitudin odio sed lectus semper fermentum. Phasellus rutrum dolor sit amet risus pharetra ullamcorper. Nulla facilisi. Morbi erat libero, ultrices quis ultricies at, aliquam nec odio. Quisque tempus, nisi in adipiscing laoreet, nunc nunc euismod arcu, in cursus nunc mauris eu augue. Aliquam at auctor dolor. Donec eget velit ac augue aliquet bibendum eget sed dui. Proin vulputate tempor volutpat. Cras in quam tortor. Morbi nec tortor orci. Duis nec enim non sem sagittis adipiscing.";
		$this->update();
	}
	
	public function delete() {
		
	}
}