<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>	
<div class="container home">
		<h3> Read all the student profile </h3>
		<?php include "connection.php" /** calling of connection.php that has the connection code **/ ?>
		<table class="table table-bordered">
              <thead>
                <tr>
                  <th width="60px">Stud ID</th>
                  <th>Full Name</th>
                  <th>Address</th>
                  <th>Gender</th>
				  <th>Course, Year and Section</th>
				  <th> </th>
                </tr>
              </thead>
              <tbody>
			  <?php 
				$result = mysql_query("SELECT * FROM student_record");
				
				while($data = mysql_fetch_object($result) ):
			  ?>
                <tr>
                  <td><?php echo $data->ID ?></td>
                  <td><?php echo $data->fname." ".$data->mname." ".$data->lname ?></td>
                  <td><?php echo $data->addr?></td>
				  <td><?php echo $data->gender?></td>
				  <td><?php echo $data->course." ".$data->year." ".$data->section ?></td>
				  <td>
					<a href="deleteById.php?id=<?php echo $data->ID ?>">
						<button class="btn btn-danger"> Delete </button>
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
