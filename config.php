<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		h1{
			margin-top: 30px;
		}
		body {
    background-image: url("img/index.jpg");
}

	</style>
</head>
<body>
	<div class="container">

		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">COUNTRY BLOCKER</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Go to Site</a></li>
    </ul>
  </div>
</nav>


		<h1>Blocked Countries</h1>
		<div class="col-md-12">
			<?php
			$file = fopen("src/blocked_country.txt","r");

			while(!feof($file)){
  				$country = fgets($file);
  				echo $country.'<br>';
  			}

			fclose($file);

			echo "<hr>";

			?>
		</div>


<button type="button" class="btn btn-info" data-toggle="modal" data-target="#add">Add</button>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#remove">Remove</button>

	


		<div id="add" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Add Blocklisted Country</h4>
		      </div>
		      <div class="modal-body">
			        <p>Select Country</p>
			        <form method="POST" action="php/change_blacklist.php">
			        <select name="countries">
				        <?php
							$file = fopen("src/country_list.txt","r");

							while(!feof($file)){
				  				$country = fgets($file);
				  				echo '<option value="'.$country.'">'.$country.'</option> ';
				  			}

							fclose($file);
						?>
											
					</select>

					<input type="submit" name="add" value="Add">
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>




		<div id="remove" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Remove Blocklisted Country</h4>
		      </div>
		      <div class="modal-body">
			        <p>Select Country</p>
			        <form method="POST" action="php/change_blacklist.php">
			        <select name="countries">
				        <?php
							$file = fopen("src/blocked_country.txt","r");

							while(!feof($file)){
				  				$country = fgets($file);
				  				echo '<option value="'.$country.'">'.$country.'</option> ';
				  			}

							fclose($file);
						?>
											
					</select>

					<input type="submit" name="remove" value="Remove">
					</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>

</div>
</body>
</html>