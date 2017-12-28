<!DOCTYPE html>
<?php
      $pdo = new PDO(
            'mysql:host=172.18.0.2;dbname=wirechan',
            'wirechan',
            'wirechan'
      );
      $sql = "SELECT * FROM boards";

      function lastPost(PDO $pdo,$board){
            $board = "posts_".$board;
            //Select last post time
            $que = $pdo->prepare("SELECT time FROM ".$board." ORDER BY time DESC LIMIT 1");
            $que->execute();
            if($post = $que->fetchAll(PDO::FETCH_ASSOC)){
                $result = " ago";
                $currentTime = time();
                $time = intval($post[0]["time"]);
                $diff = $currentTime - $time;

                $weeks = floor($diff/604800);
                $days = floor($diff/86400);
                // This is where Aztic left off
                $hours = floor($diff/3600);
                $minutes = floor(($diff/60)%60);
                $seconds = $diff % 60;

                if($weeks){
                   $result = $weeks > 1? $weeks." weeks" .$result: $weeks." week" .$result;
                }
                else if($days){
                   $result = $days > 1? $days." days" .$result: $days." day" .$result;
                }
                // This is where Aztic left off
                else if($hours){
                   $result = $hours > 1? $hours." hours" .$result: $hours." hour" .$result;
                }
                else if($minutes){
                   $result = $minutes > 1? $minutes." minutes" .$result : $minutes." minute" .$result;
                }
                else{
                   $result = $seconds > 1? $seconds." seconds" .$result : $seconds." second" .$result;
                }
                return $result;
            }
            else{
                return "Never";
            }
      }
?>
<html>
   <head>
      <title>wirechan</title>
      <meta charset="utf-8">
      <link href="/favicon.png" rel="shortcut icon">
      <link href="f-style.css" rel="stylesheet" type="text/css">
      <script type="text/javascript" src="main.js"></script>
   </head>
   <body>
      <header>
         <nav>[ <a href="/wirechan/">home</a> / <a href="/wirechan/b/" title="Random">b</a> / <a href="/wirechan/comfy/" title="Comfyness">comfy</a> / <a href="/wirechan/test/" title="Testing board">test</a> / <a href="/wirechan/koi/" title="Koi's board">koi</a> <!--/ <a href="/board/" title="Yoshitoshi ABe">abe</a>
            / <a href="/board/" title="Programming">prog</a> / <a href="/board/" title="Site Discussion">q</a> --> ] [ <a href="https://re.wire.zone/">re:wire</a> ] </nav>
            <!-- banners thing start
            <a href="/wirechan/"><img class="banner" src="banners/banners.php" alt=""/></a>
            banners thing end-->
         <h1 id="title">wirechan</h1>
      </header>
      <hr />
      <main id="home">
         <img class="logo" height="64" src="/favicon.png" width="64">
         <table class="box">
            <tr class="top">
               <td>wirechan</td>
            </tr>
            <tr>
               <td>
                  <p>Welcome to wirechan. We have a range of cyberpunk and technology themed boards for your perusal.</p>
                  <br />
                  <h2>New Administration (21st Dec 2017)</h2>
                  <p>Wirechan is now under new administration and runs under another imageboard software!</p>
               </td>
            </tr>
         </table>
         <table class="box">
            <tr class="top">
	       <td>URL</td>
               <td>Title</td>
               <td>Last Updated</td>
            </tr>
            <?php foreach($pdo->query($sql,PDO::FETCH_ASSOC) as $row):?>
            <tr>
	       <td><a href="/wirechan/<?php echo $row['uri'];?>">/<?php echo $row['uri'];?>/</a></td>
               <td><a href="/wirechan/<?php echo $row['uri'];?>"><?php echo $row['title'];?></a></td>
               <td><a href="/wirechan/<?php echo $row['uri'];?>"><?php echo lastPost($pdo,$row['uri']) ?></a></td>
            </tr>
            <?php endforeach; ?>
            <!--
            <tr>
               <td><a href="/cy">/board/</a></td>
               <td><a href="/cy">Description</a></td>
               <td><a href="/cy">Time</a></td>
            </tr>
            <tr>
               <td><a href="/lain">/board/</a></td>
               <td><a href="/lain">Description</a></td>
               <td><a href="/lain">Time</a></td>
            </tr>
            <tr>
               <td><a href="/disc">/board/</a></td>
               <td><a href="/disc">Description</a></td>
               <td><a href="/disc">Time</a></td>
            </tr>
            <tr>
               <td><a href="/abe">/board/</a></td>
               <td><a href="/abe">Description</a></td>
               <td><a href="/abe">Time</a></td>
            </tr>
            <tr>
               <td><a href="/prog">/board/</a></td>
               <td><a href="/prog">Description</a></td>
               <td><a href="/prog">Time</a></td>
            </tr>
            <tr>
               <td><a href="/q">/board/</a></td>
               <td><a href="/q">Description</a></td>
               <td><a href="/q">Time</a></td>
            </tr>
            -->
         </table>
      </main>
      <footer>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="thing" style="margin-top:20px;text-align:center;">- <a href="http://tinyboard.org/">Tinyboard</a> + <a href='https://int.vichan.net/devel/'>vichan</a> + <a href='https://github.com/lainchan/lainchan'>lainchan</a> 5.1.3 -<br><a href="http://tinyboard.org/">Tinyboard</a> Copyright &copy; 2010-2014 Tinyboard Development Group<br><a href="https://engine.vichan.net/">vichan</a> Copyright &copy; 2012-2016 vichan-devel<br><a href="https://github.com/lainchan/lainchan">lainchan</a> Copyright &copy; 2014-2017 lainchan Administration</p>
            <p class="thing" style="text-align:center;">All trademarks, copyrights, comments, and images on this page are owned by and are the responsibility of their respective parties.</p>
            <p id="copy">re:wire group &copy; 2017-2018</p>
         </footer>
   </body>
</html>
