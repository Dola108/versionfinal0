<style type="text/css">
	.thread-box {
		display: inline-table;
		background-color: rgba(0,0,0,0.5);
		border:none;
		border-radius: 8px;
		box-shadow: 5px 5px 10px #4CAF50;
		height: 250px;
		width: 180px;
		text-align: center;
		margin: 20px;
		padding: 10px 10px;
	}
	.pa {
		color: #ccc;
		cursor: pointer;
		text-decoration:none;
		display:block;
		height:100%;
		font-family: sans-serif;
		font-size: 15px;
	}
	.pa:hover {
		color: #ACE3C4!important;
	}
	.pa:visited {
		color: #ccc;
	}
</style>
<?php
	include('connection.php');
	//$val = $_GET["val"];
		$myQuery = "SELECT c_id, count(*) as sames FROM comment GROUP BY c_id ORDER BY sames DESC";
		$maxLines = 8;

		$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysqli_error($dbc));
		$num_row = mysqli_num_rows($r);

		while($num_row!=0) {
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$post_id = $row['c_id'];

			$q = "SELECT * FROM post WHERE id='$post_id'";

			$rq=  mysqli_query($dbc, $q) or die($q."<br/><br/>".mysqli_error($dbc));
			$num = mysqli_num_rows($rq);

			while ($num!=0) {
				$rowq = mysqli_fetch_array($rq, MYSQLI_BOTH);
				$post = $rowq['post'];
				$tag = $rowq['tag'];
				$id = $rowq['id'];
				$likes = $rowq['likes'];
				$obj ='';
				$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 20px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );

				$obj.= '<div class="thread-box">
							<p>'.$taglink.'</p>
							<hr style="max-height:1px;">
							<p><a href="fullpost.php?id='.$id.'" class="pa" target="_blank"  style="word-wrap: break-word;max-width:180px;">'.$post.'</a></p>
						</div>';
				$maxLines--;
				if( 0 == $maxLines )
					break;
			$num--;
		echo $obj;
			}
		$num_row--;
		}		
?>