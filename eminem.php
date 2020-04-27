<?php
	session_start();
	$user ='root';
	$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect'); 
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/eminem.css">
	<title>MD&MTC</title>
	<script src="js/scripts.js">
	</script>
	<script src="js/player.js">
	</script>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
</head>
<body>
	<header>
		<nav>
			<div class="nonresponsive">
				<div class="left">
					<a href="index.php">main page</a>
					<a href="albums.php">albums</a>
				</div>
				<div class="center">
					<a href="index.php">MD&MTC</a>
				</div>
				<div class="right">


					<?php
						if(!isset($_SESSION['email'])) {
							echo '<a href="register.php">registration</a>
								<a href="login.php">login</a>';
							}
						else {
							echo '<a href="profile.php">Profile</a>
							<a href="logout.php">logout</a>';
						}
					 ?>



				</div>
			</div>
			<div class="responsive">
				<div id="menu" class="main_name">
					<a href="index.php">MD&MTC</a>
				</div>
				<div class="menu">
					<a href="javascript:void(0);"  onclick="NavBarResponsivity()">Menu</a>
				</div>
				<div id="text" class="text-off">
					<ul>
						<li><a href="index.php">main page</a></li>
						<li><a href="albums.php">albums</a></li>


						<?php
							if(!isset($_SESSION['email'])) {
								echo '<li><a href="register.php">registration</a></li>
							<li><a href="login.php">login</a></li>';
								}
							else {
								echo '<li><a href="profile.php">profile</a></li>
								<li><a href="logout.php">logout</a></li>';
							}
						 ?>



					</ul>
				</div>
			</div>
		</nav>
	</header>



<div class="main-container">
	<div class="grid-container">
		<div class="portret">
				<div id="img">	<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Eminem_-_Concert_for_Valor_in_Washington%2C_D.C._Nov._11%2C_2014_%282%29_%28Cropped%29.jpg/274px-Eminem_-_Concert_for_Valor_in_Washington%2C_D.C._Nov._11%2C_2014_%282%29_%28Cropped%29.jpg" alt="">
				</div>

				<p>123-321</p>
				<p>Name</p>
				<p>Style</p>


<?php
$result = $db->query("SELECT * from `artists` join `track` on artists.id = track.id_artist left outer join `albums` on albums.id_track = track.id where artists.name = '".$_GET['name']."'") 
or die("mysql_error");	
	$rows = $result->num_rows >= 3 ? 3 : $result->num_rows;
	for($i = 0; $i < $rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		if(is_null($row['img_link']))
			$row['img_link'] = "http://localhost/tw/img/noalbum.png";
		echo '<audio id="music'.$i.'">
				<source src="http://localhost/tw/music/'.$row["title_track"].'.mp3" type="audio/mpeg">
			</audio>
			<div class="main-player">
				<div class="album-image" style="background-image: url('.$row["img_link"].')">
					<button id="mini-play'.$i.'" onclick="play('.$i.')" class="little-player play on"></button>
					<button id="mini-pause'.$i.'" onclick="pause('.$i.')" class="little-player pause off"></button>
				</div>
				<div class="track-link">
					<p class="marquee resp"><span><a href="eminem.php?name='.$row["name"].'" id = "player_name_track'.$i.'">'.$row["name"].' - '.$row["title_track"].'</a></span></p>
				</div>';								
		if(isset($_SESSION['email'])) {
			echo '<div class="add"><button onclick="mini_menu('.$i.')" class="add-button"></button></div>
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
		echo '</div>';
	}
	$db->close();
?>
</div>

			<div class="bio">
					<h1>Biography</h1>
					Marshall Bruce Mathers III (born October 17, 1972), known professionally as Eminem /ˌɛmɪˈnɛm/; often stylized as EMINƎM), is an American rapper, songwriter, record producer, record executive and actor. He is one of the most successful musical artists of the 21st century.[2] In addition to his solo career, Eminem was a member of the hip hop group D12. He is also known for collaborations with fellow Detroit-based rapper Royce da 5'9"; the two are collectively known as Bad Meets Evil.

					After his debut album Infinite (1996) and the extended play Slim Shady EP (1997), Eminem signed with Dr. Dre's Aftermath Entertainment and subsequently achieved mainstream popularity in 1999 with The Slim Shady LP and its lead single "My Name Is".[3] His next two releases The Marshall Mathers LP (2000) and The Eminem Show (2002) were worldwide successes and were both nominated for the Grammy Award for Album of the Year. As a result of being a leading figure in a form of black music, Eminem was subject to comparisons to Elvis Presley at the time.[4] After the release of Encore in 2004, which faced heavy criticism by fans and critics for its lackluster quality,[5] Eminem went on hiatus in 2005 partly due to a prescription drug addiction.[6] He released Relapse in 2009 and Recovery the following year, which both won Grammy Awards for Best Rap Album. Recovery was the best-selling album of 2010 worldwide, making it his second album, after The Eminem Show in 2002, to be the best-selling album worldwide. In the following years, he released the US number one albums The Marshall Mathers LP 2, Revival, Kamikaze and Music to Be Murdered By.lz

					Eminem starred in the drama film 8 Mile (2002) playing a fictionalized version of himself, which won the Academy Award for Best Original Song for "Lose Yourself", making him the first hip hop artist to ever win the award.[7] He has made cameo appearances in the films The Wash (2001), Funny People (2009), and The Interview (2014), and the television series Entourage (2010). Eminem has developed other ventures, including Shady Records, with manager Paul Rosenberg, which helped launch the careers of artists such as 50 Cent, Yelawolf and Obie Trice, among others. He has also established his own channel, Shade 45, on Sirius XM Radio.

					Eminem is among the best-selling music artists of all time.[8] He was the est-selling music artist in the United States in the 2000s. The Marshall Mathers LP, The Eminem Show, "Lose Yourself", "Love the Way You Lie" and "Not Afraid" are all certified Diamond by the Recording Industry Association of America (RIAA).[9] He has won numerous awards, including 15 Grammy Awards, eight American Music Awards, 17 Billboard Music Awards, an Academy Award (for Best Original for "Lose Yourself") and a MTV Europe Music Award for Global Icon.[10] [11] Eminem has had ten number one albums on the Billboard 200, which all consecutively debuted at number one on the chart making him the only artist to achieve this,[12] and five number-one singles on the Billboard Hot 100.[13] Rolling Stone included Eminem in its list of the 100 Greatest Artists of All Time.[14] 
				</div>
		</div>
	</div>
	<div class="comment-container">
				<div class="comm-and-input">
		<?php	
			if(isset($_SESSION['email'])) {
				echo '
					<form>
						<textarea placeholder="Write your comment" required=""></textarea>
						<div><button>Submit</button></div>
					</form>	';
					}
		?>	
						<ul>
						<?php  
							echo '<li><div class="comment"><p>name</p><hr><div>comment</div></div></li>';
						?>
						</ul>
						<div class="more_comm"><a>More comments</a>
						</div>
					</div>
				</div>
				
			
	<?php
		echo file_get_contents("resources/player.html"); 
	 ?>
</body>
</html>