var page = 1;

function NavBarResponsivity() {
		  var x = document.getElementById("text");
		  if (x.className === "text-off") {
		    x.className = "text-on";
		  } else {
		  	x.className = "text-off";
		  }
}

function left_button_image() {
	var left_img = document.getElementById("fimg");
	var center_img = document.getElementById("simg");
	var right_img = document.getElementById("timg");
	var tmp = right_img.src;
	right_img.src = center_img.src;
	center_img.src = left_img.src;
	left_img.src = tmp
}

function right_button_image() {
	var left_img = document.getElementById("fimg");
	var center_img = document.getElementById("simg");
	var right_img = document.getElementById("timg");
	var tmp = left_img.src;
	left_img.src = center_img.src;
	center_img.src = right_img.src;
	right_img.src = tmp;
}

function mini_menu(number) {
	var x = document.getElementById("mini-menu" + number);
	if (x.style.display === "block")
		x.style.display = "none";
	else
		x.style.display = "block";
}


function add_track(title_track, number){
	$.ajax({
	    url: 'add_track_to_playlist.php',
	    type: 'post',
	    data: {'title_track' : title_track},
	    success: function(response){
	        var button = document.getElementById('add_or_remove_a' + number);
	        if (button.textContent === "Add")
	        	button.textContent = "Remove";
	        else
	        	button.textContent = "Add";
	    }
	});
}

function redirect_to_artist(author_name) {
	$.ajax({
	    url: 'artist.php',
	    type: 'GET',
	    data: { 
	    	name:author_name 	
		 },
	    success: function(response){
	    	document.location.href = `/tw/artist.php?name=${author_name}`;
	    }
	});
}

function get_new_tracks() {

	var last_page = false;
	for(i = 0; i < 20; i++)
		if(document.getElementById("mini-play" + i.toString()) == null) {			
			last_page = true;
			break;
		}

	if(last_page === true)
		page = 1;
	else
		page = page + 1;

	$.ajax({
	    url: 'index.php',
	    type: 'GET',
	    dataType : "html",
	    data: { 
	    	page:page	
		 },
	    success: function(response){
	    	var ul = $(response).find('#ul_player_list').html();
	    	$('#ul_player_list').html(ul);
	    },
	    error: function(err){
	    	console.log(err);
	    }
	});
}

function vote_track(title_track, number){
	$.ajax({
	    url: 'vote_track.php',
	    type: 'post',
	    data: {'title_track' : title_track},
	    success: function(response){
	        var button = document.getElementById('vote_a' + number);
	        if (button.textContent === "Vote")
	        	button.textContent = "Unvote";
	        else
	        	button.textContent = "Vote";
	    }
	});
}

