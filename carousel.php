<?php 
	
	function print_carousel() {
		include 'connection.php';
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		$result = $db->query('SELECT album_title, img_link, count(voted_list_track.id_user) FROM `albums` left outer join voted_list_track on albums.id_track = voted_list_track.id_track group by album_title, img_link order by 3 desc');
		$first = $result->fetch_assoc();
		$second = $result->fetch_assoc();
		$third = $result->fetch_assoc();
		echo '<div class="img-container">
			<div class="carousel">
				<a class="left-button" onclick="left_button_image()"><b>&lt;</b></a>
				<div class="images">
					<a href = "#"><img id="fimg" src="'.$first['img_link'].'" alt=""></a>
					<a href = "#"><img id="timg" src="'.$second['img_link'].'" alt=""></a>
					<a href = "#"><img id="simg" src="'.$third['img_link'].'" alt=""></a>
				</div>	
				<a class="right-button" onclick="right_button_image()"><b>&gt;</b></a>
			</div>
		</div>';
		$db->close();
	}
	
?>