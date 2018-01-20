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
			  			  	<td><a href="viewShoppingList.php?shoppingListId=<?php echo $data->id ?>"><?php echo $data->name ?></a></td>
			  			  	<td><?php echo $data->description ?></td>
			  			  	<td><?php echo $data->status ?></td>
                		  </tr>
						<?php	
							endwhile;
				
			  			?>
		</table>
			
		<?php
			} else {
				
				$itemAction=$_GET['itemAction'];
				$ShopListId=$_GET['ShopListId'];
				$itemStatus=$_GET['itemStatus'];
			
				if ($ShopListId != '') // Mark item as fulfilled or deferred
				{
					if ($update = $mysqli->query("UPDATE ShoppingList_Item 
						SET status = '$itemStatus'
						WHERE id = '$ShopListId'") == true )
						{
							echo "<div class='alert alert-info'>Shopping List updated </div>"; /** success message **/
						} 
						else 
						{
							die(mysql_error()); /*** execute the insert sql code **/
						}
				}
				 		
				$result = $mysqli->query("SELECT ShoppingList_Item.`id`, Item.idItem, ShoppingList_Item.status, urgency, Item.`item`, ShoppingList_Item.`quantity`
											FROM `Item`, `ShoppingList_Item`
											WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
											AND Item.`idItem` = ShoppingList_Item.`idItem`
											order by ShoppingList_Item.status ASC, Item.`item`");				
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
			<br><br>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="50px">Item_ID</th>
                  <th>Status</th>
                  <th>Item</th>
                  <th>Quantity</th>
				  <th>Price</th>
				  <th>Supplier</th>
                </tr>
              </thead>
              <tbody>
	              <?php
		              while($listArray = $result->fetch_assoc())
		              {
			       		if ($listArray['status'] == 'fulfilled')
			       		{
				       	?>
				       		<tr bgcolor="#eee">
					    <?php
			       		}else if ($listArray['status'] == 'deferred')
			       		{
				       	?>
				       		<tr bgcolor="#fbfdea">
					    <?php
						} else {
						?>
				       		<tr>
					    <?php
			       		}
			       		?>
			       					       			
				       		<td><a href="viewShoppingList.php?itemStatus=fulfilled&shoppingListId=<?php echo $shoppingListId ?>&ShopListId=<?php echo $listArray['id'] ?>"><button class="btn btn-info"> Purchase </button></td>
				       		<td>					  			
					       		<a href="viewShoppingList.php?itemStatus=deferred&shoppingListId=<?php echo $shoppingListId ?>&ShopListId=<?php echo $listArray['id'] ?>"><button class="btn btn-info"> Defer </button>
					  		</td>
				       		<td><a href="itemDetail.php?idItem=<?php echo $listArray['idItem'] ?>"><?php echo $listArray['item'] ?></td>
				       		<?php 
					       		$products = $mysqli->query("SELECT price, supplier 
					       			FROM `Product`, `Supplier` 
						   			WHERE idItem = '$listArray[idItem]'
						   			AND `product`.`idSupplier`= `Supplier`.`idSupplier`");
						   			
						   			$data = $products->fetch_object()				
					       	?>
					       	<td><input type="text" name="quantity" class="input-mini" value="<?php echo $listArray['quantity'] ?>"</td>
				       		<td><?php echo $data->supplier ?></td>
				       		<td><?php echo $data->price ?></td>
			     <?php		
		              }
		           ?>
              </tbody>
		</table>
		<?php } ?>
	</div>	
</div>
</body>
</html>

