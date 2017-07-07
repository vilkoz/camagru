<h1>it is main page</h1>
<pre>
<?php print_r($_SERVER)?>
<?php
if (!isset($_SESSION))
	session_start();
print_r($_SESSION)?>
</pre>
