<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Create Inventory Item </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			if( isset( $_POST['addProduct'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				
				$item = $_POST['item']; 
				$description = $_POST['pdescription'];
				$dept = $_POST['dept'];
				$category = $_POST['category'];
				$supplier = $_POST['supplier'];
				$price = $_POST['price'];
				$brand = $_BRAND['brand'];
				$price = $_POST['price'];
				
				echo "<div class='alert alert-info'> executing querry: INSERT INTO Item(name,description,category,department) 
							VALUES('$item','$description','$category','$dept')  </div>";
				
				if ($mysqli->query("INSERT INTO Item(name,description,category,department) 
					VALUES('$item','$description','$category','$dept')") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
				}
				
				/*
					1) Insert data in to Item
				
					2) Find id in Supplier or create supplier
					
					3) insert price data into Product 
				*/
			}
		?>
		
		
		<form action="" method="POST">
			<label> Inventory Item: </label>
				<input type="text" placeholder="Name" class="input-large" name="item" />
				<select class="span2" name="dept">
					<option value="FOH">BOH</option>
					<option value="BOH">FOH</option>
					<option value="ALL">ALL</option>
				</select>
				<br>
				<input type="text" placeholder="Description" class="input-xxlarge" name="pdescription" />
				<br>
				<input type="text" placeholder="Category" class="input-medium" name="category" />
					<i>Example: baking, produce, dairy, cheese, coffee, supplies</i>
			<br>
			<br>
			<label> Product: </label>
				<input type="text" placeholder="Product Brand" class="input-large" name="brand" />
				<input type="text" placeholder="0.00" class="input-small" name="price" />
				<br>
				<input type="text" placeholder="Product Supplier" class="input-large" name="sname" />
				<br>
				<br>
			
			<input type="submit" name="addProduct" value="Add Product" class="btn btn-info" />	
			
		</form>		
	</div>	
</div>
</body>
</html>
