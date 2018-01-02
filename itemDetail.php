<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3>Items Detail </h3>
		<?php include "connection.php"; /** calling of connection.php that has the connection code **/ 
		
		    $itemId=$_GET['idItem'];
		    
		
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
                  <td><?php echo $data->id ?></td>
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
	</div>	
</div>
</body>
</html>