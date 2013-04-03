<?php
	class Ticket {

		public $id;
		public $uid;
		public $subject;
		public $timestamp;
		public $priority;
		public $replys;


		public function __construct($id) {
			global $DB;
			if($data = $DB->queryRow("SELECT * FROM support_tickets WHERE id = '".$DB->escape($id)."' LIMIT 1")) {
				$this->id = $id;
				$this->uid = $data['uid'];
				$this->subject = $data['subject'];
				$this->timestamp = $data['timestamp'];
				$this->priority = $data['priority'];

				if($replys = $DB->queryRow("SELECT * FROM support_tickets_replys WHERE tid = '".$DB->escape($id)."'")) {
					$this->replys = $replys;
				}
			}
		}

		public function ago() {
			$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");

			$now = time();
			$difference     = $now - $this->timestamp;
			$timestamp_diff = $difference;
			$tense         = "ago";

			for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				$difference /= $lengths[$j];
			}
			$difference = round($difference);
			if($difference != 1) {
				$periods[$j].= "s";
			}
			
			if ($timestamp_diff < 5) {
				return "a few seconds";
			}
			
			return "$difference $periods[$j]";
		}
	}