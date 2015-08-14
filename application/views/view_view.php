<td id="content">
<div id="content">

<?php foreach($content_data as $row)
{
	$content_title = $row->title;
	$content_id = $row->id;
	$ext = $row->extension;
}

$title = '<h2>'.str_replace('_', ' ', $content_title).'</h2>';
$image = '<img class="content_view" src="'.base_url().'uploads/'.$content_title.'/'.$content_id.'/image'.$ext.'" />';

echo '<div id="view">';

echo $this->model_content->pod($title, $image);

?>

</div>
</div>
</td>
</tr>
</table>