<?php

class Model_blog extends CI_Model
{
	public function add_news_post()
	{
		$data = array(
			'title' => ucfirst($this->input->post('title')),
			'category' => 'site_news',
			'username' => $this->session->userdata('username'),
			'body' => ucfirst($this->input->post('post'))
		);
		$this->db->set('created', 'NOW()', FALSE);
		$query = $this->db->insert('posts', $data);
		if($query){
			return true;
		} else{
			return false;
		}
	}
	
	public function news_post($pre, $id, $title, $author, $date)
	{
		$news_post = '';
		$news_post .= '<tr class="news_post_preview_'.$pre.'">';
		$news_post .= '<td class="news_post_preview_title"><a href="'.base_url().'index.php/site/post/'.$id.'/'.str_replace(' ', '_', $title).'">'.$this->model_content->truncate($title, 12).'</a></td>';
		$news_post .= '<td class="news_post_preview_author"><a href="'.base_url().'index.php/site/user/'.$author.'">'.$author.'</a></td>';
		$news_post .= '<td class="news_post_preview_date">'.date('M d, Y').'</td>';
		$news_post .= '</tr>';
		return $news_post;
	}
}
?>