<div class="comment-container">
	<div class="comm-and-input">
		<?php	
			include 'connection.php';
			$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
			if(isset($_SESSION['email'])) {
				echo '
					<form method="post" action="send_comment_to_artist.php">
						<textarea name="comment" placeholder="Write your comment" required=""></textarea>
						<input style="display:none"name="id" value="'.$artist_row['id'].'">
						<div><button type="submit" value="Submit">Submit</button></div>
					</form>	';
					}
		?>	
				<ul>
				<?php  
				$result = $db->query("SELECT artistcomments.id, artistcomments.date, artistcomments.comment, artistcomments.id_user, users.email FROM `artistcomments` join `users` on artistcomments.id_user = users.id where id_artist = ".$artist_row['id']." order by 2 desc limit 0, 15") or die("mysql_error");
							$rows = $result->num_rows;
				if ($rows != 0) {
					for($i = 0; $i < $rows; $i = $i + 1) {
						$row = $result->fetch_assoc();
							echo '<li><div class="user_comment"><p>User: <a href ="profile.php?email='.$row['email'].'">'.$row['email'].'</a></p><p>Date: '.$row['date'].'</p><hr><div class="text_comment"><p>Comment: '.$row['comment'].'</p></div>';
								if(isset($_SESSION['admin']) and $_SESSION['admin'] == 1)
									echo '<hr><div class="delete_div"><a href="delete_artist_comment.php?id='.$row['id'].'" class ="delete_button">Delete comment</a></div></div></li>';
								else
									echo '</div></li>';
					}
				}
				else
					echo '<li><div class="comment"><p>No comments!</p></div></li>';
				echo'</ul>';
				if ($rows > 15)
						echo '<div class="more_comm"><a>More comments</a></div>';

				$db->close();
			?>
	</div>
</div>