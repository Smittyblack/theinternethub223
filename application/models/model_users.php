<?php

class Model_users extends CI_Model{
	
	public function can_log_in(){
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1){
			return true;
		} else{
			return false;
		}
	}
	
	public function add_user($userkey){
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'userkey' => $userkey
		);
		
		$query = $this->db->insert('users', $data);
		if($query){
			return true;
		} else{
			return false;
		}
	}
	
	public function is_valid_key($userkey){
		$this->db->where('userkey', $userkey);
		$query = $this->db->get('temp_users');
		
		if($query->num_rows() == 1){
			return true;
		} else return false;
	}
	
	public function activate_user($userkey){
		$this->db->where('userkey', $userkey);
		$temp_user = $this->db->get('users');
		if($temp_user){
			$row = $temp_user->row();
			$data = array(
				'activated' => '1'
			);
			$this->db->where('userkey', $userkey);
			$this->db->set('join_date', 'NOW()', false);
			$this->db->update('user_data', $data);
			return $row->username;
		} return false;
	}
	
	function get_user_data($user){
		$query = $this->db->get_where('users', 'username', $user);
		return $query->result();
	}
	
	function get_all_users(){
		$query = $this->db->query("SELECT * FROM users");
		
		return $query->result();
	}
	
}