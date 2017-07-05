<?php
/**
 *
 */
class View
{
  function generate($content_view, $template_view, $data = Null)
  {
    $content_view_tmp = $content_view;
    $template_view_tmp = $template_view;
    if (is_array($data))
      extract($data);
    $content_view = $content_view_tmp;
    $template_view = $template_view_tmp;
    include 'application/views/'.$template_view;
  }
}

 ?>
