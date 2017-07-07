<div class="form-wrap">
<div class="answer">
<b><?php if(isset($answer)) {echo $answer;} ?></b>
</div>
<form action="" method="post" class="login">
  <input type="email" name="mail" value="" placeholder="e-mail" required>
  <br/>
  <input type="password" name="pass" value="" placeholder="password" required>
  <br/>
  <input type="submit" name="submit" value="login">
  <br/>
  <p>Do not have an account? Press <a href="/register">Register</a></p>
</form>
</div>
