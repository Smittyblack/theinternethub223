<h1>Members Page</h1>
<?php
	echo "<pre>";
	print_r($this->session->all_userdata());
	echo "</pre>";
?>

<a href='<?php echo base_url()."index.php/site/logout"; ?>'>Logout</a>