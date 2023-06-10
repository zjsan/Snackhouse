<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css"> 
	<title>Admininstration</title>
</head>
<body>

		<div class="banner">
			<div class="navbar">
				<ul>
					<li><a href="adminindex.php">Add Record</a></li>
					<li><a href="adminupdate.php">Update Record</a></li>
					<li><a href="admindelete.php">Delete Record</a></li>
					<li><a href="admincheck.php">View Check Outs</a></li>
				</ul>
			</div>


	<table class="table-text" border="1" style="width:100%">
		<thead>
			<tr>
				<th style="font-size:200%">Item Number</th>
				<th style="font-size:200%">Menu</th>
				<th style="font-size:200%">Price</th>
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
 //for menu
					 
	$display = "SELECT menu_id,menu_name, price FROM menu";
	 $data = $connection->query($display);


	if($data->num_rows > 0)
    {

		//Fetching Results -->
       	while ($row = $data->fetch_assoc()) 
       		{

       		//Displaying Data from mysql 
		      echo"<tr style='font-size:150%'><td style='text-align:center'>".$row['menu_id']."</td><td style='text-align:center'>".$row['menu_name']."</td><td style='text-align:center'>".$row['price']." "."Pesos"."</td>";
       		}
    }	
    else
    {
       exit("no record");
    }	

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$menuID = test_input($_POST['productNumb']);
	$menuName = test_input($_POST['productname']);
 	$menuPrice = test_input($_POST['productprice']);

 	//sql query for update
	$sql = "UPDATE menu SET menu_id = '$menuID',menu_name ='$menuName', price ='$menuPrice' WHERE menu_id = '$menuID' ";

	if($connection->query($sql) === TRUE)
	{
		echo '<script type="text/javascript">
			  alert("Record Updated!");
			  window.location.href = "adminupdate.php";
			  </script>';

	}
	else
	{
		echo "Error: ". $sql. "<br>". $connection-> error;
	}
}

//removing uncessary datas in the input
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
} 

$connection->close();
 ?>


<!-- Form -->
	<div>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div>
				<table border="0">
					<tr align="center">
					</tr>
					<tr align="left">
						<td>
							Product Number:<input type="text" name="productNumb"required>
						</td>
					</tr>
					<tr>	
						<td>
							Product Name:<input type="text" name="productname" required>
						</td>
					</tr>
					<!-- won't go the "center"-->
					<tr align="center">
						<td>
							Product Price:<input type="text" name="productprice" required>
						</td>
					</tr>
					<tr>
						<td><input type="submit" name="save" value="Update"></td>
					</tr>
				</table>
			</div>
		</form>
	</div>	
</body>
</html>