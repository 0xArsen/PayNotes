<?php
include 'include.php';



?>
<html lang="en">
<head>
	<title>PayNotes</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Note Taking Payment System">
	<meta name="author" content="MD Kabir and Arsen Akishev">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
	<link rel="stylesheet" href="style.css"/>
</head>
<body>
	<div id="top-header" class="zoomIn animated">
		<h1>PayNotes</h1>
	</div>
	<div class="container">
		<div id="organization" class="fadeIn animated">
			<h4>Welcome
<?php  $ip = $_SERVER['REMOTE_ADDR'];
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                              if($query && $query['status'] == 'success' && $query['org'] != null) {
                                  echo $query['org'];
                                  echo " ";
}
 ?>students, here are your peers' requested notes:</h4>
		</div>
		<?php
                        $show_q = "SELECT ID, course_name, price, requester_email FROM maintable WHERE helper_email IS NULL AND organisation = '".$query['org']."'  ORDER BY ID DESC";
                        $st_q= mysqli_query($conn, $show_q) or die('Query failed: ' . mysqli_error($conn));
                        while($row = $st_q->fetch_assoc()){
                               // echo  $row['course_name'].",".$row['price'].",".$row['requester_email'];
			?> <div class='lc_note animated fadeInLeft'>
			 <?php  echo "<h3>".$row['course_name']."</h3>"; ?>
			<p><strong>requested by: </strong> <?php echo $row['requester_email']; ?> </p>
  			<p><strong>price offered: </strong>$ <?php echo $row['price']; ?> </p>
			<form id="emd" name="emailf" action="email_requester.php" method="get">
                                <input name="helper_email" type="text" placeholder="Enter .edu email">
                               <input type="hidden" name="e_type" value=1>
                               <input type="hidden" name="course_name" value= <?php echo $row['course_name']; ?> >
                              <input type="hidden" name="ID" value= <?php echo $row['ID']; ?> >
                             <input type="hidden" name="requester_email" value= <?php echo $row['requester_email']; ?> >
                             <button id="hh" type="submit" class="btn btn-success sm-btn">help out</button>

                        </form>
			</div>
		<?php
                        }
                 ?>
                 <div class="req_input animated fadeInRight">
			<form method="post" action="index.php">
				<div class="input-group frontpg">
					<input name="email" id="femail" type="text" class="form-control" placeholder="Enter .edu email" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2">@yourschool.edu</span>
				</div>

				<div class="input-group frontpg">
					<span class="input-group-addon" id="basic-addon3">Lecture/Class Name</span>
					<input name="lecture" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
				</div>

				<div class="input-group frontpg">
					<span class="input-group-addon">$</span>
					<input type="text" name="amount" class="form-control" aria-label="Amount (to the nearest dollar)">
					<span class="input-group-addon">.00</span>
				</div>

				<button type="submit" class="btn btn-success sm-btn frontpg">Ask for help</button>

			</form>
			<?php
				
				if(isset($_POST["email"])){
					$insert_q = "INSERT INTO maintable (course_name,requester_email,organisation, price) VALUES('".$_POST['lecture']."','" .$_POST['email']. "', '" . $query['org'] . "', " . $_POST['amount'] . ")";
$result_q= mysqli_query($conn, $insert_q) or die('Query failed: ' . mysqli_error($conn));
				}
			
			?>
		</div>
		</div>
		<div class="main-cont">
		</div>
	</div>

</body>
</html>
