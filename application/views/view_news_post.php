<td id="content">
<div id="content">
<?php 
$title = '<h1>New News Post</h1>';
$body = '';
$body .= validation_errors();
$body .= form_open(base_url().'index.php/site/news_post');
$body .= '<table>';
$body .= '<tr><td>Title:</td><td>'.form_input('title').'</td></tr>';
$body .= '<tr><td>Post:</td><td>'.form_textarea('post').'</td></tr>';
$body .= '<tr><td>'.form_submit('submit', "Submit").'</td></tr>';
$body .= '</table>';
$body .= form_close();
echo $this->model_content->pod($title, $body);
?>
</div>
</div>
</td>
</tr>
</table>