<?php
class Support_model extends CI_Model {

    function __construct() {
        parent::__construct();
		
		$this->load->library("ion_auth");
		$this->user = $this->ion_auth->user()->row();
    }
	
	function getTickets($admin) {
		$query;
		if ($admin) {
			$query = $this->db->get("support_tickets");
		} else {
			$query = $this->db->where("owner", $this->user->id)->get("support_tickets");
		}
		
		return $query->result_array();
	}
	
	function findTicket($id) {
		return $this->db->where("id", $id)->get("support_tickets")->row_array();
	}
	
	function findReply($id) {
		return $this->db->where("id", $id)->get("support_replies")->row_array();
	}
	
	function findRepliesByTicket($id) {
		return $this->db->where("ticket", $id)->get("support_replies")->result_array();
	}
	
	function postTicket($title, $message) {
		$insert = array(
			"owner" => $this->user->id,
			"title" => $title,
			"closed" => 0,
			"message" => $message,
			"timestamp" => time()
		);
		
		$this->db->insert("support_tickets", $insert);
	}
	
	function postReply($ticketid, $message) {
		$insert = array(
			"user" => $this->user->id,
			"ticket" => $ticketid,
			"message" => $message,
			"timestamp" => time()
		);
		
		$this->db->insert("support_tickets", $insert);
	}
	
	function updateStatus($ticketid, $status) {
		return $this->db->where("id", $ticketid)->update("support_tickets", array('closed' => $status));
	}
	
}