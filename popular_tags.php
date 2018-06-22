<!DOCTYPE html>
<html>
<style type="text/css">
	.tags {
		width: 120px;
		height: auto;
		border-radius: 8px;
	    background: rgba(0,0,0,0.3);
		margin: auto;
		padding: 7px 15px;
		box-shadow: 5px 5px 10px #333;
	}
	p a:hover {
		color: #4CFF5F !important;
	}
</style>
<body>
	<div class="tags">
		<p style="color: #4CAF50; font-size: 16px; font-family: sans-serif;">Popular tags</p>
		 <?php 
		 	include('connection.php');
			$myQuery = "SELECT tag, count(*) as sames FROM post GROUP BY tag ORDER BY sames DESC";
			$maxLines = 9;

			$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysqli_error($dbc));
			$num_row = mysqli_num_rows($r);

			while($num_row!=0) {
				$row = mysqli_fetch_array($r, MYSQLI_BOTH);
				$tag = $row['tag'];
				$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
				echo "<p>".$taglink."</p>";
				$maxLines--;
				if( 0 == $maxLines )
					break;
			}
			$num_row--;
		?>
	</div>
</body>
</html>