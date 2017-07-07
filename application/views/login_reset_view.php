<div class="form-wrap">
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
<form class="login" action="http://localhost/login/reset/" method="get">
<input type="email" name="user" placeholder="your e-mail" required>
<input type="submit" name="send" value="reset password">
</form>
<?php } ?>
</div>
