<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> View Shopping List </h3>
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$listId=$_GET['listId'];
			$itemId=$_GET['itemId'];
			echo "<div class='alert alert-info'> URL Values listId= '$listId'  URL Values itemId= '$itemId' </div>";
			
			if ($itemId >= 1)
			{
				if($result = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
					VALUES('$listId','$itemId')") != true)
				{
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'>Item successfully added to shopping list </div>"; /** success message **/
				}
			}
		?>
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
				$result = $mysqli->query("select idItem, item, description, par from Item
					Limit 5");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->description ?></td>
                  <td><?php echo $data->par ?></td>
                  <td><a href="editShoppingList.php?listId=4&itemId=<?php echo $data->idItem ?>">Add</a></td>
                </tr>
			  <?php
				endwhile;
				
			  ?>
              </tbody>
		</table>

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
											WHERE ShoppingList_Item.`idShoppingList` = '$listId' 
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
				
			  ?>
              </tbody>
		</table>
	</div>	
</div>
</body>
</html>

