<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial scale=1">
	<link rel="stylesheet" href="style.css">
	<title>LogIn</title>
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
 	 if (empty($_POST["email"])) 
 	 {
        $email = "Name is required";
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
               
       // check if e-mail address is well-formed
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
       {
       	$email = "Invalid email format"; 
       }

	} 
	

     if(!empty($_POST['email']) && isset($_POST['email']) && !empty($_POST['psword']) && isset($_POST['psword']))
    {
    	
    	//checks if email and password is already been in mysql
 		$sql = "SELECT customer_id,customer_email, customer_password FROM customer WHERE customer_email = '$email' AND customer_password = '$psword'";
 		$data = $connection->query($sql);
 		 //var_dump($data);

 	   //if matched login	 
 	   if($data->num_rows > 0)
       {
       		session_start();
       		$row = $data->fetch_assoc();
       		$_SESSION["customer_id"] = $row['customer_id'];
    
       		echo '<script type="text/javascript">
				alert("Welcome!");
				window.location.href = "home.php";
				</script>';
       }
       //else not registered
       else
       {
       		echo '<script type="text/javascript">
				alert("Please Register Your Account!");
				window.location.href = "login.php";
				</script>';
       }
	
	}
	else
    {
    	//for debugging purposes
         exit("empty variables");
        
    }   
}

//closing connection
$connection->close();

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
} 

?>

	<!-- Login Form -->
	<div class="banner">
	
		
	<div class="form-container">
	
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">	
			<h3>login now</h3>
			<input type="email" name="email" required placeholder="Enter email" class="box">
			<input type="password" name="psword" required placeholder="Enter password" class="box">
			<input type="submit" name="login" class="btn" value="Login">
			<p><a href="adminlogin.php">Administrator Login</a></p>
		</form>
		</div>
</body>
</html>