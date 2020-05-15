<?php

	function print_tracks($page) {
		include 'connection.php';
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		$rez = $db->query('SELECT count(track.id) from track') or die("error");
		$total_tracks = $rez->fetch_assoc()['count(track.id)'];
		
		$number_of_tracks_displayed = 20;

		if($page == 1){
			$from = 0;
			
		}
		else {
			$from = 20 * ($page - 1);
			if ($from < $total_tracks and $number_of_tracks_displayed > $total_tracks - $from) {
				$number_of_tracks_displayed = $total_tracks - $from;
			}
			if ($from >= $total_tracks)
				$from =0;

		}

		$result = $db->query("SELECT track.id, artists.name, track.title_track, albums.img_link, count(id_user) from `artists` join `track` on artists.id = track.id_artist left outer join `albums` on albums.id_track = track.id left outer join voted_list_track on track.id = voted_list_track.id_track group by track.id, artists.name, track.title_track, albums.img_link order by 5 DESC LIMIT ".$from.", ".$number_of_tracks_displayed.";") or die("mysql_error");	


		for($i = 0; $i < $result->num_rows; $i = $i + 1) {
			$row = $result->fetch_assoc();
			if(is_null($row['img_link']))
				$row['img_link'] = "http://localhost/tw/img/noalbum.png";
			echo' <li>
			<audio id="music'.$i.'">
				<source src="http://localhost/tw/music/'.str_replace(' ', '%20', $row["title_track"]).'.mp3" type="audio/mpeg">
			</audio>
			<div class="main-player">
				<div class="album-image" style="background-image: url('.$row["img_link"].')">
					<button id="mini-play'.$i.'" onclick="play('.$i.')" class="little-player play on"></button>
					<button id="mini-pause'.$i.'" onclick="pause('.$i.')" class="little-player pause off"></button>
				</div>
				<div class="track-link">
					<p class="marquee resp"><span><a onclick="redirect_to_artist(`'.$row["name"].'`)" id = "player_name_track'.$i.'">'.$row["name"].' - '.$row["title_track"].'</a></span></p>
					<a onclick="redirect_to_artist(`'.$row["name"].'`)" class="noneresp">'.$row["name"].' - '.$row["title_track"].'</a>
				</div>';

			if(isset($_SESSION['email'])) {
				echo '<div class="add-vote-div"><button onclick="mini_menu('.$i.')" class="add-button"></button></div>
					<div id="mini-menu'.$i.'" class="mini-menu">
						<ul style="list-style-type: none">';

				$id_track = $db->query('SELECT * from `track` where `title_track` = "'.$row['title_track'].'"')->fetch_assoc()['id'];
				if($db->query("SELECT count(*) from `track_list` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
					echo '<li><a id="add_or_remove_a'.$i.'" onclick="add_track(`'.$row['title_track'].'`, `'.$i.'`)">Add</a></li>';
				else
					echo '<li><a id="add_or_remove_a'.$i.'" onclick="add_track(`'.$row['title_track'].'`, `'.$i.'`)">Remove</a></li>';
				
				if($db->query("SELECT count(*) from `voted_list_track` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
					echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['title_track'].'`, `'.$i.'`)">Vote</a></li>';
				else
					echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['title_track'].'`, `'.$i.'`)">Unvote</a></li>';
				echo'</ul></div>';
			}
			echo '</div></li>';
		}
		$db->close();
}
 ?>