<td id="content">
<div id="content">
<!-- h1>Content</h1 -->
<?php 
$top_rated_thumbnails = '';
foreach($top_rated_result as $row)
{
	$top_rated_thumbnails .= $this->model_content->content_thumb($row->title, $row->id);
}

echo $this->model_content->pod("Top Content", $top_rated_thumbnails);

$most_recent_thumbnails = '';
foreach($most_recent_result as $row)
{
	$most_recent_thumbnails .= $this->model_content->content_thumb($row->title, $row->id);
}
echo $this->model_content->pod("Recent Content", $most_recent_thumbnails);
?>
</div>
</td>
</tr>
</table>