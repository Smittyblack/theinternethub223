<div id="content">

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php 

foreach ($error as $item => $value){
	echo '<li>'.$item . $value . '</li>';
}

echo $success;

/*
foreach ($success as $item => $value)
	echo '<li>'.$item. $value . '</li>';
endforeach;

echo '</ul>';
*/

echo '<p>'.anchor('index.php/site/upload', 'Upload Another File!').'</p>';
 
 ?>

</div>