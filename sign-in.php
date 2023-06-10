<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial scale=1">
		<link rel="stylesheet" href="style.css">
		<title>Register</title>
	</head>
	<body>
	
<?php  
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "snackhouse";

//creating connection
$connection = new mysqli($servername,$username,$password, $dbname);
 
//checking connection
if($connection->connect_error)
{
	die("Connection Failed: ". $connection->connect_error);
}	

//server side validation 
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
 {
 	 if (empty($_POST["name"])) 
 	 {
        $name = "Name is required";
     }
     else 
     {
       $name = test_input($_POST["name"]);
     }	

     if (empty($_POST["address"])) 
 	 {
        $address = "Address is required";
     }
     else 
     {
       $address = test_input($_POST["address"]);

     }

     if (empty($_POST["cpno"])) 
 	 {
        $cpnum = "Cellphone number is required";
     }
     else 
     {
       $cpnum = test_input($_POST["cpno"]);

     }

 	 if (empty($_POST["email"])) 
 	 {
        $email = "Email is required";
     }
     else 
     {
       $email = test_input($_POST["email"]);
     }
            
     if (empty($_POST["psword"])) 
     {
       $psword = "Password is required";
            
     }
     else 
     {
       $psword = test_input($_POST["psword"]);
       
     }
	
	 //checking if user input is null, if null no creating of record
     if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['address']) && !empty($_POST['address']) && isset($_POST['cpno']) && !empty($_POST['cpno']) && !empty($_POST['email']) && isset($_POST['email']) && !empty($_POST['psword']) && isset($_POST['psword']))
    {
    	
    	//checks if email is already existed in the database
 		$select = "SELECT * FROM customer WHERE customer_email = '$email' ";
 		$data = $connection->query($select);
 	   if($data->num_rows > 0)
       {
       		while ($row = $data->fetch_assoc()) 
       		{
       			
       			exit("Email is already existed!");
       		}
       }
	   else
		{
			$sql = "INSERT INTO customer(customer_name, customer_address,customer_pno,customer_email,customer_password)
         VALUES ('$name', '$address','$cpnum','$email','$psword')";
		}
       
    }
    else
    {
    	//for debugging purposes
         exit("empty variables");
        
    }   

    if($connection->query($sql) === TRUE)
	{
		echo '<script type="text/javascript">
		alert("Recorded Added Successfully!");
		window.location.href = "sign-in.php";
		</script>';

	}
	else
	{
		echo "Error: ". $sql. "<br>". $connection-> error;
	}

}

$connection->close();

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
} 

?>
	<!-- Signin Form -->
	<div class="banner">	
		
		<div class="form-container">
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">	
				<h3>Register now</h3>
				<input type="text" name="name" required placeholder="Enter username" class="box">
				<input type="text" name="address" required placeholder="Enter address" class="box">
				<input type="text" name="cpno" required placeholder="Enter Contact Number" class="box">
				<input type="email" name="email" required placeholder="Enter email" class="box">
				<input type="password" name="psword" required placeholder="Enter password" class="box">
				<input type="submit" name="sign" class="btn" value="Sign-in">
				<p>already have an account? <a href="login.php">login now</a></p>
			</form>
		</div>
	</div>
	</body>
</html>