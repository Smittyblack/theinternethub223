<td id="content">
<div id="content">
<?php 
$title = $post_title;
$body = '<div class="post_info">By <a href="'.base_url().'index.php/site/user/'.$author.'">'.$author. '</a>  <span class="date">'.$date.'</span></div>';
$body .= '<div class="post_body">'.$post_body.'</div>';
echo $this->model_content->pod($title, $body);
?>
</div>
</div>
</td>
</tr>
</table>