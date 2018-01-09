<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$supplierId=$_GET['supplierId'];
			
			if( isset( $_POST['editSupplier'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				
				$supplier 	= $_POST['supplier'];
				$type		= $_POST['type'];
				$name 		= $_POST['contactName']; 
				$email 		= $_POST['email'];
				$phone 		= $_POST['phone'];
				$comment 	= $_POST['comment'];
				
				echo "<div class='alert alert-info'> executing querry: UPDATE supplier SET supplier='$supplier', type='$type
				', contactName='$name', email='$email', phone='$phone', comment='$comment' 
					WHERE idSupplier='$supplierId')  </div>";
				
				if ($mysqli->query("UPDATE supplier 
									SET supplier='$supplier', type='$type', contactName='$name', email='$email', phone='$phone', comment='$comment' 
									WHERE idSupplier='$supplierId'") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/ 
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
				}
			}
		?>		
		<?php			
			if ($supplierId != '')
			{
				$result = $mysqli->query("SELECT idSupplier, supplier, type, contactName, email, phone, comment
					FROM supplier
					WHERE idSupplier='$supplierId'");
				$data = $result->fetch_object()
		?>
		<form action="" method="POST">
			<br>
			<label>Edit Supplier: </label>
				<input type="text" value="<?php echo $data->supplier ?>" class="input-large" name="supplier" />
				<select name="type" class="input-medium"> <!--Supplement an id here instead of using 'text'-->
					 <option selected value="<?php echo $data->type ?>"><?php echo $data->type ?></option>
					 <option value="bakery" >bakery</option>
					 <option value="produce" >produce</option> 
					 <option value="coffee" >coffee</option>
					 <option value="grocery" >grocery</option>
					 <option value="supplies">supplies</option>
					 <option value="merchandise">merchandise</option>
				</select>
				<br>
				<input type="text" value="<?php echo $data->contactName ?>" class="input-xlarge" name="contactName" />
				<input type="text" value="<?php echo $data->email ?>" class="input-xlarge" name="email" />
				<input type="text" value="<?php echo $data->phone ?>" class="input-large" name="phone" />
				<input type="text" value="<?php echo $data->comment ?>" class="input-xXlarge" name="comment" />
			<br>
			<br>
			<input type="submit" name="editSupplier" value="Update Supplier" class="btn btn-info" />	
		</form>		
		<?php } ?>
		<hr>		
	</div>	
</div>
</body>
</html>
