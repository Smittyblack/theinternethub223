<td id="content">

<div id="content">

<h1>Upload</h1>

<?php
if($this->session->userdata('logged_in')){ 

	echo validation_errors();
	echo $error;
	echo '<form action="upload_validation" method="POST" enctype="multipart/form-data" >';

	echo "<table><tr><td>Title: </td><td>";
	echo form_input('title', $this->input->post('title'));
	echo "</td></tr>";

	echo "<tr><td>Author Comment: </td><td>";
	echo form_input('author_comment', $this->input->post('author_comment'));
	echo "</td></tr>";

	echo "<tr><td>Image File: </td><td>";
	echo '<input type="file" name="file" multiple="multiple" />';
	echo "</td></tr>";

	echo '<tr><td colspan="2"><div id="upload_submit">';
	echo form_submit('upload_submit', 'Submit');
	echo "</div></td></tr></table>";

	echo form_close();
}
else{
	echo 'You must be logged in to upload content.';
}

?>
</div>

</td>
</tr>
</table>