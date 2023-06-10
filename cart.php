<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<title>Cart</title>
</head>
<body>

<div class="banner">

	<table class="table-text" border="1" style="width:100%">
					<thead>
						<tr>
							<th style="font-size:200%">Menu</th>
							<th style="font-size:200%">Price</th>
							<th style="font-size:200%">Quantity</th>
						</tr>
					</thead>
</div>

<?php 
 
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "snackhouse";


if($_SERVER['REQUEST_METHOD'] == 'GET')
{

	//creating connection
	$connection = new mysqli($servername,$username,$password, $dbname);
 
	//checking connection
	if($connection->connect_error)
	{
		die("Connection Failed: ". $connection->connect_error);
	}	

	session_start();
	$customerID = $_SESSION["customer_id"];

	//table join
	$sql = "SELECT menu.menu_name, menu.price,cart.quantity
	FROM cart
	INNER JOIN menu
	ON cart.menu_id = menu.menu_id WHERE cart.customer_id = '$customerID' AND cart.cart_status = 'Unpaid'";

	$data = $connection->query($sql);
	if($data->num_rows > 0)
 	{

		//Fetching Results -->
   	 	while ($row = $data->fetch_assoc()) 
   	 	{	

     	//Displaying Data from mysql 
		echo"<tr style='font-size:150%'><td style='text-align:center'>".$row['menu_name']."</td><td style='text-align:center'>".$row['price']."</td><td style='text-align:center'>".$row['quantity']."</td></tr>";
    	}

	}

}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	       	

	//creating connection
	$connection = new mysqli($servername,$username,$password, $dbname);

	session_start();
	$cartstatus = "Unpaid";
	$customerID = $_SESSION["customer_id"];		
	$sql1 = "SELECT checkout_id FROM cart WHERE customer_id = '$customerID' AND cart_status = '$cartstatus' limit 1";
	$data = $connection->query($sql1);

	if($data->num_rows > 0)
 	{
 		$row = $data->fetch_assoc();
 		$cartID = $row['checkout_id'];
		//Fetching Results -->
 	}

	$sql = "INSERT INTO snackhouse.order(checkout_id,customer_id)
        	 VALUES ($cartID,$customerID)"; 
    $data1 = $connection->query($sql); 

    $sql2 = "UPDATE cart SET cart_status ='Paid' WHERE customer_id = '$customerID' AND checkout_id = $cartID";
    $data2 = $connection->query($sql2);
    
    if($data1 === TRUE)
	{
		if($data2 === TRUE)
		{
			echo '<script type="text/javascript">
			alert("Recorded Added Successfully!");
			window.location.href = "order.php";
			</script>';

		}
		else
		{
			echo "Error: ". $sql. "<br>". $connection-> error;
		} 	
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
</table>


<div class="cartbtn">
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">	
			<input type="submit" name="submit" value = "Check Out" id="botom">
	</form>
</div>


</body>
</html>