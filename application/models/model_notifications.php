<?php

class Model_Notifications extends CI_Model
{
	function send_notification($to_user, $from_user, $app, $type)
	{
		$insert_data = array(
			'username' => $to_user,
			'initiator' => $from_user,
			'app' => $app,
			'type' => $type
		);
		$this->db->set('date_time', 'NOW()', false);
		$this->db->insert('notifications', $insert_data);
	}
}
?>