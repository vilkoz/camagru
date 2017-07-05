<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php if (isset($title)) {echo $title;}?></title>
  </head>
  <body>
    <?php include 'application/views/'.$content_view; ?>
  </body>
</html>
