<?php

	function print_albums($page) {
		include 'connection.php';
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		$rez = $db->query('SELECT count(albums.id) from albums') or die("error");
		$total_albums = $rez->fetch_assoc()['count(albums.id)'];
		

		$result = $db->query("SELECT artists.name, albums.img_link, albums.album_title from `albums`  join `artists` on albums.id_artist = artists.id  group by artists.name,albums.img_link, albums.album_title") or die("mysql_error");	
	
	for($i = 0; $i <  $result->num_rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		if(is_null($row['img_link']))
			$row['img_link'] = "http://localhost/tw/img/noalbum.png";
				
				echo '<a class="link_to_album" href="single_album.php?name='.$row['album_title'].'"><div class="music-tag"
					style="background-image: url('.$row["img_link"].')">
					<div class="music-tag-link" href="index.html">
					</div>
				</div></a>';

		}
		$db->close();
	}
 ?>