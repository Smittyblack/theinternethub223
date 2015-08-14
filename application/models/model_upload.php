<?php

class Model_upload extends CI_Model
{
	function add_upload(){
		$data = array(
			'title' => $this->input->post('title'),
			'username' => $this->session->userdata('username'),
			'author_comment' => $this->input->post('author_comment')
		);
		
		$query = $this->db->insert('content_images', $data);
		if($query){
			$insert_id = $this->db->insert_id();
			return $insert_id;
		} else{
			return false;
		}
	}
	
	function delete_upload($id){
		$this->db->delete('content_images', array('id' => $id));
	}
	
	function add_file_data($id, $raw_name, $ext){
		$this->db->where('id', $id);
		$query = $this->db->update('content_images', array('filename'=> $raw_name, 'extension' => $ext));
		if($query){
			return true;
		}
		else{
			return false;
		}
	}
}

?>