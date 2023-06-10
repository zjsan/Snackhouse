<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial scale=1">
		<link rel="stylesheet" href="style.css"> 
		<title>Menu</title>
	</head>
	<body>

		<div class="banner">
			<div class="navbar">
				<a href="home.php"><img src="Pictures/logo.png"class="logo"><a>
				<ul>
					<li> <a href="home.php">Home</a></li>
					<li> <a href="menu.php">Menu</a></li>
					<li> <a href="image.php">Image Gallery</a></li>
					<li> <a href="aboutus.php">About Us</a></li>
					<li> <a href="contactus.php">Contact Us</a></li>
				</ul>
			</div>

			<div class="best">
				<h1>BEST SELLERS</h1>
			</div>		

			<div class="image">
				<div class="container">
				
					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu1.jpg" alt="">
						</div>
						<div class="content1">
						<h2>Vegetable Lumpia</h2>
							<p><br>PRICE:</p>
							<p>7 Pesos Per Piece</p>
						</div>
					</div>
			
					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu2.jpg" alt="">
						</div>
						<div class="content1">
							<h2>Lomi</h2>
							<p><br>PRICE:</p>
							<p>10 Pesos Per Bowl</p>
						</div>
					</div>
			
					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu3.jpg" alt="">
						</div>
						<div class="content1">
							<h2>Siomai</h2>
							<p><br>PRICE:</p>
							<p>5 Pesos per Piece</p>
						</div>
					</div>
					
					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu4.jpg" alt="">
						</div>
						<div class="content1">
							<h2>Miki</h2>
							<p><br>PRICE:</p>
							<p>10 Pesos Per Bowl</p>
						</div>
					</div>

					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu5.jpg" alt="">
						</div>
						<div class="content1">
							<h2>Empanada</h2>
							<p><br>PRICE:</p>
							<p>25 Pesos Per Piece</p>
						</div>
					</div>
					
					<div class="cards">
						<div class="imgbox">
							<img src="Pictures/menu6.jpg" alt="">
						</div>
						<div class="content1">
							<h2>Pansit</h2>
							<p><br>PRICE:</p>
							<p>15 Pesos Per Order</p>							
						</div>
					</div>					
					
				</div>
			</div>


			<div class="table" align="center">	
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "GET">
				<table class="table-text" border="1" style="width:100%">
					<thead>
						<tr>
							<th style="font-size: 30">Product Id</th>
							<th style="font-size: 30">Menu</th>
							<th style="font-size: 30">Price</th>
							<th style="font-size: 30">Action</th>
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
		       			echo"<tr><td>".$row['menu_id']."</td><td>".$row['menu_name']."</td><td>".$row['price']." "."Pesos"."</td><td><a href = quantity.php/{$row['menu_id']}>Add to Cart</a></td>";
       					}
       				 }	
       				 else
       				 {
       				 	exit("no record");
       				 }	
					$connection->close();
					 ?>
					</table>
			</form>  	
			</div>	
			
		</div>
	</body>
</html>