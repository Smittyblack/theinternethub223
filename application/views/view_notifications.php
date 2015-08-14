
<td id="content">

<div id="content">

<!-- h1 class="page_header">Home</h1 -->

<div class="page_body">

<?php

$notes = '<table id="notifications">';

foreach($notifications as $row)
{
	$notes .= '<tr><td>';
	
	$notes .= $row['initiator'];
	switch($row['app'])
	{
		case 'mail':
			$notes .= " sent you an email.";
			break;
		case 'friends':
			if($row['type'] == 'add_friend')
			{
				$notes .= ' sent you a friend request.';
			}
			break;
		default:
			$notes .= " Error: The app '".$row['app']."' is not in the system.";
			break;
	}
	
	$notes .= '</td></tr>';
}

$notes .= '</table>';

echo $this->model_content->pod('Notifications', $notes);

?>

</div>

</div>
</td>
</tr></table>
