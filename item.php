<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3>Inventoried Items </h3>
		<?php include "connection.php" /** calling of connection.php that has the connection code **/ ?>
		<form action="" method="POST">
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Item_ID<br></th>
                  <th>Item</th>
                  <th>Description</th>
				  <th>Par</th>
				  <th>Department
					  <select name="text" class="input-small"> <!--Supplement an id here instead of using 'text'-->
					  	<option value="BOH" selected>BOH</option> 
					  	<option value="FOH" >FOH</option>
					  </select>
				  </th>
				  <th>Category
					  <select name="text" class="input-small"> <!--Supplement an id here instead of using 'text'-->
					  	<option value="baking" selected>baking</option> 
					  	<option value="produce" >produce</option>
					  </select>
				  </th>
				  <th>frequency</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = $mysqli->query("SELECT Item.idItem, item, description, par, department, category, frequency
					FROM Item
					WHERE department='BOH' or department='FOH' or department='ALL'");
				
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
		</form>
	</div>	
</div>
</body>
</html>