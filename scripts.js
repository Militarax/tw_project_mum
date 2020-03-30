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

function play(number) {
	if(number != null)
	{
		var pause_button = document.getElementById("pause");
		var play_button = document.getElementById("play");
		var mini_play = document.getElementById("mini-play" + number);
		var mini_pause = document.getElementById("mini-pause" + number);
	
		pause_button.className="pause on";
		play_button.className="play off";
		mini_pause.className="little-player pause on";
		mini_play.className="little-player play off";
	}

}

function pause(number) {
	var mini_play_btn = document.getElementsByClassName('little-player play off');
	var mini_pause_btn = document.getElementsByClassName("little-player pause on");
	var pause_button = document.getElementById("pause");
	var play_button = document.getElementById("play");
	
	mini_play_btn[0].className="little-player play on";
	mini_pause_btn[0].className="little-player pause off";
	pause_button.className="pause off";
	play_button.className="play on";
}