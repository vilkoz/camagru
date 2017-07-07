<article>
	<video style="display: none;" id="video" width="640" height="480" autoplay></video>
	<canvas id="canvas" width="640" height="480"></canvas>
	</br>
	<button id="snap">Snap Photo</button>
	<input type="text" id="caption" placeholder="caption">
<script>
window.addEventListener("DOMContentLoaded", function() {
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	var mediaConfig =  { video: true };
	var errBack = function(e) {
		console.log('An error has occurred!', e)
	};

	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
			video.src = window.URL.createObjectURL(stream);
			video.play();
		});
	}

	else if(navigator.getUserMedia) { // Standard
		navigator.getUserMedia(mediaConfig, function(stream) {
			video.src = stream;
			video.play();
		}, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(mediaConfig, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
		}, errBack);
	} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
		navigator.mozGetUserMedia(mediaConfig, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}

	window.setInterval(function()
	{
		context.drawImage(video, 0, 0);
	}, 20);

	function delete_photo() {
		if (confirm("Confirm picture deletion."))
		{
			var req = new XMLHttpRequest();
			var path = this.src;
			req.open('get', '/add/delete/?path='+path, true);
			req.onload = load_recent();
			req.send();
		}
	}

	var load_recent = function()
	{
		var req = new XMLHttpRequest();
		req.open('get', '/add/load/?start=0', true);
		req.onload = function()
		{
			var side = document.getElementById("side");
			var img_array = JSON.parse(this.responseText);
			while (side.hasChildNodes()) {
				    side.removeChild(side.lastChild);
			}
			console.log(img_array);
			for (var i = 0; i < img_array.length; i++)
			{
				var caption = img_array[i]['caption'];
				var path = img_array[i]['path'];
				var tmp_img = document.createElement('img');
				tmp_img.src = path;
				tmp_img.alt = caption;
				tmp_img.classList.add("perview");
				tmp_img.onclick = function(){
					if (confirm("Confirm picture deletion."))
					{
						var req = new XMLHttpRequest();
						var path = this.src;
						req.open('get', '/add/delete/?path='+path, true);
						req.onload = function(){
							console.log(this.responseText);
							load_recent();}
						req.send();
					}
				};
				side.appendChild(tmp_img);
			}
		}
		req.send();
	}

	load_recent();

	document.getElementById('snap').addEventListener('click', function()
	{
		var dataUrl = canvas.toDataURL();
		var caption = document.getElementById('caption').value;
		if (caption == '')
			caption = 'Unnamed';
		var data = new FormData();
		var req = new XMLHttpRequest();
		data.append('image', dataUrl);
		data.append('caption', caption);
		req.open('post', "/add/image/", true);
		req.onload = function() {
			console.log(this.responseText);
			document.getElementById('caption').value = '';
			load_recent();
		}
		req.send(data);
	});

}, false);
</script>
</article>
<aside id="side">
sboku
</aside>
