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
   //retrieve admin credentials from mysql
 		$sql1 = "SELECT customer_email, customer_password FROM customer WHERE customer_email = 'admin1@gmail.com' and  customer_password = 'admin1'";
 		$data1 = $connection->query($sql1);


 			//check if email and password are in the database already
 	   //if matched login	 
 		 //else prompt user to register
 		//if email = admin1@gmail.com and password = admin1 redirect page to administator page
 		//else proceed to home page

 		if ($data1->num_rows > 0) 
 		{
 			while($row = $data1->fetch_assoc())
			{ 
 					
 						//goods pag admin1@gmail.com tsaka admin1 pero admin2 hinde
 						if ($row['customer_email'] == $_POST['email'] && $row['customer_password'] == $_POST['psword']) 
 						{
 							
 							echo '<script type="text/javascript">
							alert("Welcome Admin!");
							window.location.href = "adminindex.php";
							</script>';	
 						}
 						else{
 								echo '<script type="text/javascript">
							alert("Admin Access Denied!");
							window.location.href = "login.php";
							</script>';	
 						}
 				}
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
			<h3>Administrator Login</h3>
			<input type="email" name="email" required placeholder="Enter email" class="box">
			<input type="password" name="psword" required placeholder="Enter password" class="box">
			<input type="submit" name="login" class="btn" value="Login">
		</form>
		</div>
</body>
</html>