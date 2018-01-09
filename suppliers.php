<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Create Shopping List </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			if( isset( $_POST['addProduct'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				
				$supplier 	= $_POST['supplier'];
				$type		= $_POST['type'];
				$name 		= $_POST['contactName']; 
				$email 		= $_POST['email'];
				$phone 		= $_POST['phone'];
				$comment 	= $_POST['comment'];
				
				echo "<div class='alert alert-info'> executing querry: INSERT INTO supplier(supplier, type, contactName, email, phone, comment) 
					VALUES('$supplier', '$type', '$name, $email, $phone, $comment'))  </div>";
				
				if ($mysqli->query("INSERT INTO supplier(supplier, type, contactName, email, phone, comment) 
					VALUES('$supplier', '$type', '$name', '$email', '$phone', '$comment')") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/ 
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
				}
			}
		?>		
		
		<form action="" method="POST">
			<label>Add Supplier: </label>
				<input type="text" placeholder="Supplier Name" class="input-large" name="supplier" />
				<select name="type" class="input-medium"> <!--Supplement an id here instead of using 'text'-->
					 <option value="produce" selected>produce</option> 
					 <option value="coffee" selected>coffee</option>
					 <option value="grocery" >grocery</option>
					 <option value="supplies">supplies</option>
					 <option value="merchandise">merchandise</option>
				</select>
				<br>
				<input type="text" placeholder="Contact Name" class="input-xlarge" name="contactName" />
				<input type="text" placeholder="Email Address" class="input-xlarge" name="email" />
				<input type="text" placeholder="Phone number" class="input-large" name="phone" />
				<input type="text" placeholder="Notes" class="input-xXlarge" name="notes" />
			<br>
			<br>
			<input type="submit" name="addProduct" value="Create List" class="btn btn-info" />	
		</form>		
		
		<hr>
		<label> Current Shopping Lists</label>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID</th>
                  <th>Supplier</th>
                  <th>Type</th>
                  <th>Contact Name</th>
				  <th>Email</th>
				  <th>Phone</th>
				  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT idSupplier, supplier, type, contactName, email, phone, comment
					FROM supplier ORDER BY supplier DESC");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->idSupplier ?></td>
                  <td><?php echo $data->supplier ?></td>
                  <td><?php echo $data->type ?></td>
                  <td><?php echo $data->contactName ?></td>
				  <td><?php echo $data->email ?></td>
				  <td><?php echo $data->phone ?></td>
				  <td><?php echo $data->comment ?></td>
                </tr>
			  <?php
				endwhile;
				
			  ?>
              </tbody>
		</table>
	</div>	
</div>
</body>
</html>
