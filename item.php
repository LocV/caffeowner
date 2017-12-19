<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3>Inventoried Items </h3>
		<?php include "connection.php" /** calling of connection.php that has the connection code **/ ?>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID</th>
                  <th>Item</th>
                  <th>Description</th>
				  <th>Category</th>
				  <th>Brand</th>
				  <th>Price</th>
				  <th>Supplier</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT Item.idItem, item, description, category, brand, price, supplier
					FROM Item 
					JOIN Product ON Item.`idItem` = Product.`idItem`
					JOIN Supplier On Product.`idSupplier` = Supplier.`idSupplier`");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->idItem ?></td>
                  <td><?php echo $data->item ?></td>
				  <td><?php echo $data->description ?></td>
				  <td><?php echo $data->category ?></td>
				  <td><?php echo $data->brand ?></td>
				  <td><?php echo $data->price ?></td>
				  <td><?php echo $data->supplier ?></td>
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