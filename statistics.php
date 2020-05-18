<?php
	session_start();
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$all_authors = $db->query("SELECT * FROM `artists`");
	echo "author_name,title_track,number_of_votes\n";
	for($i = 0; $i < $all_authors->num_rows; $i = $i + 1)
	{
		$row = $all_authors->fetch_assoc();
		$votes_track = $db->query("SELECT artists.id, track.title_track, count(id_user) FROM `track` join artists on track.id_artist = artists.id join voted_list_track on track.id = voted_list_track.id_track group by track.id, title_track,artists.id HAVING artists.id =".$row['id']." order by 3 desc");
		if($votes_track->num_rows > 0) {
			for($q = 0; $q < $votes_track->num_rows; $q = $q + 1)
			{	
				$tracks = $votes_track->fetch_assoc();
				echo $row['name'].",".$tracks['title_track'].",".$tracks['count(id_user)']."\n";
			}
		}

	}
	echo"\n\n\n";
	$all_authors = $db->query("SELECT * FROM `artists`");
	echo "author_name,number_of_votes\n";
	for($i = 0; $i < $all_authors->num_rows; $i = $i + 1)
	{
		$row = $all_authors->fetch_assoc();
		$votes_artist = $db->query("SELECT artists.id, count(id_user) FROM `track` join artists on track.id_artist = artists.id join voted_list_track on track.id = voted_list_track.id_track group by artists.id having artists.id=".$row['id']);
		if($votes_artist->num_rows > 0) {
			for($q = 0; $q < $votes_artist->num_rows; $q = $q + 1)
			{	
				$votes = $votes_artist->fetch_assoc();
				echo $row['name'].",".$votes['count(id_user)']."\n";
			}
		}
	}
	echo"\n\n\n";
	$all_authors = $db->query("SELECT * FROM `artists`");
	echo "author_name,title_track,number_of_addings\n";
	for($i = 0; $i < $all_authors->num_rows; $i = $i + 1)
	{
		$row = $all_authors->fetch_assoc();
		$added_track = $db->query("select title_track, count(id_user) from track join track_list on track.id = track_list.id_track group by title_track, id_artist having id_artist = ".$row['id']." order by 2 desc");
		if($added_track->num_rows > 0) {
			for($q = 0; $q < $added_track->num_rows; $q = $q + 1)
			{	
				$votes = $added_track->fetch_assoc();
				echo $row['name'].",".$votes['title_track'].",".$votes['count(id_user)']."\n";
			}
		}
	}
	
	echo"\n\n\n";
	echo "type_of_comment, number\n";
	echo "albumcomments,".$db->query("SELECT count(*) FROM `albumcomments`")->fetch_assoc()['count(*)']."\n";
	echo "artistcommets,".$db->query("SELECT count(*) FROM `artistcomments`")->fetch_assoc()['count(*)']."\n";
	echo "personalcomments,".$db->query("SELECT count(*) FROM `personalcomments`")->fetch_assoc()['count(*)']."\n";
	echo "playcomments,".$db->query("SELECT count(*) FROM `playcomments`")->fetch_assoc()['count(*)']."\n";
	echo"\n\n\n";
	echo "days, number_of_news\n";
	echo "1,".$db->query("SELECT count(id) FROM `rss` WHERE  datediff(CURRENT_DATE,date) = 0")->fetch_assoc()['count(id)']."\n";
	echo "7,".$db->query("SELECT count(id) FROM `rss` WHERE  datediff(CURRENT_DATE,date) <= 7")->fetch_assoc()['count(id)']."\n";
	echo "30,".$db->query("SELECT count(id) FROM `rss` WHERE  datediff(CURRENT_DATE,date) <= 30")->fetch_assoc()['count(id)']."\n";
	$db->close();
 ?>