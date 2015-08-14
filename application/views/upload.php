<?php 

print_r($success);

print_r($error);

echo form_open_multipart('index.php/upload/do_upload'); 

echo form_upload( array('name'=>'userfile[]', 'multiple' => true ) );

echo '<br />';

echo form_submit('submit', 'Upload');

echo form_close();

?>

