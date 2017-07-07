<div class="answer">
<b><?php if(isset($answer)) {echo $answer;} ?></b>
</div>
<form action="" method="post">
  <input type="email" name="mail" value="" placeholder="e-mail">
  <input type="password" name="pass" value="" placeholder="password">
  <input type="submit" name="submit" value="ok">
  <?php print_r($_SESSION)?>
</form>
