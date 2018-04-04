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
			$filterDept		=$_GET['department'];
			
//			if ($filterType == '') $filterType='item';
			
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
												 VALUES('$itemId', '$IH_ADDTOLIST', '$shoppingListId')") != true)
					{
						die(mysql_error()); /*** execute the insert sql code **/
					} else {
						echo "<div class='alert alert-info'>Item successfully added to ItemHistory </div>"; /** success message **/
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
					  								  ORDER BY dateCreated DESC
					  								  LIMIT 10" );
				
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
			
			// 1) Iterate through every item in shopping list and update the status of each shipping list item that has been fulfilled
			$result = $mysqli->query("SELECT Item.idItem, Item.item, quantity, urgency, frequency, shoppingList_Item.status
									  FROM `Item`, `ShoppingList_Item`
									  WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
									  AND Item.`idItem` = ShoppingList_Item.`idItem`");
				
				while($data = $result->fetch_object() ){
					$itemInContext = $data->idItem;
					echo "<div class='alert alert-info'>DEBUG: Processing item:  $itemInContext</div>";
					echo "<div class='alert alert-info'>DEBUG: Displaying status: $data->status </div>";
					
					// check to see if item is fulfilled or deferred
					if ($data->status == $SLI_FULFILLED){
					
					// 1) Update frequency count
					$itemInContext = $data->idItem;
					echo "<div class='alert alert-info'>Debug itemInContext: $itemInContext</div>";
					
					// Select the most recent history for the item.
					$ihResult = $mysqli->query("SELECT idItem, action, date
											  FROM itemHistory
											  Where idItem='$itemInContext'
											  AND action='$IH_PURCHASED'
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
						$currentFrequency = 7/$daysDiff;
						
						if($frequencyQR = $mysqli->query("SElECT frequency FROM Item WHERE idItem=$itemInContext"))
						{
							$fData = $frequencyQR->fetch_object();
							$frequency = $fData->frequency;
						}
						
						// new frequency is the average of the old and current frequency
						$newFrequency = ($currentFrequency + $frequency)/2;
						
						// Insert new frequency
						if($insertResult = $mysqli->query("UPDATE Item 
														   SET frequency = $newFrequency
														   WHERE idItem = '$itemInContext'") != true)
						{
							die(mysql_error());
						} else {
							echo "<div class='alert alert-info'>ItemHistory successfully updated frequency :$newFrequency = ( $currentFrequency + $frequency )/2</div>"; /** success message **/
						}
					}
					
					// 2) update Item status
					if($insertResult = $mysqli->query("UPDATE Item 
													   SET status = '$STATUS_INSTOCK'
													   WHERE idItem = '$itemInContext'") != true)
					{
						echo "<div class='alert alert-info'>Error executing query: UPDATE Item 
													   SET status = '$STATUS_INSTOCK'
													   WHERE idItem = '$itemInContext') </div>";
						die(mysql_error());
					} else {
						echo "<div class='alert alert-info'>ItemHistory successfully added:  $itemInContext</div>"; /** success message **/
					}
					
					// 3) update itemHistory
					if($insertResult = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$IHpurchased', '$shoppingListId')") != true)
					{
						echo "<div class='alert alert-info'>Error executing query: INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$IHpurchased', '$shoppingListId') </div>";
						die(mysql_error());
					} else {
						echo "<div class='alert alert-info'>ItemHistory successfully added </div>"; /** success message **/
					}
											  
					
				}else {
						// 1) update the Item History
						if($insertResult = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$STATUS_DEFERRED', '$shoppingListId')") != true)
						{
							echo "<div class='alert alert-info'>Error executing query: INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemInContext', '$STATUS_DEFERRED', '$shoppingListId') </div>";
						die(mysql_error());
						} else {
							echo "<div class='alert alert-info'>ItemHistory of deferred successfully added: $itemInContext </div>"; /** success message **/
						}
						
						// 2) Update the Item status
						
						if($insertResult = $mysqli->query("UPDATE Item 
														   SET status = '$STATUS_DEFERRED'
														   WHERE idItem = '$itemInContext' ") != true)
						{
							echo "<div class='alert alert-info'>Error executing query: UPDATE Item SET status = '$STATUS_DEFERRED' WHERE idItem = '$itemInContext') </div>";
						die(mysql_error());
						} else {
							echo "<div class='alert alert-info'>Update Item status to deferred successful: $itemInContext </div>"; /** success message **/
						}
						
					}
				}
					
				// 4) update shopping list status
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
		
		<div style="overflow-y: scroll; height:400px;">
		<label>Filter by:</label>
			Department: <a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&department=BOH"><button class="btn btn-info"> BOH </button></a> 
			<a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&department=FOH"><button class="btn btn-info"> FOH </button></a>
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
				if ($filterDept == '') {
					$result = $mysqli->query("SELECT idItem, item, description, par, department, category 
									      FROM Item
									      ORDER BY '$filterType'");
				} else {
					$result = $mysqli->query("SELECT idItem, item, description, par, department, category 
									      FROM Item
									      WHERE department = '$filterDept' OR department = 'AlL'
									      ORDER BY item");
										  
				}
				
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

