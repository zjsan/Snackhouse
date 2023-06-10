<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css"> 
	<title>Cart</title>
<style>
h1{
	text-align: center;
	color: white;
	background-color: #FFA07A;
	margin-top: 20px;
	margin-bottom: 20px;
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
</head>
<body>
	<div class="banner">
		<h1>Order Details:</h1>
		<table class="table-text" border="1" style="width:100%">
					<thead>
						<tr>
							<th style="font-size:200%">Order ID</th>
							<th style="font-size:200%">Customer Name</th>
							<th style="font-size:200%">Order Date</th>
						</tr>
					</thead>

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

					if ($_SERVER["REQUEST_METHOD"] == "GET") 
 			{
					session_start();
					$customerID = $_SESSION["customer_id"];//current guest's customer_id
					$item = $_GET["order_id"];
					

					//table join
					 $display = "SELECT snackhouse.order.order_id,customer.customer_name,snackhouse.order.order_date, snackhouse.order.checkout_id FROM snackhouse.order
						INNER JOIN customer
						ON snackhouse.order.customer_id = customer.customer_id WHERE snackhouse.order.customer_id = $customerID and snackhouse.order.order_id = $item
					 ";

					 $data = $connection->query($display);

					  if($data->num_rows > 0)
       				 {

				    	//Fetching Results -->
       					while ($row = $data->fetch_assoc()) 
       					{
       						$_SESSION['checkout_id'] = $row['checkout_id'];


       					//Displaying Data from mysql 
		       			echo"<tr style='font-size:150%'><td style='text-align:center'>".$row['order_id']."</td><td style='text-align:center'>".$row['customer_name']."</td><td style='text-align:center'>".$row['order_date']."</td>";
       					}

       				 }	
       				 else
       				 {
       				 	exit("no record");
       				 }	
       		}
					$connection->close();
					 ?>
					</table>
			</form>  	
			
				<h1>Ordered Items:</h1>			
				<table class="table-text" border="1" style="width:100%">
					<thead>
						<tr>
							<th style="font-size:200%">Menu</th>
							<th style="font-size:200%">Price</th>
							<th style="font-size:200%">Quantity</th>
						</tr>
					</thead>


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

	$customerID = $_SESSION["customer_id"];
	$checkoutID = $_SESSION["checkout_id"];

	//table join
	$sql = "SELECT menu.menu_name, menu.price,cart.quantity
	FROM cart
	INNER JOIN menu
	ON cart.menu_id = menu.menu_id WHERE cart.customer_id = '$customerID' AND cart.checkout_id = '$checkoutID'";

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
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">	

<div>
	<table border = "0">
		<tr align="right">
			<td>
				<a href = "order.php">Back</a>
			</td>
		</tr>	
	</table>
</form>
</div>
	
</body>
</html>