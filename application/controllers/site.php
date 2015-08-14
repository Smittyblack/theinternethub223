<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller{

	public function page($view, $data=null, $type='default')
	{
		$data['page_type'] = $type;
		$this->default_header($data, $type);
		$this->load->view($view, $data);
		$this->load->view('site_footer', $data);
	}
	
	public function default_header($data=null, $type='default')
	{
		$data['title'] = 'TIH';
		$data['page_type'] = $type;
		$this->load->view("site_header", $data);
		$this->load->view("site_nav");
		$this->load->model('model_content');
		$this->load->model('model_blog');
		$this->load->view("site_sidebar", $data);
	}
	
	public function index(){
		$this->load->model('model_content');
		$data["page_title"] = "TIH";
		$data['top_rated_result'] = $this->model_content->get_top_rated_content('content_images');
		$data['most_recent_result'] = $this->model_content->get_most_recent_content('content_images');
		$this->page('view_home', $data);
	}
	
	public function user($user, $ext=null, $ext2=null, $ext2ID=null)
	{
		$data['user'] = $user;
		$data['page_title'] = $user."'s Profile";
		$data['error'] = "";
		$data['page_type'] = 'user_profile';
		$data['ext'] = $ext;
		$data['ext2'] = $ext2;
		$data['ext2ID'] = $ext2ID;
		$data['avatar_error_message'] = "";
		if($this->input->post('edit_about'))
		{
			$insert_data = array(
				'about' => $this->input->post('about')
			);
			$this->db->where('username', $this->session->userdata('username'));
			$query = $this->db->update('user_data', $insert_data);
		}
		if($this->input->post('upload_avatar'))
		{
			//upload avatar
			$config['upload_path'] = './avatars/'.$user;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = true;
			$config['max_size'] = '100000'; //around 100 kb
			$config['max_width'] = '512';
			$config['max_height'] = '512';
			$config['file_name'] = 'avatar';
			
			$this->load->library('upload', $config);
			
			$new_avatar = $this->input->post('avatar');
			if(!is_dir('avatars'))
			{
				mkdir('./avatars', 0777, true);
			}
			if(!is_dir('avatars/'.$user))
			{
				mkdir('./avatars/'.$user, 0777, true);
			}
			if($this->upload->do_upload('avatar'))
			{
				//upload successfull
				$data['avatar_error_message'] = 'Success!';
				redirect(base_url().'index.php/site/user/'.$user);
				//exit();
			}
			else
			{
				//upload failed
				$data['avatar_error_message'] = 'Failed to upload the Avatar';
			}
			
		}
		$this->load->model('model_content');
		//$this->load->view("site_header", $data);
		//$this->load->view("site_nav");
		//$this->load->view("site_sidebar", $data);
		$this->load->model('model_users');
		$data['user_data'] = $this->model_users->get_user_data($user);
		$data['user_content'] = $this->model_content->get_user_content($user);
		//$this->load->view("view_user", $data);
		$this->page('view_user', $data, 'user_profile');
	}
	
	public function content()
	{
		$this->load->model("model_content");
		$data['top_rated_result'] = $this->model_content->get_top_rated_content('content_images');
		$data['most_recent_result'] = $this->model_content->get_most_recent_content('content_images');
		$this->page('view_content', $data);
	}
	
	public function view($content_title, $content_id)
	{
		$this->load->model('model_content');
		$data['content_data'] = $this->model_content->get_content_data($content_id);
		$this->page('view_view', $data, 'view');
	}
	
	public function edit_profile($user)
	{
		$data = array('user' => $user, 'page_title' => $user."'s Profile");
		$this->default_header($data);
		//$this->form_validation->set_rules('', '');
		$data = array('user' => $user, 'message' => 'Edit successful!', 'error' => "");
		
		$passed = true;
		
		//upload avatar
		$config['upload_path'] = './avatars/'.$user;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['overwrite'] = true;
		$config['max_size'] = '500000'; //around 500 kb
		$config['max_width'] = '1800';
		$config['max_height'] = '2048';
		$config['file_name'] = 'avatar';
		
		$this->load->library('upload', $config);
		
		if(!is_dir('avatars'))
		{
			mkdir('./avatars', 0777, true);
		}
		if(!is_dir('avatars/'.$user))
		{
			mkdir('./avatars/'.$user, 0777, true);
		}
		if(!$this->upload->do_upload('avatar'))
		{
			$passed = false;
		}
		
		//upload profile image
		$config['upload_path'] = './profile_images/'.$user;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['overwrite'] = true;
		$config['max_size'] = '1000000'; //around 1mb
		$config['max_width'] = '1800';
		$config['max_height'] = '2048';
		$config['file_name'] = 'profile_image';
		
		$this->load->library('upload', $config);
		
		if(!is_dir('profile_images'))
		{
			mkdir('./profile_images', 0777, true);
		}
		if(!is_dir('profile_images/'.$user))
		{
			mkdir('./profile_images/'.$user, 0777, true);
		}
		if(!$this->upload->do_upload('profile_image'))
		{
			$passed = false;
		}
		
		if($passed)
		{
			$this->load->view('view_user', $data);	
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('view_user', $error);
		}
	}
	
	public function upload(){
		$this->default_header(array('page_title' => 'TIH - Upload'));
		$this->load->model("model_upload");
		$data = array('error' => "");
		$this->load->view("view_upload", $data);
		$this->load->view('site_footer');
	}
	
	public function upload_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
		$this->form_validation->set_rules('author_comment', 'Author Comment', 'trim|xss_clean');
		//$this->form_validation->set_rules('file', 'Image File', 'required');
		if($this->form_validation->run()){
			
			$this->load->model('model_upload');
			$insert_id = $this->model_upload->add_upload();
			if($insert_id != false){
				
				$folder = $this->input->post('title');
				
				//upload the file
				$config['file_name'] = 'image';
				$config['upload_path'] = './uploads/'.$folder.'/'.$insert_id;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['overwrite'] = true;
				$config['max_size'] = '5000000';
				$config['max_width'] = '1800';
				$config['max_height'] = '2048';
				
				$this->load->library('upload', $config);
				
				if(!is_dir('uploads'))
				{
					mkdir('./uploads', 0777, true);
				}
				$dir_exists = true;
				if(!is_dir('uploads/' . $folder))
				{
					mkdir('./uploads/' . $folder, 0777, true);
					$dir_exists = false;
				}
				mkdir('./uploads/'.$folder.'/'.$insert_id, 0777, true);
				
				if($this->upload->do_upload('file'))
				{
				
					$error = array();
					$success = array();
					
					//file succesfully uploaded
					$upload_data = $this->upload->data();
					
					//calculate size of thumbnail
					$width = $upload_data['image_width'];
					$height = $upload_data['image_height'];
					$maxWidth = 200;
					$maxheight = 200;
					$ratio = min(array($maxWidth / $width, $maxheight / $height));
					$newWidth = $ratio * $width;
					$newHeight = $ratio * $height;
					
					//save a thumbnail image
					$resize_conf = array(
						'source_image' => $upload_data['full_path'],
						'new_image' => $upload_data['file_path'].'thumb.jpg',
						'width' => $newWidth,
						'height' => $newHeight
					);
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					if( ! $this->image_lib->resize())
					{
						$error['resize'][] = $this->image_lib->display_errors();
					}
					else
					{
						$success[] = $upload_data;
					}
					
					
					//insert additional file info into the database. 
					//NOTE: all database insertion should actually be done here. stuff from above should be moved down here
					
					$ext = $upload_data['file_ext'];
					$raw_name = $upload_data['raw_name'];
					if($this->model_upload->add_file_data($insert_id, $raw_name, $ext))
					{
						if(count($error > 0))
						{
							$data['error'] = $error;
							$data['success'] = "";
						}
						else{
							$data['success'] = $upload_data;
							$data['error'] = "";
						}
						//success!
						$this->default_header(array('title' => 'TIH - Upload Success'));
						$this->load->view('view_upload_success', $data);
					}
					else{
						echo 'There was a problem uploading the file extension to the database. Please try again.';
					}
				} else{
					//file upload failed. removed directories and database row
					if(!$dir_exists){
						rmdir('./uploads/'.$folder);
					}
					else{
						rmdir('.uploads/'.$folder.$insert_id);
					}
					$this->model_upload->delete_upload($insert_id);
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('view_upload', $error);
				}
			} else{
				echo "File info failed to upload to the database. Please try again.";
			}
		} else {
			$data = array('error' => "Form failed to validate.");
			$this->load->view('view_upload', $data);
		}
	}
	
	public function contact(){
		$data["page_title"] = "TIH";
		$this->default_header($data);
		$this->load->view("view_contact");
		$this->load->view("site_footer");
	}
	
	public function community(){
		$data["page_title"] = "TIH";
		$this->default_header($data);
		
		$this->load->model("model_users");
		$data['result'] = $this->model_users->get_all_users();
		$this->load->view("view_community", $data);
		
		$this->load->view("site_footer");
	}
	
	public function signup(){
		$this->page('view_signup');
	}
	
	public function reset_password(){
		$this->page('view_reset_password');
	}
	
	public function login(){
		$data["page_title"] = "TIH Login";
		$this->default_header($data);
		
		$this->load->view("view_login");
		$this->load->view("site_footer");
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('index.php/site/login');
	}
	
	public function members(){
		if($this->session->userdata('is_logged_in')){
			$this->load->view('view_members');
		} else{
			redirect('index.php/site/restricted');
		}
	}
	
	public function restricted(){
		$this->load->view('view_restricted');
	}
	
	public function login_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
		
		if($this->form_validation->run()){
			$data = array(
				'username' => $this->input->post('username'),
				'logged_in' => 1
			
			);
			$this->session->set_userdata($data);
			redirect('index.php/site/');
		} else{
			$this->page('view_login');
		}
	}
	
	public function signup_validation(){
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
		
		$this->form_validation->set_message('is_unique', "That %s is already in use.");
		
		if($this->form_validation->run())
		{
			//generate random key
			$userkey = md5(uniqid());
			
			//send confirmation email
			$this->load->library('email', array('mailtype'=>'html'));
			
			$this->email->from('sagan.tucker@gmail.com', "TIH");
			$this->email->to($this->input->post('email'));
			$this->email->subject("Confirm your account.");
			
			$message = '<p>Thank you for signing up to The Internet Hub<p>';
			$message .= '<p><a href="'.base_url().'index.php/site/activate/'.$userkey.'" >Click here</a> to confirm your account.<p>';
			
			$this->email->message($message);
			
			//add user to database
			$this->load->model('model_users');
			if( $this->model_users->add_user($userkey)){
				if($this->email->send()){
					echo "An email has been sent to ".$this->input->post('email');
					echo "<br />";
					echo $message;
				} else echo "Could not send the email.";
			} else echo "Problem adding user to database.";
			
		} 
		else
		{
			$this->load->view('view_signup');
		}
	}
	
	public function validate_credentials(){
		$this->load->model('model_users');
		
		if($this->model_users->can_log_in()){
			return true;
		} else{
			$this->form_validation->set_message('validate_credentials', 'Incorrect username or password.');
			return false;
		}
	}
	
	public function activate($userkey){
		$this->load->model('model_users');
		
		if($this->model_users->is_valid_key($userkey)){
			if($newuser = $this->model_users->activate_user($userkey)){
				echo "success";
				
				$data = array(
					'username' => $newuser,
					'is_logged_in' => 1
				);
				$this->session->set_userdata($data);
				redirect('index.php/site/members');
			} else echo "Failed to add user, please try again.";
		} else{
			echo "invalid key";
		}
	}
	
	public function news_post()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|trim');
		$this->form_validation->set_rules('post', 'Post', 'required|trim');
		if($this->form_validation->run())
		{
			$this->load->model('model_blog');
			if($this->model_blog->add_news_post())
			{
				echo 'post successful';
			}
			else
			{
				echo 'post unsuccessful';
			}
		}
		$this->load->helper('form');
		$this->page('view_news_post');
	}
	
	public function post($id, $title)
	{
		$data['post_id'] = $id;
		$query = $this->db->get_where('posts', array('id' => $id));
		foreach($query->result_array() as $row)
		{
			$data['post_title'] = $row['title'];
			$data['author'] = $row['username'];
			$data['post_body'] = $row['body'];
			$data['date'] = $row['created'];
		}
		$this->page('view_post', $data);
	}
	
	public function add_friend($friend)
	{
		$this->load->model('model_notifications');
		$data['friend'] = $friend;
		$friend_data = array(
			'user1' => $this->session->userdata('username'),
			'user2' => $friend
		);
		$this->db->set('datemade', 'NOW()', FALSE);
		$this->db->insert('friends', $friend_data);
		$this->model_notifications->send_notification($friend, $this->session->userdata('username'), 'friends', 'add_friend');
		$this->page('view_friend_added', $data);
	}
	
	public function notifications()
	{
		$this->load->model('model_content');
		$query = $this->db->get_where('notifications', array('username' => $this->session->userdata('username')));
		$data['notifications'] = $query->result_array();
		/*
		foreach($query->result_array() as $row)
		{
			$data['initiator'] = $row['initiator'];
			$data['app'] = $row['app'];
			$data['note'] = $row['note'];
			$data['did_read'] = $row['did_read'];
			$data['date_time'] = $row['date_time'];
		}
		*/
		$this->page('view_notifications', $data);
	}
	
	public function mail($action=null, $sender=null)
	{
		$this->load->model('model_content');
		if($action == 'read')
		{
			$data['sender'] = $sender;
			$this->page('view_mail_read', $data);
		}
		else
		{
			$this->page('view_mail');
		}
	}
}