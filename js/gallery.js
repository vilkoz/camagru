window.addEventListener("DOMContentLoaded", function() {
	var rearrange = function() {
		var page_wrap = document.getElementsByClassName("page-wrap")[0];
		var gallery_wrap = document.getElementsByClassName("gallery-wrapper")[0];
		var cols = Math.floor(page_wrap.offsetWidth / 220);
		let w = (cols * (220));
		gallery_wrap.style.width = (w < 200 ? 200 : w) + "px";
	}


	window.onresize = function() {rearrange();}

	function mouse_wheel(e) {
		e = e || window.event;
		if (e.preventDefault)
			e.preventDefault();
		e.returnValue = false; 
	}

	function disable_body_scroll() {
		let body = document.getElementsByTagName('body')[0];
		body.addEventListener('DOMMouseScroll', mouse_wheel, false);
		/* window.onmousewheel = document.onmousewheel = mouse_wheel; */
		body.onmousewheel = mouse_wheel;
		let comm = document.getElementsByClassName('perview-comments')[0];
		comm.onmousewheel = false;
	}

	function enable_body_scroll() {
		let body = document.getElementsByTagName('body')[0];
		body.removeEventListener('DOMMouseScroll', mouse_wheel, false);
		body.onmousewheel = false;
		/* window.onmousewheel = document.onmousewheel = false; */
	}

	var hide_perview = function() {
		var page_wrap = document.getElementsByClassName('page-wrap')[0];
		var cover = document.getElementsByClassName('perview-cover')[0];
		var perw = document.getElementsByClassName('perview')[0];
		page_wrap.removeChild(cover);
		page_wrap.removeChild(perw);
		document.getElementsByTagName('body')[0].classList.remove('noscroll');
		document.getElementsByTagName('body')[0] = body_scroll_height;
		/* enable_body_scroll(); */
	}

	var insert_response_to_elem = function(element, response){
		let temp = document.createElement('div');
		temp.innerHTML = response;
		while (temp.firstChild)
			element.appendChild(temp.firstChild);
	}

	var get_perw_view = function(img_path, element)
	{
		let req = new XMLHttpRequest();
		req.open('get', '/gallery/perview/'+img_path, true);
		req.onload = function() {
			insert_response_to_elem(element, this.responseText);
			perview_listeners();
			get_perw_like_count();
			align_perview_photo();
		}
		req.send();
	}

	var preview_append_comment = function(comm) {
		let div = document.createElement('div');
		div.classList.add('comment');
		let b = document.createElement('b');
		b.textContent = comm['login'];
		let p = document.createElement('p');
		p.textContent = comm['text'];
		div.appendChild(b);
		div.appendChild(p);
		document.getElementsByClassName('comments-wrap')[0].appendChild(div);
	}

	var load_perview_comments = function() {
		let req = new XMLHttpRequest();
		let img_src = document
			.querySelector('.perview-photo > img').src.split("/");
		let path = img_src[img_src.length - 1];
		req.open('get', "/gallery/load_comments/" + path, true);
		req.onload = function() {
			document.getElementsByClassName('comments-wrap')[0]
				.innerHTML = "";
			let comm_arr = JSON.parse(this.responseText);
			for (var i = 0; i < comm_arr.length; i++)
			{
				preview_append_comment(comm_arr[i]);
			}
		}
		req.send();
	}

	var perview_listeners = function(){
		document.getElementById('new-comment')
			.addEventListener("keyup", function(event){
				event.preventDefault();
				if (event.keyCode == 13){
					document.getElementById('send-comment').click();
				}
			});

		document.getElementById('send-comment')
			.addEventListener('click', function(){
			console.log('clicked');
			let req = new XMLHttpRequest();
			let data = new FormData();
			let text = document.getElementById('new-comment').value;
			let img_src = document
				.querySelector('.perview-photo > img').src.split("/");
			let path = img_src[img_src.length - 1];
			data.append('text', (text));
			req.open('post', '/gallery/new_comment/' + path, true);
			req.onload = function() {
				console.log(this.responseText);
				load_perview_comments();
			}
			req.send(data);
			document.getElementById('new-comment').value = '';
			});
		document.getElementsByClassName("perview-photo")[0]
			.addEventListener('click', function(){
				let req = new XMLHttpRequest();
				let img_src = document
					.querySelector('.perview-photo > img').src.split("/");
				let path = img_src[img_src.length - 1];
				req.open('get', '/gallery/like/'+path, true);
				req.onload = function() {
					let like_num = this.responseText;
					let info = document.getElementById('info');
					info.innerHTML = "likes: " + like_num;
				}
				req.send();
			});
		document.getElementsByClassName("perview-settings")[0]
			.addEventListener('click', function(){
				let div = document
					.getElementsByClassName("perview-settings-open")[0];
			   if(div.style.display == 'block')
				  div.style.display = 'none';
			   else
				  div.style.display = 'block';
			});
		document.getElementById('delete')
			.addEventListener('click', function(){
				if (confirm("Are you shure want to delete this photo?"))
				{
					let req = new XMLHttpRequest();
					let img_src = document
						.querySelector('.perview-photo > img').src.split("/");
					let path = img_src[img_src.length - 1];
					req.open('get', '/gallery/delete_photo/'+path, true);
					req.onload = function() {
						console.log(this.responseText);
						if (this.responseText != 'OK')
							return;
						hide_perview();
						document.getElementsByClassName('gallery-wrapper')[0]
							.innerHTML = "";
						current_page = 0;
						load_photos();
					}
					req.send();
				}
			});
	}

	var align_perview_photo = function(){
		let div = document.getElementsByClassName('perview-photo')[0];
		let img = div.getElementsByTagName('img')[0];
		img.onload = function() {
			if (img.offsetHeight > div.offsetHeight)
			{
				img.style.height = "100%";
				img.style.width = "auto";
				img.style.margin = "0 auto";
			}
		}
	}

	var get_perw_like_count = function() {
		let req = new XMLHttpRequest();
		let img_src = document
			.querySelector('.perview-photo > img').src.split("/");
		let path = img_src[img_src.length - 1];
		req.open('get', '/gallery/count_likes/'+path, true);
		req.onload = function() {
			let like_num = this.responseText;
			let info = document.getElementById('info');
			info.innerHTML = "likes: " + like_num;
		}
		req.send();
	}

	var body_scroll_height = 0;

	var show_perview = function(element) {
		var page_wrap = document.getElementsByClassName('page-wrap')[0];
		var new_div = document.createElement("div");
		new_div.classList.add("perview-cover");
		new_div.onclick = function(){
			hide_perview();
		}
		page_wrap.appendChild(new_div);
		var perw = document.createElement("div");
		perw.classList.add("perview");
		var img = element.getElementsByTagName('img')[0];
		let tmp_arr = img.src.split("/");
		var img_name = tmp_arr[tmp_arr.length - 1];
		get_perw_view(img_name, perw);
		page_wrap.appendChild(perw);
		body_scroll_height = document.getElementsByTagName('body')[0].scrollTop;
		document.getElementsByTagName('body')[0].classList.add('noscroll');
	}

	var append_photo = function(img_arr) {
		let g_wrp = document.getElementsByClassName('gallery-wrapper')[0];
		let article = document.createElement('article');
		article.classList.add('gallery-photo');
		let thumb = document.createElement('div');
		thumb.classList.add('thumbnail');
		let pic = document.createElement('img');
		pic.src = img_arr['path'];
		let par = document.createElement('p');
		let bl = document.createElement('b');
		bl.textContent = img_arr['login'];
		let par2 = document.createElement('p');
		par2.innerHTML = img_arr['caption'];
		let par3 = document.createElement('p');
		par3.innerHTML = "c: " + img_arr['comm_count'] + " &hearts;: "
			+ img_arr['like_count'];
		thumb.appendChild(pic);
		par.appendChild(bl);
		article.appendChild(thumb);
		article.appendChild(par);
		article.appendChild(par2);
		article.appendChild(par3);
		g_wrp.appendChild(article);
	}

	var current_page = 0;
	var load_photos = function(){
		if (current_page == -1)
			return;
		var req = new XMLHttpRequest();
		req.open('get', '/gallery/load/'+current_page, true);
		req.onload = function() {
			if (this.responseText == "[]")
			{
				current_page = -1;
				return ;
			}
			let img_arr = JSON.parse(this.responseText);
			for (var i = 0; i < img_arr.length; i++)
			{
				append_photo(img_arr[i]);
			}
			rearrange();
			add_click_triggers();
			current_page += 1;
			/* setTimeout(function() { */
			/* 	if (document.body.scrollHeight == document.body.clientHeight) */
			/* 		load_photos(); */
			/* }, 1000); */
		}
		req.send();
	}

	var first_load = setInterval(function() {
		console.log('in interval');
		if (document.body.scrollHeight == document.body.clientHeight)
		{
			console.log('in load');
			load_photos();
		}
		else
		{
			console.log('in else');
			clearInterval(first_load);
		}
	}, 1000);
	
	/* load_photos(); */

	/* first_load; */

	var get_scroll_percent = function(element){
		var a = element.scrollTop;
		var b = element.scrollHeight - element.clientHeight;
		return (a/b);
	}
	window.addEventListener('touchmove', function() {
		if (get_scroll_percent(document.body) > 0.93)
		{
			console.log("touchmove");
			load_photos();
		}
	});
	window.onscroll = function(){
		if (get_scroll_percent(document.body) >= 1)
		{
			console.log("scroll");
			load_photos();
		}
	}
	var add_click_triggers = function(){
		var articles = document.getElementsByClassName('gallery-photo');
		for (var i = 0; i < articles.length; i++)
		{
			articles[i].onclick = function() {
				show_perview(this);
			}
		}
	}


}, false);
