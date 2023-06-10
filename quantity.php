<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quantity</title>
	
<style type="text/css">
*{
	margin: 0;
	padding: 0;

}
.banner{
	width: 100%;
	height: 100vh;
	display: flex;
	flex-direction: column;
	background-color: orange;
	background-size: cover;
	background-position: center;
	overflow: auto;
	overflow-x: hidden;
    justify-content: center;
    align-items: center;
}
table{
	justify-content: center;
	align-items: center;
}
.tb2 td{
    padding: 20px;
    text-align: center;
    color: black;
    background-color: DarkGoldenRod;
}

</style>

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
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

//initializing variables
$item = test_input($_POST['item']);
$quanty = test_input($_POST['quantity']);

	//checking if user input is null, if null no creating of record
 	if(isset($_POST['item']) && !empty($_POST['item']) && isset($_POST['quantity']) && !empty($_POST['quantity']))
    {	
    	session_start();
    	$customerID = $_SESSION["customer_id"];
    	$status = "Unpaid";

    	//for customers' unique ID in cart
    	$sql1 = "SELECT MAX(`checkout_id`) AS 'checkoutID' from cart WHERE customer_id = '$customerID' AND cart_status = 'Paid'";


    	//executing query
    	$data = $connection->query($sql1);

    	//if query value is Null set checkoutID to 1
    	if($data->num_rows > 0)
       {
       		 $row = $data->fetch_assoc();
       		if ($row['checkoutID'] == null) {

       			$checkoutID = 1;

       			
       		}
       		//increasing value of checkoutID
       		else{
       			$checkoutID = $row['checkoutID'] + 1;
       		}

       }

    	//inserting values in the cart table 
    	$sql = "INSERT INTO cart(customer_id,menu_id,quantity,cart_status,checkout_id) VALUES ('$customerID','$item','$quanty','$status','$checkoutID')";

         	 if($connection->query($sql) === TRUE)
			{
				
				echo '<script type="text/javascript">
				alert("Recorded Added Successfully!");
				location.replace("/Final%20Project/cart.php");
				</script>';

			}
			else
			{
				echo "Error: ". $sql. "<br>". $connection-> error;
			}
    }
    else
    {
    	echo '<script type="text/javascript">
		alert("Please enter quantity!");
		window.location.href = "quantity.php";
		</script>';
    }



$connection->close();
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
} 
?>
		
<div class="banner">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">
	<div>
	<table class="tb2" border = "0">
		<tr>
			<td>
				<strong>Item Number:</strong> <input type="text" name="item" id = "item"required>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Quantity:</strong> <input type="text" name="quantity" required>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="submit" value="Add To Cart" required>
			</td>
		</tr>
</form>	
</div>

<!-- Retrieving passed the customerID-->
<script type="text/javascript">
		url =  window.location.href;//'localhost/finalproject/quantity.php/1'
		var itemValue = (url.split('/').pop());//this gets the id from the url which is 1 
		console.log(itemValue);
		document.getElementById("item").value= itemValue;
</script>
</body>
</html>