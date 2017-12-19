<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Create New Student </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			if( isset( $_POST['create'] ) ): /** A trigger that execute after clicking the submit 	button **/
				
				/*** Putting all the data from text into variables **/
				
				$pname = $_POST['pname']; 
				$pdescription = $_POST['pdescription'];
				$dept = $_POST['dept'];
				$addr = $_POST['addr'];
				$gender = $_POST['gender'];
				$course = $_POST['course'];
				$year = $_POST['year'];
				$section = $_POST['section'];
				
				mysql_query("INSERT INTO student_record(fname,mname,lname,addr,gender,course,year,section) 
							VALUES('$fname','$mname','$lname','$addr','$gender','$course','$year','$section')") 
							or die(mysql_error()); /*** execute the insert sql code **/
							
				echo "<div class='alert alert-info'> Successfully Saved. </div>"; /** success message **/
			
			endif;
		?>
		
		
		<form action="" method="POST">
			<label> Product: </label>
				<input type="text" placeholder="Name" class="input-medium" name="pname" />
				<select class="span2" name="dept">
					<option value="FOH">BOH</option>
					<option value="BOH">FOH</option>
					<option value="ALL">ALL</option>
				</select>
				<br>
				<input type="text" placeholder="Description" class="input-xxlarge" name="pdescription" />
			<label> Address: </label>
				<textarea class="span7" name="addr"></textarea>
			<label> Gender: </label>
				<select class="span2" name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			<label> Course you want to enroll: </label>
				<input type="text" placeholder="Enter the complete course name" class="input-xxlarge" name="course" />
			<label> Year and Section </label>
				<input type="text" placeholder="Year" class="input-medium" name="year"/>
				<input type="text" placeholder="Section" class="input-medium" name="section"/>
			<br />
			<input type="submit" name="create" value="Create New Student" class="btn btn-info" />	
			
		</form>		
	</div>	
</div>
</body>
</html>
