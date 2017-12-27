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
		
				$result = $mysqli->query("SELECT ShoppingList_Item.`idItem`, status, urgency, Item.`item`, ShoppingList_Item.`quantity`, Supplier.`supplier`, Product.`price`
											FROM `Item`, `ShoppingList_Item`, `Supplier`, `Product`
											WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
											AND Item.`idItem` = ShoppingList_Item.`idItem`
											AND Product.`idItem` = Item.`idItem`
											AND Product.`idSupplier` = Supplier.`idSupplier`
											order by Item.`item`, Product.`price`");				
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
			<input type="submit" value="Submit">
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID</th>
                  <th>Status</th>
                  <th>Urgency</th>
                  <th>Quantity</th>
                  <th>Item</th>
				  <th>Price</th>
				  <th>Supplier 1</th>
				  <th>Price</th>
				  <th>Supplier 2</th>
                </tr>
              </thead>
              <tbody>
	              <?php
		              $previousItemId = null;
		              $tableClosed= true;
		              
		              while($listArray = $result->fetch_assoc())
		              {
				   ?>
			       				
				   	<?php 
			       		if ($previousItemId != $listArray['idItem'])
				       		{
				       		if (!$tableClosed){
			       		?>
			       				<td></td>
			       				<td></td>
				   			   </tr>
				   			<?php } ?>   
			       			
			       		<tr>
				       		<td><input type="checkbox" name="item" value="<?php echo $listArray['idItem'] ?>"></td>
				       		<td>
					       		<select name="status" class="input-small"> <!--Supplement an id here instead of using 'text'-->
					   				<option value="purchase" selected>purchase</option> 
					   				<option value="deferred" >deferred</option>
					   				<option value="fulfilled">fulfilled</option>
					  			</select><?php echo $listArray['status'] ?>
					  		</td>
				       		<td><?php echo $listArray['urgency'] ?></td>
				       		<td><input type="text" name="quantity" class="input-mini" value="<?php echo $listArray['quantity'] ?>"</td>
				       		<td><?php echo $listArray['item'] ?></td>
				       		<td><?php echo $listArray['supplier'] ?></td>
				       		<td><?php echo $listArray['price'] ?></td>
			       		<?php
				       		$tableClosed = false;
				       		}else {
					    ?>
					       		<td><?php echo $listArray['supplier'] ?></td>
						   		<td><?php echo $listArray['price'] ?></td>
			       			  </tr>
						<?php
								$tableClosed = true;
				       		}
	
					  $previousItemId = $listArray['idItem'];
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

