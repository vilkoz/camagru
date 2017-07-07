<div class="answer">
<?php
if (isset($answer))
{
	echo $answer;
}
else
{
?>
</div>
<form class="reset" action="http://localhost/login/reset/" method="get">
<input type="email" name="user" placeholder="Your accaunt e-mail" required>
<input type="submit" name="send" value="Reset password!">
</form>
<?php } ?>
