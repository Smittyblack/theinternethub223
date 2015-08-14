<h1>Contact</h1>
Contact info.

<?php

function quickInput($label){
	echo form_label(ucfirst($label).": ", $label);
	
	$data = array(
		"name" => $label,
		"id" => $label,
		"value" => ""
	);
	echo form_input($data);
}

$this->load->helper("form");
echo form_open("site/send_email");

quickInput("name");

echo form_close();