<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		$this->load->library('image_lib');
	}
	
	function index()
	{
		$this->load->view('upload', array('error' => ' ', 'success' => ' '));
	}
	
	function do_upload()
	{
		$upload_conf = array(
			'upload_path' => realpath('images/'),
			'allowed_types' => 'gif|jpg|png|jpeg',
			'max_size' => '300000'
		);
		
		$this->upload->initialize($upload_conf);
		
		foreach($_FILES['userfile'] as $key=>$val)
		{
			$i = 1;
			foreach($val as $v)
			{
				$field_name = "file_".$i;
				$_FILES[$field_name][$key] = $v;
				$i++;
			}
		}
		
		unset($_FILES['userfile']);
		
		$error = array();
		$success = array();
		
		foreach($_FILES as $field_name => $file)
		{
			if(!$this->upload->do_upload($field_name))
			{
				$error['upload'][] = $this->upload->display_errors();
			}
			else
			{
				$upload_data = $this->upload->data();
				
				//database insertion goes here
				
				$resize_conf = array(
					//change to full path to the image
					'source_image' => $upload_data['full_path'],
					//change the following as well
					'new_image' => $upload_data['file_path'].'thumb_'.$upload_data['file_name'],
					//set the width and height here
					'width' => 200,
					'height' => 200
				);
				
				$this->image_lib->initialize($resize_conf);
				
				if(!$this->image_lib->resize())
				{
					$error['resize'][] = $this->image_lib->display_errors();
				}
				else
				{
					$success[] = $upload_data;
				}
			}
		}
		
		if(count($error > 0))
		{
			$data['error'] = $error;
		}
		else
		{
			$data['success'] = $upload_data;
		}
		
		$this->load->view('upload', $data);
	}
}