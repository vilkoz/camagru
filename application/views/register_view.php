<div class="form-wrap">
<div class="answer">
<?php if(isset($answer)) {echo $answer;}?>
</div>
<form class="register" action="" method="post">
  <input type="email" name="mail" value="" placeholder="e-mail" required>
  <br>
  <input title="Enter your login"
	type="text" name="login" value="" placeholder="login" required pattern="\w+">
  <br>
  <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers"
	type="password" name="pass" value="" placeholder="password" required
	pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
	onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
	form.pass_confirm.pattern = this.value;">
  <br>
  <input title="Passwords must match!"
	type="password" name="pass_confirm" value="" placeholder="password_confirm" required
	onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
  <br>
  <input type="submit" name="submit" value="register">
</form>
</div>
