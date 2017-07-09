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
<script>
window.addEventListener("DOMContentLoaded", function() {
	var local_stream = 0;
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	var mediaConfig =  { video: true };
	var errBack = function(e) {
		console.log('An error has occurred!', e)
	};

	var start_cam_video = function() {
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
			video.src = window.URL.createObjectURL(stream);
			video.play();
			local_stream = stream;
		});
	}
	else if(navigator.getUserMedia) { // Standard
		navigator.getUserMedia(mediaConfig, function(stream) {
			video.src = stream;
			video.play();
			local_stream = stream;
		}, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(mediaConfig, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
			local_stream = stream;
		}, errBack);
	} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
		navigator.mozGetUserMedia(mediaConfig, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
			local_stream = stream;
		}, errBack);
	}
	}

	start_cam_video();


	window.setInterval(function()
	{
		if (canvas.id == "canvas")
		{
			context.drawImage(video, 0, 0);
		}
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

	var drag_x = 0;
	var drag_y = 0;

	var img_add_drag_listener = function(img) {
		img.addEventListener('dragstart', function(e){
			drag_x = e.x;
			drag_y = e.y;
		});
		img.addEventListener('dragend', function(e){
			let pos_x = parseInt(this.parentElement.style.left);
			let pos_y = parseInt(this.parentElement.style.top);
			this.parentElement.style.left = (pos_x + (e.x - drag_x)) + "px";
			this.parentElement.style.top = (pos_y + (e.y - drag_y)) + "px";
			drag_x = 0;
			drag_y = 0;
		});
	}

	var add_drag_listeners = function() {
		let img_arr = document.getElementsByClassName('sticker-draw');
		for (let i = 0; i < img_arr.length; i++)
		{
			img_add_drag_listener(img_arr[i]);
		}
	}

	var draw_sticker_on_canvas = function(path)
	{
		let img = document.createElement('img');
		img.src = path;
		img.draggable = "true";
		/* img.style.position = 'absolute'; */
		/* img.style.resize = 'both'; */
		/* img.style.top = '100px'; */
		/* img.style.left = '100px'; */
		img.classList.add('sticker-draw');
		img.style.zIndex = "5";

		img.style.width = "100%";
		img.style.height = "100%";

		img_add_drag_listener(img);

		let div = document.createElement('div');
		div.classList.add('sticker-wrap');
		div.style.position = 'absolute';
		div.style.top = '100px';
		div.style.left = '100px';
		div.style.resize = 'both';
		div.style.overflow = 'hidden';
		div.style.width = img.width + "px";
		div.style.height = img.height + "px";
		div.appendChild(img);
		document.getElementById('div-canv').appendChild(div);
	}

	var add_onclick_listener = function()
	{
		let arr = document.getElementsByClassName('sticker');
		for (var i = 0; i < arr.length; i++)
		{
			arr[i].addEventListener('click', function() {
				console.log("works");
				draw_sticker_on_canvas(this.src);
				document.getElementById('sup').classList.remove('activated');
				/* document.getElementById('show-sup').style.display = "block"; */
				document.getElementById('show-sup').innerText = "+";
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

	var draw_image = function(img, x, y, sx, sy, ctx) {
		let base = new Image();
		base.onload = function() {
			ctx.drawImage(base, x, y, sx, sy);
			if (img.classList.contains('sticker-draw'))
			{
				document.getElementById('div-canv').removeChild(img.parentElement);
			}
		}
		base.src = img.src;
	}

	var render_canvas = function(c1, ctx) {
		let img_arr = document.getElementsByClassName('sticker-draw');
		console.log(img_arr);
		for (let i=0; i < img_arr.length; i++)
		{
			let offW = c1.offsetWidth;
			let offH = c1.offsetHeight;
			let coef = offW / c1.width;
			let shift_x = 0;
			let shift_y = 0;
			if (offH == 480)
				shift_x = (640 - offW) / 2;
			else
				shift_y = (480 - offH) / 2;
			let x = (parseInt(img_arr[i].parentElement.style.left) - shift_x) / coef;
			let y = (parseInt(img_arr[i].parentElement.style.top) - shift_y) / coef;
			draw_image(
				img_arr[i],
				x,
				y,
				parseInt(img_arr[i].parentElement.style.width) / coef,
				parseInt(img_arr[i].parentElement.style.height) / coef,
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
			canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
			canvas.width = video.width;
			canvas.height = video.height;
			let loader = document.getElementById('image-loader');
			if (loader.style.display = "none" &&
				document.getElementById('select-file')
				.classList.contains('active'))
				loader.style.display = "block";
			document.getElementById('send').style.display = "none";
			document.getElementById('snap').style.display = "inline-block";
			document.getElementById('caption').style.display = "inline-block";
			document.getElementById('select-file').style.display = "inline-block";
			document.getElementById('select-cam').style.display = "inline-block";
			document.getElementById('show-sup').style.display = "block";
			document.getElementById('image-loader').value = "";
			document.getElementById('side').style.display = "block";
			document.getElementsByClassName('add-edit')[0].classList.remove('send');
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

		/* let tmp = document.createElement('img'); */
		/* tmp.src = dataUrl; */
		let base = new Image();
		base.onload = function() {
			console.log(this.width);
			console.log(this.height);
			/* console.log(tmp.naturalHeight); */
			c1.width = base.width;
			c1.height = base.height;
			if (parseInt(c1.clientHeight) > 480)
			{
				c1.style.height = "100%";
				c1.style.width = "auto";
			}
			ctx.drawImage(base, 0, 0);
			render_canvas(c1, ctx);
		}
		base.src = dataUrl;

		document.getElementById('send').style.display = "block";
		document.getElementById('snap').style.display = "none";
		document.getElementById('caption').style.display = "none";
		document.getElementById('select-file').style.display = "none";
		document.getElementById('select-cam').style.display = "none";
		document.getElementById('show-sup').style.display = "none";
		document.getElementById('side').style.display = "none";
		document.getElementsByClassName('add-edit')[0].classList.add('send');
	});

	document.getElementById('select-file').addEventListener('click', function(){
		canvas = document.getElementById('canvas-file');
		context = canvas.getContext('2d');
		document.getElementById('canvas').style.display = "none";
		canvas.style.display = "block";
		this.classList.add('active');
		document.getElementById('select-cam').classList.remove('active');
		document.getElementById('image-loader').style.display = "block";
		local_stream.getTracks()[0].stop();
	});

	document.getElementById('select-cam').addEventListener('click', function(){
		document.getElementById('image-loader').value = "";
		context.clearRect(0, 0, canvas.width, canvas.height);
		canvas = document.getElementById('canvas');
		context = canvas.getContext('2d');
		document.getElementById('canvas-file').style.display = "none";
		canvas.style.display = "block";
		this.classList.add('active');
		document.getElementById('select-file').classList.remove('active');
		document.getElementById('image-loader').style.display = "none";
		start_cam_video();
	});

	document.getElementById('image-loader')
		.addEventListener('change', function(e1) {
			let tmp_can = document.getElementById('canvas-file');
			let tmp_ctx = tmp_can.getContext('2d');
			let reader = new FileReader();
			reader.onload = function(e) {
				let img = new Image();
				img.onload = function() {
					tmp_can.width = img.width;
					tmp_can.height = img.height;
					if (parseInt(tmp_can.clientHeight) > 480)
					{
						tmp_can.style.height = "100%";
						tmp_can.style.width = "auto";
					}
					tmp_ctx.drawImage(img, 0, 0);
					document.getElementById('image-loader').style.display = "none";
				}
				img.src = e.target.result;
			}
			reader.readAsDataURL(e1.target.files[0]);
		}, false);

	document.getElementById('show-sup')
		.addEventListener('click', function() {
			document.getElementById('sup').classList.toggle('activated');
			if (this.innerText == "+")
				this.innerText = "-";
			else
				this.innerText = "+";
		});

}, false);
</script>
</article>
<aside id="side">
sboku
</aside>
<div style="clear: both;"></div>
	<button id="snap">Snap Photo</button>
	<input type="text" id="caption" placeholder="caption">
	<button id="send" style="display:none">Send Photo</button>
<div style="clear: both;"></div>
</div>
