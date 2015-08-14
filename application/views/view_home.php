
<td id="content">

<div id="content">

<!-- h1 class="page_header">Home</h1 -->

<div class="page_body">
<?php

$top_rated_thumbnails = '';
foreach($top_rated_result as $row)
{
	//echo $row->title;
	$top_rated_thumbnails .= $this->model_content->content_thumb($row->title, $row->id);
}

echo $this->model_content->pod("Top Content", $top_rated_thumbnails);

$most_recent_thumbnails = '';
foreach($most_recent_result as $row)
{
	//echo $row->title;
	$most_recent_thumbnails .= $this->model_content->content_thumb($row->title, $row->id);
}
echo $this->model_content->pod("Recent Content", $most_recent_thumbnails);

?>
</div>

</div>
</td>
</tr></table>

