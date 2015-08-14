<!DOCTYPE html>

<html lang="en">

<head>
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/TIH_styles.css" />
	<meta charset="utf-8" />
</head>

<body>
	
	<header>
		<div id="ctrl_panel">
			<div id="ctrl_login">
				<?php if($this->session->userdata('logged_in'))
				{
					//avatar with link to user's page
					echo '<a href="'.base_url().'index.php/site/user/'.$this->session->userdata('username').'">';
					echo '<img class="user_ctrl_avatar" src="'.base_url().'avatars/'.$this->session->userdata('username').'/avatar.png" />';
					echo '</a>';
					
					//notification icon
					echo '<a href="'.base_url().'index.php/site/notifications">';
					echo '<img class="ctrl_icon" src="'.base_url().'images/alert_icon_blue.gif" alt="notes"/>';
					echo '</a>';
					
					//mail icon
					echo '<a href="'.base_url().'index.php/site/mail">';
					echo '<img class="ctrl_icon" src="'.base_url().'images/mail_icon.png" alt="mail"/>';
					echo '</a>';
					
					//logout button
					echo '<a href="'.base_url().'index.php/site/logout" >';
					echo '<img class="logout_icon" src="'.base_url().'images/icon_logout.png" /></a>';
				} 
				else{
					//display login form
					echo form_open("index.php/site/login_validation");
					echo 'User: '.form_input('username');
					echo 'Password: '.form_password('password');
					echo form_submit('header_login_submit', 'Login');
					echo form_close();
				}
				?>
			</div>
		</div>
		<h1>
			<a href="<?php echo base_url(); ?>">
				<img id="logo" src="<?php echo base_url(); ?>images/logo.png" alt="Logo" />
			</a>
		</h1>
			
	</header>
	
	<table id="page_content">