<td id="content">
<div id="content">
<?php
$title = 'Login';
$body = '';
if($this->session->userdata('is_logged_in'))
{ 
	$body .= '<p>You are already logged in.</p><p>Would you like to <a href="'.base_url().'index.php/site/logout">Log out</a>?</p>';
}
else
{
	$this->load->helper("form");
	
	$body .= form_open("index.php/site/login_validation");

	$body .= validation_errors();
	
	$body .= '<table id="login_table"><tr>';
	
	$body .= '<td>Username: </td><td>';
	$body .= form_input('username', $this->input->post('username'));
	$body .= "</td></tr>";

	$body .= '<td>Password: </td><td>';
	$body .= form_password('password');
	$body .= '</td></tr>';

	$body .= '<tr><td colspan="2"><div id="login_button">';
	$body .= form_submit('login_submit', "Login");
	$body .= '</div></td></tr></table>';

	$body .= form_close();
}

$body .= '<a class="sign_up" href="'.base_url().'index.php/site/signup">Sign up</a>';

$body .= '<a class="forgot_password" href="'.base_url().'index.php/site/reset_password">Forgot Password?</a>';

echo $this->model_content->pod($title, $body, "login_pod");

?>
</td>
</tr>
</table>
