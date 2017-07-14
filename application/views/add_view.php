<div class="add-wrap">
<article class="add-edit">
<div id="select-cam" class="active">Select cam</div>
<div id="select-file">Select file</div>
	<video style="display: none;" id="video" width="640" height="480" autoplay></video>
	<div id="div-canv">
		<canvas id="canvas" width="640" height="480"></canvas>
		<canvas id="canvas-file" width="640" height="480" style="display:none"></canvas>
		<canvas id="canvas-send" style="display:none"></canvas>
		<input type="file" id="image-loader" name="imgload" accept="image/*"/>
		<div id="sup">
		</div>
		<div id="show-sup">
			+
		</div>
	</div>
<script src="/js/add.js">
</script>
</article>
<aside id="side">
sboku
</aside>
<div style="clear: both;"></div>
	<button id="snap" disabled>Snap Photo</button>
	<input type="text" id="caption" placeholder="caption">
	<button id="send" style="display:none">Send Photo</button>
<div style="clear: both;"></div>
</div>
<img src="https://placehold.it/150/000000/000000" style="visibility: hidden; position: absolute; top: 0;" id="ghost">
