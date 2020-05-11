<?php

	function print_albums($page) {
		include 'connection.php';
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		$rez = $db->query('SELECT count(albums.id) from albums') or die("error");
		$total_tracks = $rez->fetch_assoc()['count(albums.id)'];
		
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

		$result = $db->query("SELECT artists.name, albums.img_link, albums.album_title, count(id_user) from `albums`  join `artists` on albums.id_artist = artists.id left outer join voted_list_album on albums.id = voted_list_album.id_album group by artists.name,albums.img_link order by 4 DESC LIMIT ".$from.", ".$number_of_tracks_displayed.";") or die("mysql_error");	


	
for($i = 0; $i <  $result->num_rows; $i = $i + 1) {
	$row = $result->fetch_assoc();
	if(is_null($row['img_link']))
		$row['img_link'] = "http://localhost/tw/img/noalbum.png";
	echo' <li>
	<div class="main-player">
		<div class="album-image" style="background-image: url('.$row["img_link"].')">
		</div>
		<div class="track-link">
		<p class="marquee resp"><span><a onclick="redirect(`'.$row["album_title"].'`)" id = "album_title'.$i.'">'.$row["album_title"].' - '.$row["name"].'</a></span></p>
			<a onclick="redirect(`'.$row["album_title"].'`)" id = "album_title'.$i.'" class="noneresp">'.$row["album_title"].' - '.$row["name"].'</a>
			
		</div>';

	if(isset($_SESSION['email'])) {
		echo '<div class="add"><button onclick="mini_menu('.$i.')" class="add-button"></button></div>
			<div id="mini-menu'.$i.'" class="mini-menu">
				<ul style="list-style-type: none">';

		$id_album = $db->query('SELECT * from `albums` where `albums.album_title` = "'.$row['album_title'].'"')->fetch_assoc()['id'];
		if($db->query("SELECT count(*) from `voted_list_album` where `id` = '".$id_album."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
			echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['album_title'].'`, `'.$i.'`)">Vote</a></li>';
		else
			echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['album_title'].'`, `'.$i.'`)">Unvote</a></li>';
		echo'</ul></div></div></li>';
	}
}
	$db->close();
}
 ?>