<div class="gallery-wrapper">
<?php
/* foreach ($img_arr as $img) */
/* { */
/* 	echo "<article class='gallery-photo'>\n"; */
/* 	echo "<div class='thumbnail'>\n"; */
/* 	echo "<img src='".$img['path']."'>\n"; */
/* 	echo "</div>\n"; */
/* 	echo "<p><b>".$img['login']."</b></p>\n"; */
/* 	echo "<p>".$img['caption']."</p>\n"; */
/* 	echo "</article>\n"; */
/* } */
?>
</div>
<script src='/js/gallery.js'>
</script>
<?php
if (isset($path))
{
?>
<!-- <div onload="show_perview_post('<?php echo $path;?>')"></div>
	<script>
		show_perview_post('<?php echo $path;?>');
	</script> -->
<?php }?>
