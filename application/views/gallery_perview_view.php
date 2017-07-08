<div class="perview-photo">
<?php echo "<img src='".$path."'>"?>
</div>
<div class="perview-comments">
<div class="perview-info">
<?php if(isset($comments[0]))
echo "<b>".$comments[0]['caption']."</b>";?>
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
<script>
	console.log('I\'m not working!');
</script>
<?php } ?>
</div>
<div style="clear:both;">
</div>
