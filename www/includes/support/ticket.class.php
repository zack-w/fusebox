<?php
	class Ticket {

		public $id;
		public $uid;
		public $subject;
		public $timestamp;
		public $priority;
		public $replys;


		public function __construct($id) {
			global $DB, $LANGUAGE;
			if($data = $DB->queryRow("SELECT * FROM support_tickets WHERE id = '".$DB->escape($id)."' LIMIT 1")) {
				$this->id = $id;
				$this->uid = $data['uid'];
				$this->subject = $data['subject'];
				$this->timestamp = $data['timestamp'];
				$this->priority = $data['priority'];

				switch ($this->priority) {
					case 0:
						$this->priority = $LANGUAGE["support_ticketPriority_low"];
						break;
					case 1:
						$this->priority = $LANGUAGE["support_ticketPriority_normal"];
						break;
					case 2:
						$this->priority = $LANGUAGE["support_ticketPriority_high"];
						break;
					default:
						$this->priority = $LANGUAGE["support_ticketPriority_unknown"];
				}

				if($replys = $DB->queryRow("SELECT * FROM support_tickets_replys WHERE tid = '".$DB->escape($id)."'")) {
					$this->replys = $replys;
				}
			}
		}

		public function ago() {
			global $LANGUAGE;
			$periods = $LANGUAGE['support_ticketTime_periods'];
			$periodsPl = $LANGUAGE['support_ticketTime_periodsPlural'];
			$lengths = array("60","60","24","7","4.35","12","10");

			$now = time();
			$difference     = $now - $this->timestamp;
			$timestamp_diff = $difference;

			for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				$difference /= $lengths[$j];
			}
			$difference = round($difference);
			if($difference != 1) {
				$periods[$j].= $periodsPl[$j];
			}
			
			if ($timestamp_diff < 5) {
				return $LANGUAGE['support_ticketTime_aFewSeconds'];
			}
			
			return "$difference $periods[$j]";
		}
	}