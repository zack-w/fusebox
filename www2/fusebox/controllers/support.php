<?php 

if (!defined('BASEPATH')) die();

class Support extends SF_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->requireLogin();
		$this->load->model("support_model");
	}
	
	public function index(){
		$this->header("Support");
		
		$tickets = $this->support_model->getTickets();
		foreach ($tickets as $i => &$ticket) {
			$replies = $this->support_model->findRepliesByTicket($ticket["id"]);
			$lastreply = end($replies);
			$ticket["replies"] = count($replies);
			if (!$lastreply) {
				$ticket["lastupdated"] = 0;
				$ticket["lastuser"] = "You";
			} else {
				$ticket["lastupdated"] = $lastreply["timestamp"];
				$ticket["lastuser"] = $this->ion_auth->user($lastreply["user"])->row()->username;
			}
			$ticket["status"] = ($ticket["closed"] == 1) ? "Closed" : "Open";
		}
		
		$this->data["tickets"] = $tickets;
		
		$this->view("v_support");
		
		$this->footer();
	}

	public function ticket($id) {
		$this->header("PacketCat - View Ticket");
		$this->navbar();
		
		$original = $this->support_model->findTicket($id);
		$original["username"] = $this->ion_auth->user($original["owner"])->row()->username;
		
		$replies = $this->support_model->findRepliesByTicket($id);
		foreach ($replies as $k => &$v) {
			$v["username"] = $this->ion_auth->user($v["user"])->row()->username;
		}
		
		$this->data["original"] = $original;
		$this->data["replies"] = $replies;
		
		$this->view("v_support_ticket");
		
		$this->footer();
	}
	
	public function ticket_create() {
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
		if ($this->form_validation->run()) {
			$this->support_model->postTicket($this->input->post("title"), $this->input->post("message"));
			$this->message->success("Ticket Posted!");
		} else {
			$this->message->error(validation_errors());
		}
		redirect("support");
	}
	
	public function ticket_close($id) {
		$this->support_model->updateStatus($id, 1);
		$this->message->success("Ticket Closed");
		redirect("support");	
	}
	public function ticket_open($id) {
		$this->support_model->updateStatus($id, 0);
		$this->message->success("Ticket Opened");
		redirect("support");	
	}
	
}

?>