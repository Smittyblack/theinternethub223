<td id="content">
<div id="content">
<?php
$title = 'Community';
$body = '';
foreach($result as $row){
	$body .= $row->id;
	$body .= " - ";
	$body .= '<a href="'.base_url().'index.php/site/user/'.$row->username.'">'.$row->username.'</a>';
	$body .= "<br />";
}
echo $this->model_content->pod($title, $body);
?>

</div>
</td>
</table>