<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css"> 
	<title>Order</title>
</head>
<style>
h1{
	text-align: center;
	color: white;
	background-color: orange;
	margin-top: 100px;
	margin-bottom: 100px;
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
<body>
<div class="banner">		
		<h1>Order List</h1>

		<table class="table-text" border="1" style="width:100%">
			<thead>
				<tr>
					<th style="font-size:200%">Order ID</th>
					<th style="font-size:200%">Customer Name</th>
					<th style="font-size:200%">Order Date</th>
					<th style="font-size:200%">Action</th>
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


session_start();
$customerID = $_SESSION["customer_id"];//current guest's customer_id

					
$display = "SELECT snackhouse.order.order_id,customer.customer_name,snackhouse.order.order_date FROM snackhouse.order
INNER JOIN customer
ON snackhouse.order.customer_id = customer.customer_id WHERE snackhouse.order.customer_id = $customerID 
";
$data = $connection->query($display);

if($data->num_rows > 0)
{

//Fetching Results -->
while ($row = $data->fetch_assoc()) 
{
//Displaying Data from mysql 
echo"<tr style='font-size:150%'><td style='text-align:center'>".$row['order_id']."</td><td style='text-align:center'>".$row['customer_name']."</td><td style='text-align:center'>".$row['order_date']."</td><td><a href = orderdetails.php?order_id=".$row['order_id'].">View Order Details</a></td>"; //passing value to orderdetails
}
}

else
{
exit("no record");
}	
$connection->close();
?>
		
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">	

	
		<table class="table-text1">
			<tr>
				<td>
					<a href="menu.php">Back</a>
				</td>
			</tr>
		</table>

		</table>
	
	</form>

</div>	
</body>
</html>