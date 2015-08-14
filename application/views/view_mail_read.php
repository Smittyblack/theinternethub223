
<td id="content">

<div id="content">

<!-- h1 class="page_header">Home</h1 -->

<div class="page_body">
<?php

$mail_body = '';

$query = $this->db->get_where('mail', array('username' => $this->session->userdata('username'), 'sender' => $sender));
$query2 = $this->db->get_where('mail', array('username' => $sender, 'sender' => $this->session->userdata('username')));

if($query->num_rows == 0)
{
	$mail_body = "Can't find that email";
}
else
{
	foreach($query->result_array() as $row)
	{
		$mail_body .= '<div class="mail_info">';
		$mail_body .= 'From: '.$row['sender'].'<br />';
		$mail_body .= 'Subject: '.$row['subject'].'<br />';
		$mail_body .= 'Date: '.$row['date_time'].'<br />';
		$mail_body .= '</div>';
		$mail_body .= '<div class="mail_body">'.$row['message'].'</div>';
		
	}
}

echo $this->model_content->pod('Mail', $mail_body);

?>
</div>

</div>
</td>
</tr></table>

