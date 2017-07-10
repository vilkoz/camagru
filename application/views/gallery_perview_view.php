<div class="perview-photo">
<?php echo "<img src='".$path."'>"?>
</div>
<div class="perview-comments">
<div class="perview-info">
<div class="perview-settings">
&#8942;
</div>
<div class="perview-settings-open">
<span id="delete">delete</span>
</div>
<?php
echo "<b>".$info['caption']."</b>";?>
<div id="info">
</div>
</div>
<div class="comments-wrap">
<?php
foreach ($comments as $c)
{
	echo "<div class='comment'>";
	echo "<b>".$c['login']."</b>";
	echo "<p>".$c['text']."</p>";
	echo "</div>";
}
?>
</div>
<?php
if (!isset($_SESSION))
{
	session_start();
}
if (isset($_SESSION['user']) && !empty($_SESSION['user']))
{
	echo "<input id='new-comment' type='text' placeholder='Enter your comment'>";
	echo "<button id='send-comment' value='send'>Send</button>";
?>
<?php } ?>
</div>
<div style="clear:both;">
</div>
