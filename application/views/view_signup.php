<td id="content">
<div id="content">
<?php

$signup_body = '';

$signup_body .=  validation_errors();

$signup_body .= form_open('index.php/site/signup_validation');

$signup_body .= '<table class="sign_up_table">';

$signup_body .= "<tr><td>Desired Username: </td>";
$signup_body .= '<td>'.form_input('username', $this->input->post('username')).'</td>';

$signup_body .= "<tr><td>Email:</td>";
$signup_body .= '<td>'.form_input('email', $this->input->post('email')).'</td>';

$signup_body .= "<tr><td>Password:</td>";
$signup_body .= '<td>'.form_password('password');

$signup_body .= "<tr><td>Confirm Password:</td>";
$signup_body .= '<td>'.form_password('cpassword').'</td>';

$signup_body .= '<tr><td colspan="2"><div class="signup_submit_button">'.form_submit('signup_submit', 'Sign up').'</span></td>';

$signup_body .= '</table>';

$signup_body .= form_close();

echo $this->model_content->pod("Sign Up", $signup_body, "signup_pod");

?>
</td>
</tr>
</table>