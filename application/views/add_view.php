<div class="add-wrap">
<article class="add-edit">
	<video style="display: none;" id="video" width="640" height="480" autoplay></video>
	<div id="div-canv">
		<canvas id="canvas" width="640" height="480"></canvas>
		<canvas id="canvas-send" width="640" height="480" style="display:none"></canvas>
	</div>
	<div id="sup">
	</div>
	</br>
	<button id="snap">Snap Photo</button>
	<input type="text" id="caption" placeholder="caption">
	<button id="send" style="display:none">Send Photo</button>
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
	
	var temp_x = 0;
	var temp_y = 0;
	document.onmousemove = function(e) {
		temp_x = e.pageX;
		temp_y = e.pageY;
	}

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
			for (var i = 0; i < img_array.length; i++)
			{
				var caption = img_array[i]['caption'];
				var path = img_array[i]['path'];
				var tmp_img = document.createElement('img');
				var tmp_div = document.createElement('div');
				tmp_img.src = path;
				tmp_img.alt = caption;
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
				tmp_div.classList.add("thumbnail");
				tmp_div.appendChild(tmp_img);
				side.appendChild(tmp_div);
			}
		}
		req.send();
	}

	var pic_arr = [];

	var drag_x = 0;
	var drag_y = 0;

	var add_drag_listeners = function() {
		let img_arr = document.getElementsByClassName('sticker-draw');
		for (let i = 0; i < img_arr.length; i++)
		{
			let img = img_arr[i];
			img.addEventListener('dragstart', function(e){
				drag_x = e.x;
				drag_y = e.y;
			});
			img.addEventListener('dragend', function(){
				console.log("ended");
			});
			img.addEventListener('dragend', function(e){
				let pos_x = parseInt(this.style.left);
				let pos_y = parseInt(this.style.top);
				this.style.left = (pos_x + (e.x - drag_x)) + "px";
				this.style.top = (pos_y + (e.y - drag_y)) + "px";
			});
		}
	}

	var draw_sticker_on_canvas = function(path)
	{
		let img = document.createElement('img');
		img.src = path;
		img.draggable = "true";
		img.style.position = 'absolute';
		img.style.resize = 'both';
		img.style.top = '100px';
		img.style.left = '100px';
		img.classList.add('sticker-draw');
		img.style.zIndex = "5";
		document.getElementById('div-canv').appendChild(img);
		add_drag_listeners();
	}

	var add_onclick_listener = function()
	{
		let arr = document.getElementsByClassName('sticker');
		for (var i = 0; i < arr.length; i++)
		{
			arr[i].addEventListener('click', function() {
				console.log("works");
				draw_sticker_on_canvas(this.src);
			});
		}
	}

	var load_sup = function()
	{
		let req = new XMLHttpRequest();
		req.open('get', "/add/load_sup/", true);
		req.onload = function() {
			let arr = JSON.parse(this.responseText);
			for(var i = 0; i < arr.length; i++)
			{
				let img = document.createElement('img');
				img.src = arr[i];
				img.classList.add('sticker');
				document.getElementById('sup').appendChild(img);
			}
			add_onclick_listener();
		}
		req.send();
	}

	load_recent();
	load_sup();

	var draw_image = function(img, x, y, ctx) {
		let base = new Image();
		base.onload = function() {
			ctx.drawImage(base, x, y);
			if (img.classList.contains('sticker-draw'))
			{
				document.getElementById('div-canv').removeChild(img);
			}
		}
		base.src = img.src;
	}

	var render_canvas = function(ctx) {
		let img_arr = document.getElementsByClassName('sticker-draw');
		for (let i=0; i < img_arr.length; i++)
		{
			draw_image(
				img_arr[i],
				parseInt(img_arr[i].style.left),
				parseInt(img_arr[i].style.top),
				ctx);
		}
	}
	document.getElementById('send').addEventListener('click', function(){
		var c1 = document.getElementById('canvas-send');
		var ctx = c1.getContext('2d');
		var dataUrl = c1.toDataURL();
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
			c1.style.display = "none";
			canvas.style.display = "block";
			document.getElementById('send').style.display = "none";
			document.getElementById('snap').style.display = "block";
			document.getElementById('caption').style.display = "block";
		}
		req.send(data);
	});

	document.getElementById('snap').addEventListener('click', function()
	{
		var dataUrl = canvas.toDataURL();
		var c1 = document.getElementById('canvas-send');
		c1.style.display = "block";
		canvas.style.display = "none";
		var ctx = c1.getContext('2d');

		let tmp = document.createElement('img');
		tmp.src = dataUrl;
		let base = new Image();
		base.onload = function() {
			ctx.drawImage(base, 0, 0);
			render_canvas(ctx);
		}
		base.src = tmp.src;

		document.getElementById('send').style.display = "block";
		document.getElementById('snap').style.display = "none";
		document.getElementById('caption').style.display = "none";
	});

}, false);
</script>
</article>
<aside id="side">
sboku
</aside>
<div style="clear: both;"></div>
</div>
