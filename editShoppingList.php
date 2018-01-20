<?php include 'template-parts/header.php'; /** calling of header(to make it uniform in all template file) **/
	  include 'utility/itemHistory.php';
?>
	<div class="container home">
		<h3> Edit Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			include 'utility/dateDiff.php';
			
			$itemId			=$_GET['itemId'];
			$shoppingListId	=$_GET['shoppingListId'];
			$filterType		=$_GET['filter'];
			$action			=$_GET['action'];
			
			if ($filterType == '') $filterType='item';
			
			if ($itemId >= 1)
			{
				// make sure this item does not already exist
				$itemCheck = $mysqli->query("Select * from  ShoppingList_Item
					where idShoppingList = '$shoppingListId'
					and idItem = '$itemId'");
				if ($itemCheck->num_rows == 0)
				{
					// insert new item
					if($result = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
						VALUES('$shoppingListId','$itemId')") != true)
					{
						die(mysql_error()); /*** execute the insert sql code **/
					} else {
						echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
					}
					
					// Add to ItemHistory
					if($result = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemId', '$addToShoppingList', '$shoppingListId')") != true)
					{
						die(mysql_error()); /*** execute the insert sql code **/
					} else {
						echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
					}
				}
				else
				{
					// item already exists in list.
					$data = $itemCheck->fetch_object();
					
					if($result = $mysqli->query("UPDATE ShoppingList_Item 
												 SET quantity = quantity + 1
												 Where id = '$data->id' ") != true)
					{
						die(mysql_error()); /*** execute the insert sql code **/
					} 
					else 
					{
						echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
					}
				}
			}
		 if ($shoppingListId == ''){
		 ?>
		<label>Select the shopping list to edit</label>
					<table class="table table-bordered">
						<thead>
						  <tr>
						    <th width="60px">Date</th>
							<th>Name</th>
							<th>Description</th>
							<th>Status</th>
							<th>Close</th>
                		  </tr>
              			</thead>
			  		   <tbody>
				  		<?php 
					  		$result = $mysqli->query("SELECT id, dateCreated, name, description, status FROM ShoppingList
					  								  ORDER BY dateCreated DESC");
				
							while($data = $result->fetch_object() ):
			  			?>
			  			  <tr>
			  			  	<td><?php echo $data->dateCreated ?></td>
			  			  	<td><a href="editShoppingList.php?shoppingListId=<?php echo $data->id ?>"><?php echo $data->name ?></a></td>
			  			  	<td><?php echo $data->description ?></td>
			  			  	<td><?php echo $data->status ?></td>
			  			  	<td><a href="editShoppingList.php?shoppingListId=<?php echo $data->id ?>&action=close"><button class="btn btn-info"> Close </button></td>
                		  </tr>
						<?php	
							endwhile;
				
			  			?>
			  		</table>
		<?php } else if ($action == "close"){ 
			
			// Close out this shipping list
			echo "<div class='alert alert-info'>Let's close out this shopping list</div>";
			
			$dateNow = new dateTime('now');
			
			// 1) Iterate through every item in shopping list and update the status of each shipping list item
			$result = $mysqli->query("SELECT Item.idItem, Item.item, quantity, urgency, frequency
									  FROM `Item`, `ShoppingList_Item`
									  WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
									  AND Item.`idItem` = ShoppingList_Item.`idItem`");
				
				while($data = $result->fetch_object() ){
					$frequency = 1;
						
					// Update frequency count
					$itemInContext = $data->idItem;
					echo "<div class='alert alert-info'>Debug itemInContext: $itemInContext</div>";
					
					// Select the most recent history for the item.
					$ihResult = $mysqli->query("SELECT idItem, action, date
											  FROM itemHistory
											  Where idItem='$itemInContext'
											  ORDER BY date DESC
											  LIMIT 1");						  
					
					// Only process frequency if item has a purchase history.						  
					while ($data = $ihResult->fetch_object()){
										
						echo "<div class='alert alert-info'>DEBUG itemInContext: $itemInContext</div>";
					
						$daysDiff = days_diff(new dateTime($data->date),$dateNow);
						echo "<div class='alert alert-info'>Frequency diff:  Days since last Purachase: $daysDiff </div>";
						
						// don't divide by zero
						if ($daysDiff == 0){ $daysDiff = 1; }
						
						// get current frequency
						if ($currentFrequency == 0){
							$currentFrequency = 7/14; // default frequency is 2 weeks
						} else {
							$currentFrequency = 7/$daysDiff;
						}
						
						if($frequencyQR = $mysqli->query("SElECT frequency FROM Item WHERE idItem=$itemInContext"))
						{
							$frequency = $frequencyQR->fetch_object();
						}
						
						$newFrequency = ($currentFrequency + $frequency)/2;
						
						// Insert new frequency
						if($insertResult = $mysqli->query("UPDATE Item 
														   SET frequency = $newFrequency
														   WHERE idItem = '$itemInContext'") != true)
						{
							die(mysql_error());
						} else {
							echo "<div class='alert alert-info'>ItemHistory successfully updated frequency :$newFrequency </div>"; /** success message **/
						}
					}
					
					// update itemHistory
					if($insertResult = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$IHpurchased', '$shoppingListId')") != true)
					{
						echo "<div class='alert alert-info'>Error executing query: INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$IHpurchased', '$shoppingListId') </div>";
						die(mysql_error());
					} else {
						echo "<div class='alert alert-info'>ItemHistory successfully added </div>"; /** success message **/
					}
											  
					
				}
					
				// update shopping list status
				if($insertResult = $mysqli->query("UPDATE ShoppingList
												   SET status='$COfulfilled'
												   WHERE id='$shoppingListId'") != true)
				{
					die(mysql_error()); 
				} else {
					echo "<div class='alert alert-info'>ShoppingList status successfully updated </div>"; /** success message **/
				}
				
					
		}
		else { ?>
		
		<div style="overflow-y: scroll; height:300px;">
		<label>Inventory Items</label>
		<label>Filter by:</label>
			<a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&filter=department"><button class="btn btn-info"> Department </button></a>  
			<a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&filter=category"><button class="btn btn-info"> Category </button></a>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Add</th>
	              <th>Item</th>
                  <th>Par</th>
                  <th>Category</th>
                  <th>Dept.</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT idItem, item, description, par, department, category 
									      FROM Item
										  ORDER BY $filterType");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&itemId=<?php echo $data->idItem ?>">Add</a></td>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->par ?></td>
                  <td><?php echo $data->category ?></td>
                  <td><?php echo $data->department ?></td>
                </tr>
			  <?php
				endwhile;
				
			  ?>
              </tbody>
		</table>
		</div>
		<br>
		<label> Current Shopping Lists</label>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Quantity</th>
				  <th>Urgency</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT Item.item, quantity, urgency
											FROM `Item`, `ShoppingList_Item`
											WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
											AND Item.`idItem` = ShoppingList_Item.`idItem`");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->quantity ?></td>
				  <td><?php echo $data->urgency ?></td>
                </tr>
			  <?php
				endwhile;
				
				}	
			  ?>
              </tbody>
		</table>
	</div>	
</div>
</body>
</html>

