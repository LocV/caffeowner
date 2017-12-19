<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Edit Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$itemId=$_GET['itemId'];
			$shoppingListId=$_GET['shoppingListId'];
			echo "<div class='alert alert-info'> URL Values listId= '$shoppingListId'  URL Values itemId= '$itemId' </div>";
			
			if ($itemId >= 1)
			{
				if($result = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
					VALUES('$shoppingListId','$itemId')") != true)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
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
                		  </tr>
              			</thead>
			  		   <tbody>
				  		<?php 
					  		$result = $mysqli->query("SELECT id, dateCreated, name, description FROM ShoppingList");
				
							while($data = $result->fetch_object() ):
			  			?>
			  			  <tr>
			  			  	<td><?php echo $data->dateCreated ?></td>
			  			  	<td><a href="editShoppingList.php?shoppingListId=<?php echo $data->id ?>"><?php echo $data->name ?></a></td>
			  			  	<td><?php echo $data->description ?></td>
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("select idItem, item, description, par from Item");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->description ?></td>
                  <td><?php echo $data->par ?></td>
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

