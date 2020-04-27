let track = document.getElementById("music0");
let playing = false;
let playing_now = 0;
let prev_play = -1;
var number_of_tracks = 10;

setInterval(updateProgressValue, 1);

function play(number) {
	
	if (playing) { 
		for (i = 0; i < number_of_tracks; i++) {
			pause(i.toString());
		}		
	}

	document.getElementById("main_player_name_track").textContent = document.getElementById("player_name_track" + number).textContent;
	playing_now = parseInt(number);
	playing = true;
	track = document.getElementById("music" + playing_now.toString());
	track.play();

	var pause_button = document.getElementById("pause");
	var play_button = document.getElementById("play");
	var mini_play = document.getElementById("mini-play" + playing_now.toString());
	var mini_pause = document.getElementById("mini-pause" + playing_now.toString());
	
	pause_button.className="pause on";
	play_button.className="play off";
	mini_pause.className="little-player pause on";
	mini_play.className="little-player play off";

}

function main_play() {
	if(prev_play === -1){
		playing_now = 0;
		play(playing_now.toString());
	}	
	else
		play(prev_play);
}


function pause(number) {
	playing = false;
	track.pause();
	prev_play = playing_now;

	var mini_play_btn = document.getElementById("mini-play" + playing_now.toString());
	var mini_pause_btn = document.getElementById("mini-pause" + playing_now.toString());
	var pause_button = document.getElementById("pause");
	var play_button = document.getElementById("play");
	
	mini_play_btn.className="little-player play on";
	mini_pause_btn.className="little-player pause off";
	pause_button.className="pause off";
	play_button.className="play on";

}

function prev() {
	if(playing_now - 1 >= 0){
		pause(playing_now);
		play((playing_now - 1).toString());
	}
	else
		pause(playing_now);
}

function next() {
	if(playing_now + 1 < number_of_tracks){
		pause(playing_now);
		play((playing_now + 1).toString());
	}
	else
		pause(playing_now);
}
var i = 0;
function updateProgressValue() {
	var bar = document.getElementById("bar");
	if (track != null)
	{
		bar.style.width = ((track.currentTime / track.duration) * 100).toString() + "%";
		if (track.currentTime / track.duration === 1)
		next();
	}

}