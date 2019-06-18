<?php include 'template-parts/header.php'; /** calling of header(to make it uniform in all template file) **/
	  include 'utility/itemHistory.php';
?>
	<div class="container home">
		<h3> Edit Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			include 'utility/dateDiff.php';

echo "<div class='alert alert-info'>Let's start debugging part 2</div>";
					/*** Putting all the data from text into variables **/
				
				$name = "Test Test List"; 
				$description = "Test file";
				$importItem = "deferred";
				
				echo "<div class='alert alert-info'> executing querry: INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')  </div>";
				
				if ($mysqli->query("INSERT INTO ShoppingList(name,description) 
					VALUES('$name','$description')") != TRUE)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
					$newListID = $mysqli->insert_id;
				}
				
				if ( $importItem == 'deferred'){
					// Select all items with a deferred status
					$result = $mysqli->query("SELECT idItem, item, status
											  FROM Item
											  WHERE status='deferred'");
				
					while($data = $result->fetch_object() )
					{
										
						$itemID = $data->idItem;
						echo "<div class='alert alert-info'>Item successfully added to shopping list: $itemID </div>";
						
						// import all items with status deferred into the new shopping list.
						if($slResult = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
							VALUES('$newListID','$itemID')") != true)
							{
							die(mysql_error()); /*** execute the insert sql code **/
						} else {
							echo "<div class='alert alert-info'>Item successfully added to shopping list: $itemID </div>"; /** success message **/
						}
					/*
						// Add to ItemHistory
						if($result = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemID', '$IH_ADDTOLIST', '$newListID')") != true)
						{
							echo "<div class='alert alert-info'>ERROR:  INSERT INTO ItemHistory(idItem, action, idShoppingList) 
												 VALUES('$itemID', '$IH_ADDTOLIST', '$newListID') </div>";
							die(mysql_error()); /*** execute the insert sql code **/
					/*	} else {
							echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
				//		}
					}
				}
			
// Iterate through every item in shopping list and update the status of each shipping list item
			$result = $mysqli->query("SELECT Item.idItem, Item.item, quantity, urgency, frequency
									  FROM `Item`, `ShoppingList_Item`
									  WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
									  AND Item.`idItem` = ShoppingList_Item.`idItem`");
				
				while($data = $result->fetch_object() ){
					echo "<div class='alert alert-info'>I am inside the while loop</div>";
					$frequency = 1;
						
					// Update frequency count
					$itemInContext = $data->idItem;
					echo "<div class='alert alert-info'>Debug itemInContext: $itemInContext</div>";
					
					$ihResult = $mysqli->query("SELECT idItem, action, date
											  FROM itemHistory
											  Where idItem='$itemInContext'
											  ORDER BY date DESC
											  LIMIT 1");						  
											  
					while ($data = $ihResult->fetch_object())
					{
					

					
						echo "<div class='alert alert-info'>DEBUG itemInContext: $itemInContext</div>";
						echo "<div class='alert alert-info'>DEBUG item date: $data->date</div>";

					
						$d1 = new dateTime($data->date);
						$d2 = new dateTime('now');
					
						$d1String = date_format($d1, 'Y-m-d H:i:s');
						$d2String = date_format($d2, 'Y-m-d H:i:s');
						echo "<div class='alert alert-info'>DEBUG d1: $d1String</div>";
						echo "<div class='alert alert-info'>DEBUG d2: $d2String</div>";
						
						echo "<div class='alert alert-info'>DEBUG 3rd try</div>";
						$daysDiff = days_diff($d1,$d2);
						echo "<div class='alert alert-info'>DEBUG daysDiff: $daysDiff</div>";
					}
					// update itemHistory
//					if($insertResult = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
//												 VALUES('$data->idItem', '$purchased', '$shoppingListId')") != true)
//					{
//						die(mysql_error());
//					} else {
//						echo "<div class='alert alert-info'>ItemHistory successfully added </div>"; /** success message **/
//					}
											  
					
				}
				
				echo "<div class='alert alert-info'>I have exited the while loop</div>";
				?>