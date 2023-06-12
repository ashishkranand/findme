<?php
session_start();
$user = $_SESSION["email"];



// error_reporting(0);

$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {
    
    $filename = $_FILES["uploadfile"]["name"];
    $filename = time().$filename;
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = './image/' . $filename;
 
    include("dbconnect.php");
 
    // Get all the submitted data from the form
    $sql = "update registration set filename='$filename' where email='$user'";
    // $sql = "INSERT INTO registration (filename) VALUES ('$filename') where email= '$user'";

    // Execute query
    mysqli_query($conn, $sql);

 
    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Find Me</title>
    <link rel="stylesheet" href="./css/profilestyle.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="./css/homestyle.css">
</head>
<body>
<nav class="navbar navbar-expand-md fixed-top top-nav" style="background-color: black;">
		<div class="container">
			<a class="navbar-brand" href="#"><strong>Find Me</strong></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="./home.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Services</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./profile.php">Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./logout.php">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
    <div class="main">
        <br>
        <h1>Update Profile</h1><br>
        <div class="center">
            <div class="head">
                <?php
                include("dbconnect.php");
        $query = " select * from registration where email='$user'";
        $result = mysqli_query($conn, $query);
 
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
            <img class="img" src="./image/<?php echo $data['filename']; ?>" alt="Not available">
        <?php
        mysqli_close($conn);
        }
        ?>
                
                <form action="" method="POST" enctype="multipart/form-data">
                   <input type="file" name="uploadfile" id="" accept="image/*" >
                   <input type="submit" name="upload" value="Update Image" class="updatebtn">
                </form>
            </div>
            <div class="body">

                    <?php
                     include("dbconnect.php");
                     $sql = "SELECT * FROM registration where email='$user'";
                     $retval = mysqli_query($conn ,$sql);
                     if(mysqli_num_rows($retval)>0){
                         while($row=mysqli_fetch_assoc($retval)){
                             ?>
             
                         <h2 style="color:black;text-align:center;margin-top:2%;font-weight:bolder;"><?php echo $row['fname']." "; echo $row['lname'];?></h2>
             <?php  
             
                         }
                     }
                     else{
                         echo "0 results.";
                     }
                     mysqli_close($conn);
                    ?>

            </div>
        </div>
    </div>
</body>
</html>