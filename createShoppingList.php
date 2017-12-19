<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Create Shopping List </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			if( isset( $_POST['addProduct'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				
				$name = $_POST['name']; 
				$description = $_POST['description'];
				
				echo "<div class='alert alert-info'> executing querry: INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')  </div>";
				
				if ($mysqli->query("INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
				}
			}
		?>		
		
		<form action="" method="POST">
			<label> Create Shopping List: </label>
				<input type="text" placeholder="Enter List Name" class="input-large" name="name" />
				<br>
				<input type="text" placeholder="Description" class="input-xxlarge" name="description" />
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
                  <th>Date</th>
                  <th>Name</th>
				  <th>Description</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT id, dateModified, name, description
					FROM ShoppingList ORDER BY dateModified DESC");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->id ?></td>
                  <td><?php echo $data->dateModified ?></td>
                  <td><?php echo $data->name ?></td>
				  <td><?php echo $data->description ?></td>
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
