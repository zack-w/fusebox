<?php

class Message {
	
	protected $_ci;
	
	public function __construct() {
		$this->_ci = & get_instance();
		$this->_ci->load->library("session");
	}
	
	public function msg($text) {
		$this->_ci->session->set_flashdata('message', $text);
	}
	
	public function error($text) {
		$this->_ci->session->set_flashdata('messageError', $text);
	}
	
	public function success($text) {
		$this->_ci->session->set_flashdata('messageSuccess', $text);
	}
	
	public function setData(&$data) {
		$message = $this->_ci->session->flashdata('message');
		$messageError = $this->_ci->session->flashdata('messageError');
		$messageSuccess = $this->_ci->session->flashdata('messageSuccess');
		
		if (!empty($message)) 
			$data["message"] = $message;
		if (!empty($messageError))
			$data["messageError"] = $messageError;
		if (!empty($messageSuccess))
			$data["messageSuccess"] = $messageSuccess;
	}
	
}
?>