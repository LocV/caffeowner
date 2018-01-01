<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3> Update Inventory Items </h3>
		<?php include "connection.php" /** calling of connection.php that has the connection code **/ ?>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Description</th>
				  <th>Category</th>
				  <th> </th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT * FROM Item");
				
				while($data = $result->fetch_object() ):
			  ?>
                <tr>
                  <td><?php echo $data->idItem ?></td>
                  <td><?php echo $data->item ?></td>
                  <td><?php echo $data->type ?></td>
				  <td><?php echo $data->description ?></td>
				  <td><?php echo $data->category ?></td>
				  <td>
					<a href="updatebyId.php?id=<?php echo $data->ID ?>">
						<button class="btn btn-info"> Edit </button>
					</a>
				  </td>
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
