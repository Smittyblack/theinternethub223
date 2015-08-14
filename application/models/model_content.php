<?php

class Model_content extends CI_Model
{
	public function pod($title, $content, $class=null)
	{
		if($class == null)
		{
			$pod  = '<div class="pod">';
		}
		else
		{
			$pod  = '<div class="pod '.$class.'">';
		}
		$pod .= '<div class="pod_header">';
		$pod .= '<h2 class="pod_title">'.$title.'</h2>';
		$pod .= '</div>';
		$pod .= '<div class="pod_body">';
		$pod .= '<div class="pod_content">'.$content.'</div>';
		$pod .= '</div>';
		$pod .= '</div>';
		return $pod;
	}
	
	public function wall_post($id, $user, $time, $poster, $title, $content, $image=null)
	{
		$wall_post = '<div class="wall_post">';
		$wall_post .= '<div class="wall_post_avatar_div"><img class="wall_post_avatar" src="'.base_url().'/avatars/'.$poster.'/avatar.png" /></div>';
		$wall_post .= '<div class="wall_post_body">';
		$wall_post .= '<div class="wall_post_user">'.$poster.'</div>';
		$wall_post .= '<div class="wall_post_time">'.date('F j, Y, g:i A', strtotime($time)).'</div>';
		$wall_post .= '<div class="wall_post_content">'.$content.'</div>';
		$wall_post .= '<div class="wall_post_options"><a class="reply_button" href="'.base_url().'index.php/site/user/'.$user.'/wall/reply/'.$id.'">reply</a><a class="upvote_button" href="#">+</a><a class="downvote_button" href="#">-</a><a class="report_button" href="#">!</a><a class="delete_button" href="#">X</a></div>';
		$wall_post .= '</div>';
		$wall_post .= '</div>';
		return $wall_post;
	}
	
	public function wall_reply_form($id, $user)
	{
		$wall_reply_form = '<div class="wall_reply">';
		$wall_reply_form .= '<img class="wall_reply_avatar" src="'.base_url().'avatars/'.$this->session->userdata('username').'/avatar.png" />';
		$wall_reply_form .= '<div class="wall_reply_form">';
		$wall_reply_form .= form_open(base_url().'index.php/site/user/'.$user.'/wall/reply_submit/'.$id);
		$wall_reply_form .= form_input('wall_reply');
		$wall_reply_form .= form_submit('submit_reply', 'Submit');
		$wall_reply_form .= form_close();
		$wall_reply_form .= '</div>';
		$wall_reply_form .= '</div>';
		return $wall_reply_form;
	}
	
	public function wall_reply($id, $user, $time, $poster, $content, $image=null)
	{
		$wall_reply = '<div class="wall_reply">';
		$wall_reply .= '<div class="wall_reply_avatar_div"><img class="wall_reply_avatar" src="'.base_url().'/avatars/'.$poster.'/avatar.png" /></div>';
		$wall_reply .= '<div class="wall_post_body">';
		$wall_reply .= '<div class="wall_post_user">'.$poster.'</div>';
		$wall_reply .= '<div class="wall_post_time">'.date('F j, Y, g:i A', strtotime($time)).'</div>';
		$wall_reply .= '<div class="wall_post_content">'.$content.'</div>';
		$wall_reply .= '<div class="wall_post_options"><a class="reply_button" href="'.base_url().'index.php/site/user/'.$user.'/wall/reply/'.$id.'">reply</a><a class="upvote_button" href="#">+</a><a class="downvote_button" href="#">-</a><a class="report_button" href="#">!</a><a class="delete_button" href="#">X</a></div>';
		$wall_reply .= '</div>';
		$wall_reply .= '</div>';
		return $wall_reply;
	}
	
	public function check_for_replies($id, $user)
	{
		$replies = '';
		$query = $this->db->get_where('wall', array('username' => $user, 'is_reply' => 'yes', 'reply_to' => $id));
		if($query->num_rows() != 0)
		{
			foreach($query->result_array() as $row)
			{
				$replies .= $this->model_content->wall_reply($row['id'], $row['username'], $row['date_time'], $row['poster'], $row['content'], $row['image_path']);
				$replies .= $this->model_content->check_for_replies($row['id'], $row['username']);
			}
		}
		return $replies;
	}
	
	public function comment_box()
	{
		
	}
	
	public function get_top_rated_content($db_table)
	{
		$query = $this->db->query('SELECT * FROM '.$db_table.' ORDER BY upvotes LIMIT 24');
		return $query->result();
	}
	
	public function get_most_recent_content($db_table)
	{
		$query = $this->db->query('SELECT * FROM '.$db_table.' ORDER BY upvotes LIMIT 24');
		return $query->result();
	}
	
	public function truncate($string, $length, $append='&hellip;')
	{
		if(strlen($string) > $length){
			$string = substr($string, 0, $length).$append;
			//$string = wordwrap($string, $length);
			//$string = explode(" ", $string, 2);
			//$string = $string[0] . $append;
		}
		return $string;
	}
	
	public function content_thumb($title, $id)
	{
		$thumb  = '<div class="content_thumb">';
		$thumb .= '<div class="content_thumb_header">';
		$thumb .= '<a href="'.base_url().'index.php/site/view/'.str_replace(' ', '_', $title).'/'.$id.'/">';
		$thumb .= '<h3 class="thumb_header">'.$this->truncate($title, 11, '&hellip;').'</h3>';
		$thumb .= '</a>';
		$thumb .= '</div>';
		$thumb .= '<div class="content_thumb_body">';
		$thumb .= '<a href="'.base_url().'index.php/site/view/'.str_replace(' ', '_', $title).'/'.$id.'/">';
		$thumb .= '<img class="content_thumb" src="'.base_url().'uploads/'.$title.'/'.$id.'/thumb.jpg" />';
		$thumb .= '</a>';
		$thumb .= '</div>';
		$thumb .= '</div>';
		return $thumb;
	}
	
	public function get_content_data($id)
	{
		$query = $this->db->get_where('content_images', array('id' => $id));
		return $query->result();
	}
	
	public function get_user_content($username)
	{
		$query = $this->db->get_where('content_images', array('username' => $username));
		return $query->result();
	}
}

?>