<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Create Shopping List </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			include 'utility/itemHistory.php';
			
			if( isset( $_POST['createList'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				
				$name = $_POST['name']; 
				$description = $_POST['description'];
				$importItem = $_POST['importItem'];
				
				if (DEBUGGING){ echo "<div class='alert alert-info'> executing querry: INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')  </div>";}
				
				if ($mysqli->query("INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					if (DEBUGGING){ echo "<div class='alert alert-info'> Successfully created shopping list. </div>"; /** success message **/
					$newListID = $mysqli->insert_id;}
				}
				
				if ( $importItem == 'deferred'){
					// Select all items with a deferred status
					$result = $mysqli->query("SELECT idItem, item, status
											  FROM Item
											  WHERE status='deferred'");
				
					while($data = $result->fetch_object() ):
					
					
						$itemID = $data->idItem;
						
						// import all items with status deferred into the new shopping list.
						if($slResult = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
							VALUES('$newListID','$itemID')") != true)
							{
							die(mysql_error()); /*** execute the insert sql code **/
						} else {
							if (DEBUGGING){ echo "<div class='alert alert-info'>Item successfully added to shopping list: $itemID </div>"; }/** success message **/
						}
					
						// Add to ItemHistory
						if($ihResult = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemID', '$IH_ADDTOLIST', '$newListID')") != true)
						{
							if (DEBUGGING){ echo "<div class='alert alert-info'>ERROR:  INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemID', '$IH_ADDTOLIST', '$newListID') </div>"; }
							die(mysql_error()); /*** execute the insert sql code **/
						} else {
							if (DEBUGGING){ echo "<div class='alert alert-info'>Item successfully added to itemHistory </div>"; }/** success message **/
						}
					endwhile;
				}
			}
		?>		
		
		<form action="" method="POST">
			<label> Create Shopping List: </label>
				<input type="text" placeholder="Enter List Name" class="input-large" name="name" />
				<br>
				<input type="text" placeholder="Description" class="input-xxlarge" name="description" />
			<br>
			<input type="checkbox" name="importItem" value="deferred"> Import deferred items.
			<br>
			<input type="submit" name="createList" value="Create List" class="btn btn-info" />
			<br> 
				
		</form>		
		
		<hr>
		<label> Current Shopping Lists</label>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Date</th>
                  <th>Name</th>
				  <th>Description</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT id, dateModified, name, description
					FROM ShoppingList ORDER BY dateModified DESC
					LIMIT 10");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
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
