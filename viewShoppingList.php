<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> View Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$shoppingListId=$_GET['shoppingListId'];
			
			if ($shoppingListId == '')
			{
		?>
	
				<label>Select the shopping list to view</label>
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
			  			  	<td><a href="viewShoppingList.php?shoppingListId=<?php echo $data->id ?>"><?php echo $data->name ?></a></td>
			  			  	<td><?php echo $data->description ?></td>
                		  </tr>
						<?php	
							endwhile;
				
			  			?>
		</table>
			
		<?php
			} else {
				
				$itemAction=$_GET['itemAction'];
				$ShopListId=$_GET['ShopListId'];
			
				if ($ShopListId != '') // Mark item as fulfilled
				{
					if ($update = $mysqli->query("UPDATE ShoppingList_Item 
						SET status = 'fulfilled'
						WHERE id = '$ShopListId'") == true )
						{
							echo "<div class='alert alert-info'>Shopping List updated </div>"; /** success message **/
						} 
						else 
						{
							die(mysql_error()); /*** execute the insert sql code **/
						}
				}
				 		
				$result = $mysqli->query("SELECT ShoppingList_Item.`id`, status, urgency, Item.`item`, ShoppingList_Item.`quantity`
											FROM `Item`, `ShoppingList_Item`
											WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
											AND Item.`idItem` = ShoppingList_Item.`idItem`
											order by status ASC, Item.`item`");				
			  ?>
                
			  
              </tbody>
		</table>
		
		<label>Viewing items from shopping list: 
		<?php
			$listName = $mysqli->query("Select name from ShoppingList where id = '$shoppingListId'");
			$row = $listName->fetch_object();
			echo $row->name;
		?>
		</label>
		<form action="" method="post">
			<input type="submit" value="Update" class="btn btn-info">
			<br><br>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID</th>
                  <th>Status</th>
                  <th>Urgency</th>
                  <th>Quantity</th>
                  <th>Item</th>
				  <th>Price</th>
				  <th>Supplier</th>
                </tr>
              </thead>
              <tbody>
	              <?php
		              while($listArray = $result->fetch_assoc())
		              {
			       		?>
			       					       			
			       		<tr>
				       		<td><a href="viewShoppingList.php?itemAction=fulfilled&shoppingListId=<?php echo $shoppingListId ?>&ShopListId=<?php echo $listArray['id'] ?>">Purchase</td>
				       		<td>					  			
					       		</select><?php echo $listArray['status'] ?>
					  		</td>
				       		<td><?php echo $listArray['urgency'] ?></td>
				       		<td><input type="text" name="quantity" class="input-mini" value="<?php echo $listArray['quantity'] ?>"</td>
				       		<td><a href="itemDetail.php?idItem=<?php echo $listArray['idItem'] ?>"><?php echo $listArray['item'] ?></td>
				       		<?php 
					       		$products = $mysqli->query("SELECT price, supplier 
					       			FROM `Product`, `Supplier` 
						   			WHERE idItem = '$listArray[idItem]'
						   			AND `product`.`idSupplier`= `Supplier`.`idSupplier`");
						   			
						   			$data = $products->fetch_object()				
					       	?>
				       		<td><?php echo $data->supplier ?></td>
				       		<td><?php echo $data->price ?></td>
			     <?php		
		              }
		           ?>
              </tbody>
		</table>
		</form>
		<?php } ?>
	</div>	
</div>
</body>
</html>

