<div class="gallery-wrapper">
<?php
foreach ($img_arr as $img)
{
	echo "<article class='gallery-photo'>\n";
	echo "<div class='thumbnail'>\n";
	echo "<img src='".$img['path']."'>\n";
	echo "</div>\n";
	echo "<p><b>".$img['login']."</b></p>\n";
	echo "<p>".$img['caption']."</p>\n";
	echo "</article>\n";
}
?>
<script>
window.addEventListener("DOMContentLoaded", function() {
	var rearrange = function() {
		var page_wrap = document.getElementsByClassName("page-wrap")[0];
		var gallery_wrap = document.getElementsByClassName("gallery-wrapper")[0];
		var cols = Math.floor(page_wrap.offsetWidth / 220);
		console.log(cols);
		gallery_wrap.style.width = (cols * (220 + 5)) + "px";
	}

	rearrange();

	window.onresize = function() {rearrange();}
}, false);
</script>
</div>
