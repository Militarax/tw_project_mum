<?php
  include 'connection.php';
  $db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));


  if ($result =$db->query("SELECT * FROM `rss` order by date desc limit 0, 50")) {  
  header("Content-Type: application/rss+xml;");
            echo '<?xml version="1.0"?>
  <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
    <atom:link href="http://localhost/rss.php" rel="self" type="application/rss+xml" />
      <title>MD&amp;MTC</title>  
      <link>http://localhost/tw/index.php</link>  
      <description>TW PROJECT</description>  
      <language>ru</language>';

            while ($row = $result->fetch_assoc()) {
                echo '
        <item>
          <title>'. $row['title'] .'</title>
          <link>http://shpargalkablog.ru/'. $row['link'] .'</link>
          <pubDate>'.date('r', strtotime($row['date'])).'</pubDate>
          <description>'. $row['description'] .'</description>
          <guid>http://localhost/'. $row['link'].$row['id'].'</guid>
        </item>';
            }

            echo '
    </channel>
  </rss>';
        }

  $db->close();
?>