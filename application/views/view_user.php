
<td id="content">


<div id="content">

<?php

echo $error;

if($user == $this->session->userdata('username'))
{
	$this->session->set_userdata('is_own_page', '1');
}
else{
	$this->session->set_userdata('is_own_page', '0');
}

echo '<a href="'.base_url().'index.php/site/user/'.$user.'/wall/">Wall</a>';
echo ' | ';
echo '<a href="'.base_url().'index.php/site/user/'.$user.'/content/">Content</a>';
echo ' | ';
echo '<a href="'.base_url().'index.php/site/user/'.$user.'/about/">About</a>';

if($ext == 'content')
{
	$user_images = '';
	foreach($user_content as $row)
	{
		$user_images .= $this->model_content->content_thumb($row->title, $row->id);
	}

	echo $this->model_content->pod("Images", $user_images);
}

else if($ext == 'upload_post')
{
	$wall_content = '';
	
	$data = array(
		'username' => $user,
		'poster' => $this->session->userdata('username'),
		'content' => $this->input->post('wall_post'),
		'type' => 'text',
		'title' => $this->input->post('wall_post_title'),
		'image_path' => 'null'
	);
	$this->db->set('date_time', 'NOW()', FALSE);
	$query = $this->db->insert('wall', $data);
	if($query){
		header('Location: '.base_url().'index.php/site/user/'.$user.'/wall');
		exit;
	} else{
		$wall_content .= 'Sorry, there was an error. Please try again later.';
	}
}

else if($ext == 'wall' || $ext == null || $ext == 'post')
{
	$wall_content = '';
	
	if($ext == 'post')
	{
		$wall_content .= form_open('index.php/site/user/'.$user.'/upload_post');
		$wall_content .= form_input('wall_post');
		$wall_content .= form_submit('wall_post_submit', "Post");
		$wall_content .= form_close();
	}
	
	$this->db->where(array('username' => $user));
	$this->db->order_by('date_time', 'desc');
	$query = $this->db->get('wall');
	if($query->num_rows() == 0)
	{
		$wall_content .= 'There are no posts on '.$user.'\'s wall yet.<br />';
	}
	if(($this->session->userdata('logged_in') == 1) && ($this->session->userdata('is_own_page') == '0'))
	{
		$wall_content .= '<a href="'.base_url().'index.php/site/user/'.$user.'/post">Post on '.$user.'\'s wall.</a><br />';
	}
	
	foreach($query->result_array() as $row)
	{
		if($row['is_reply'] == 'no')
		{
			$wall_content .= $this->model_content->wall_post($row['id'], $row['username'], $row['date_time'], $row['poster'], $row['title'], $row['content'], $row['image_path']);
			
			$wall_content .= $this->model_content->check_for_replies($row['id'], $user);
			/*
			$query2 = $this->db->get_where('wall', array('username' => $user, 'is_reply' => 'yes', 'reply_to' => $row['id']));
			if($query2->num_rows() != 0)
			{
				foreach($query2->result_array() as $row2)
				{
					$wall_content .= $this->model_content->wall_reply($row2['id'], $row2['username'], $row2['date_time'], $row2['poster'], $row2['content'], $row2['image_path']);
				}
			}
			*/
		}
		if($ext2 == "reply" && $ext2ID == $row['id'])
		{
			$wall_content .= $this->model_content->wall_reply_form($row['id'], $row['username']);
		}
	}
	
	if($ext2 == "reply_submit")
	{
		$data = array(
			'username' => $user,
			'poster' => $this->session->userdata('username'),
			'content' => $this->input->post('wall_reply'),
			'type' => 'text',
			'image_path' => 'null',
			'is_reply' => 'yes',
			'reply_to' => $ext2ID
		);
		$this->db->set('date_time', 'NOW()', FALSE);
		$query = $this->db->insert('wall', $data);
		if($query){
			header('Location: '.base_url().'index.php/site/user/'.$user.'/wall');
			exit;
		} else{
			$wall_content .= 'Sorry, there was an error. Please try again later.';
		}
	}
	
	echo $this->model_content->pod("Wall", $wall_content);
}
else if($ext == 'about')
{		
	$about = '';
	$query = $this->db->get_where('user_data', array('username' => $this->session->userdata('username')));
	if($ext2 == 'edit')
	{
		foreach($query->result_array() as $row)
		{
			$about .= form_open(base_url().'index.php/site/user/'.$this->session->userdata('username').'/about');
			$about .= 'About you: '.form_input('about', $row['about']);
			$about .= form_submit('edit_about', "Update");
			$about .= form_close();
		}
	}
	else
	{
		foreach($query->result_array() as $row)
		{
			if($row['about'] == "")
			{
				if($is_own_page)
				{
					$about .= 'You haven\'t added anything yet. Click <a class="edit_button" href="'.base_url().'index.php/site/user/'.$this->session->userdata('username').'/about/edit">HERE</a> to edit.';
				}
				else
				{
					$about .= "User has not added info about themselves yet.";
				}
			}
			else
			{
				$about .= $row['about'].' <a class="edit_button" href="'.base_url().'index.php/site/user/'.$this->session->userdata('username').'/about/edit">EDIT</a>';
			}
		}
	}
	echo $this->model_content->pod("About", $about);
}
/*
if($is_own_page){
	echo "Welcome! Edit?<br />";
	
	echo form_open_multipart('index.php/site/edit_profile/'.$user);	
}

echo '<img class="user_avatar" src="'.base_url().'avatars/'.$user.'/avatar.png" />';


if($is_own_page){

	echo '<br />Edit Avatar: ';
	echo form_upload('avatar');
	echo '<br />';
}


echo '<img class="user+profile_image" src="'.base_url().'profile_images/'.$user.'/profile_image" />';

if($is_own_page){
	
	echo 'Edit Profile Image: ';
	echo form_upload('profile_image');
	echo '<br />';
}


if($is_own_page){
	
	echo 'Edit Blurb: ';
	echo form_input('blurb');
	echo '<br />';
	
	echo 'Edit About: ';
	echo form_input('about');
	echo '<br />';
	
	echo form_submit('edit_submit', "Save Changes");
	echo form_close();
}
*/
?>

</div>

</td>
</tr>
</table>