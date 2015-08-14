
<td id="content">

<div id="content">

<!-- h1 class="page_header">Home</h1 -->

<div class="page_body">
<?php

$query = $this->db->get_where('mail', array('username' => $this->session->userdata('username')));

if($query->num_rows == 0)
{
	$mail_body = "You have no mail.";
}
else
{
	$mail_body = '<table id="mailbox">';
	$mail_body .= '<tr><th class="mailbox_from">From</th><th class="mailbox_subject">Subject</th><th class="mailbox_date">Date</th></tr>';
	foreach($query->result_array() as $row)
	{
		$mail_body .= '<tr class="mailbox"><td class="mailbox_from"><a href="'.base_url().'index.php/site/user/'.$row['sender'].'">'.$row['sender'].'</a></td><td class="mailbox_subject"><a href="'.base_url().'index.php/site/mail/read/'.$row['sender'].'">'.$row['subject'].'</a></td><td class="mailbox_date">'.$row['date_time'].'</td></tr>';
	}
	$mail_body .= '</table>';
}

echo $this->model_content->pod('Mail', $mail_body);

?>
</div>

</div>
</td>
</tr></table>

