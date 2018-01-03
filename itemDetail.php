<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3>Items Detail </h3>
		<?php include "connection.php"; /** calling of connection.php that has the connection code **/ 
		
		    $action		= $_GET['action'];
		    $itemId		= $_GET['idItem'];
		    $productId	= $_GET['productId'];
		
			if( isset( $_POST['addProduct'] ) ) /** A trigger that execute after clicking the submit 	button **/
			{ 
				
				/*** Putting all the data from text into variables **/
				$pBrand 	= $_POST['brand'];
				$pPrice 	= $_POST['price'];
				$pQuantity 	= $_POST['quantity']; 
				$pUnit 		= $_POST['unit'];
				$pSupplier 	= $_POST['supplier']; 
				
				// Insert Product
				if ($mysqli->query("INSERT INTO Product(brand, price, quantity, quantityUnit, idSupplier, idItem) 
					VALUES('$pBrand', '$pPrice', '$pQuantity','$pUnit','$pSupplier','$newIdItem')") != TRUE)
				{
					echo "<div class='alert alert-info'> Error saving: INSERT INTO Product(brand, quantity, quantityUnit, idSupplier, idItem) 
					VALUES('$brand','$quantity','$unit','$supplier','$newIdItem')</div>";
					die(mysql_error()); /*** execute the insert sql code **/
				} else {
					echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
				}
			}
		?>
		
		<p>Inventory Items</p>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID<br></th>
                  <th>Item</th>
                  <th>Description</th>
				  <th>Par</th>
				  <th>Department</th>
				  <th>Category</th>
				  <th>frequency</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT idItem, item, description, par, department, category, frequency
					FROM Item
					WHERE idItem='$itemId'");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->idItem ?></td>
                  <td><?php echo $data->item ?></td>
				  <td><?php echo $data->description ?></td>
				  <td><?php echo $data->par ?></td>
				  <td><?php echo $data->department ?></td>
				  <td><?php echo $data->category ?></td>
				  <td><?php echo $data->frequency ?></td>
                </tr>
			  <?php
				endwhile;
				
			  ?>
              </tbody>
		</table>
		<p>Available Products</p>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">ID<br></th>
                  <th>Brand</th>
                  <th>Price</th>
				  <th>Quantity</th>
				  <th>Quantity Unit</th>
				  <th>idSupplier</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$pResult = $mysqli->query("SELECT id, brand, price, quantity, quantityUnit, idSupplier
					FROM Product
					WHERE idItem='$itemId'");
				
				while($data = $pResult->fetch_object() ):
			  ?>
                <tr>
                  <td><a href="itemDetail.php?action=delete&idItem=<?php echo $itemId ?>&productId=<?php echo $data->id ?>"><button class="btn btn-info"> delete </button></td>
                  <td><?php echo $data->brand ?></td>
				  <td><?php echo $data->price ?></td>
				  <td><?php echo $data->quantity ?></td>
				  <td><?php echo $data->quantityUnit ?></td>
				  <?php 
					  $supplierResult = $mysqli->query("Select supplier from Supplier where idSupplier='$data->idSupplier' ");
					  $supplier = $supplierResult->fetch_object();
					?>
				  <td><?php echo $supplier->supplier ?></td>
                </tr>
			  <?php
				endwhile;
				
			  ?>
              </tbody>
		</table>
		<form action="" method="POST">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td>
							<input class="btn btn-info" type="submit" name="addProduct" value="Add">
						</td>
						<td>
							<input type="text" placeholder="Product Brand" class="input-large" name="brand" />
						</td>
						<td>
							<input type="text" placeholder="0.00" class="input-small" name="price" />
						</td>
						<td>
							<input type="text" placeholder="quantity" class="input-small" name="quantity" />
						</td>
						<td>
							<select name="unit" class="input-small">
								<option value="oz" selected>oz</option> 
								<option value="lbs" >lbs</option>
								<option value="gram">gram</option>
								<option value="ml">ml</option>
								<option value="count">count</option>
								<option value="each">each</option>
							</select>
						</td>
						<td>
							<select name="supplier" class="input-medium"> <!--Supplement an id here instead of using 'text'-->
								<?php 
								$result = $mysqli->query("SELECT idSupplier, supplier from supplier");
				
								while($data = $result->fetch_object()) {
			  					?>
					   				<option value="<?php echo $data->idSupplier ?>" ><?php echo $data->supplier ?></option> 
					   			<?php } ?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>	
</div>
</body>
</html>