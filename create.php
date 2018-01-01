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
				$par = $_POST['par'];
				$supplier = $_POST['supplier'];
				$price = $_POST['price'];
				$brand = $_BRAND['brand'];
				$price = $_POST['price'];
				
				echo "<div class='alert alert-info'> executing query: INSERT INTO Item(item, description, category, department, par) 
							VALUES('$item','$description','$category','$dept', '$par')  </div>";
				
				if ($mysqli->query("INSERT INTO Item(item, description, category, department, par) 
					VALUES('$item','$description','$category','$dept', '$par')") != TRUE)
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
					<option value="BOH">BOH</option>
					<option value="FOH">FOH</option>
					<option value="ALL">ALL</option>
				</select>
				<select name="category" class="input-small"> <!--Supplement an id here instead of using 'text'-->
					   				<option value="baking" selected>baking</option> 
					   				<option value="produce" >produce</option>
					   				<option value="dairy">dairy</option>
					   				<option value="coffee">coffee</option>
					   				<option value="supplies">suplies</option>
				</select>
				<br>
				<input type="text" placeholder="Description" class="input-xxlarge" name="pdescription" />
				<br>
				<input type="text" placeholder="Par amount" class="input-large" name="par" />
			<br>
			<br>
			<label> Product: (optional)</label>
				<input type="text" placeholder="Product Brand" class="input-large" name="brand" />
				<input type="text" placeholder="0.00" class="input-small" name="price" />
				<br>
				<input type="text" placeholder="Product Supplier" class="input-large" name="sname" />
				<br>
				<br>
			
			<input type="submit" name="addProduct" value="Add Item" class="btn btn-info" />	
			
		</form>		
	</div>	
</div>
</body>
</html>
