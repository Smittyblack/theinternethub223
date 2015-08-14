
<tr>
<td id="sidebar">
<div id="sidebar">
	<?php 
	
	if($page_type == 'user_profile')
	{
		if($user == $this->session->userdata('username'))
		{
			$is_own_page = true;
		}
		else{
			$is_own_page = false;
		}
		echo '<div id="user_box">';
		echo '<h1>'.$user.'</h1>';
		
		echo '<img class="user_profile_avatar" src="'.base_url().'avatars/'.$user.'/avatar.png" />';
		
		echo '</div>';
		
		echo '<div id="user_page_buttons">';
		if($is_own_page)
		{
			if($ext != 'edit')
			{
				echo '<a href="'.base_url().'index.php/site/user/'.$user.'/edit" class="user_page_button">Edit Avatar</a>';
			}
		}
		else
		{
			if($this->session->userdata('logged_in'))
			{
				echo '<a href="'.base_url().'index.php/site/add_friend/'.$user.'" class="user_page_button">Add Friend</a>';
			}
		}
		
		if($ext == 'edit' && $user == $this->session->userdata('username'))
		{
			$a_title = 'Edit Your Avatar';
			$a_body = '';
			//$a_body .= '<div class="user_avatar_edit_box">';
			$a_body .= form_open_multipart(base_url().'index.php/site/user/'.$user.'/edit');
			$a_body .= form_upload('avatar');
			$a_body .= form_submit('upload_avatar', 'Upload Avatar');
			$a_body .= form_close();
			$a_body .= $avatar_error_message;
			//$a_body .= '</div>';
			
			echo $this->model_content->pod($a_title, $a_body);
		}
		echo '</div>';
		
		echo '<div id="user_friends_box">';
		
		$friends = '';
		$query = $this->db->get_where('friends', array('user1' => $user, 'accepted' => '1'));
		if($query->num_rows() == 0)
		{
			//
		}
		else
		{
			foreach($query->result_array() as $row)
			{
				$friends .= '<a href="'.base_url().'index.php/site/user/'.$row['user2'].'"><img class="user_avatar" src="'.base_url().'avatars/'.$row['user2'].'/avatar.png" /></a>';
			}
		}
		$query = $this->db->get_where('friends', array('user2' => $user, 'accepted' => '1'));
		if($query->num_rows() == 0)
		{
			//
		}
		else
		{
			foreach($query->result_array() as $row)
			{
				$friends .= '<a href="'.base_url().'index.php/site/user/'.$row['user1'].'"><img class="user_avatar" src="'.base_url().'avatars/'.$row['user1'].'/avatar.png" /></a>';
			}
		}
		if($friends == "")
		{
			$friends = "User has no friends yet! :(";
		}
		echo $this->model_content->pod("Friends", $friends);
		echo '</div>';
	}
	
	if($page_type == 'view')
	{
		echo '<div class="content_info">';
		foreach($content_data as $row)
		{
			$title = $row->title;
			$body = '<h2>By <a href="'.base_url().'index.php/site/user/'.$row->username.'">'.$row->username.'</a></h2>';
		}
		echo $this->model_content->pod($title, $body);
		echo '</div>';
	}
	
	if($page_type == 'default')
	{
		//admin section
		if($this->session->userdata('logged_in') == 1)
		{
			$username = $this->session->userdata('username');
			$query = $this->db->get_where('users', array('username' => $username));
			foreach($query->result_array() as $row)
			{
				if($row['userlevel'] = 'd')
				{
					$is_admin = true;
				}
			}
			if($is_admin)
			{
				$admin_panel = "";
				$admin_panel .= $this->model_content->pod('Hello ' . $username . '!', 'Click <a href="'.base_url().'index.php/site/news_post">here</a> to make a news post!');
				echo $admin_panel;
			}
		}
		//news section
		$news_title = 'News';
		$news_body = '';
		$this->db->order_by('created', 'desc');
		$query = $this->db->get_where('posts', array('category' => 'site_news'), 4);
		if($query->num_rows() == 0)
		{
			$news_body .= 'There are no news posts yet.';
		}
		else{
			$pre = 'a';
			$news_body .= '<table id="news_preview">';
			foreach($query->result_array() as $row)
			{
				$news_body .= $this->model_blog->news_post($pre, $row['id'], $row['title'], $row['username'], $row['created']);
				$pre = ($pre == 'a' ? 'b':'a');
			}
			$news_body .= '</table>';
		}
		echo $this->model_content->pod($news_title, $news_body);
	}
	?>
	
</div>
</td>


