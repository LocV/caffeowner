<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Edit Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$itemId=$_GET['itemId'];
			$shoppingListId=$_GET['shoppingListId'];
			
			if ($itemId >= 1)
			{
				// make sure this item does not already exist
				$itemCheck = $mysqli->query("Select * from  ShoppingList_Item
					where idShoppingList = '$shoppingListId'
					and idItem = '$itemId'");
				if ($itemCheck->num_rows == 0)
				{
					// insert newe item
					if($result = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
						VALUES('$shoppingListId','$itemId')") != true)
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
                		  </tr>
						<?php	
							endwhile;
				
			  			?>
			  		</table>
		<?php } else { ?>
		
		<div style="overflow-y: scroll; height:300px;">
		<label>Inventory Items</label>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item</th>
                  <th>Description</th>
                  <th>Par</th>
                  <th>Dept.</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("select idItem, item, description, par, department, category from Item");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->description ?></td>
                  <td><?php echo $data->par ?></td>
                  <td><?php echo $data->department ?></td>
                  <td><a href="editShoppingList.php?shoppingListId=<?php echo $shoppingListId ?>&itemId=<?php echo $data->idItem ?>">Add</a></td>
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
                  <th width="60px">Fulfilled</th>
                  <th>Item</th>
                  <th>Quantity</th>
				  <th>Urgency</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT Item.item, quantity, fulfilled, urgency
											FROM `Item`, `ShoppingList_Item`
											WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
											AND Item.`idItem` = ShoppingList_Item.`idItem`");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->fulfilled ?></td>
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

