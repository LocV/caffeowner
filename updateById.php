<?php include 'template-parts/header.php' /** calling of header(to make it uniform in all template file) **/?>
	<div class="container home">
		<h3> Update New Student </h3>
		
		<?php
			include 'connection.php'; /** calling of connection.php that has the connection code **/
			
			$ID = $_GET['id']; /** get the student ID **/
			
			if( isset( $_POST['update'] ) ): /** A trigger that execute after clicking the submit 	button **/
				
				/*** Putting all the data from text into variables **/
				
				$fname = $_POST['fname']; 
				$mname = $_POST['mname'];
				$lname = $_POST['lname'];
				$addr = $_POST['addr'];
				$gender = $_POST['gender'];
				$course = $_POST['course'];
				$year = $_POST['year'];
				$section = $_POST['section'];
				
				mysql_query("UPDATE student_record SET fname = '$fname', mname = '$mname', lname = '$lname', addr = '$addr', gender = '$gender', course = '$course', year = '$year', section='$section' WHERE ID = '$ID'") 
							or die(mysql_error()); /*** execute the insert sql code **/
							
				echo "<div class='alert alert-info'> Successfully Updated. </div>"; /** success message **/
			
			endif;
			
			
			$result = mysql_query("SELECT * FROM student_record WHERE ID='$ID'");
			
			$data = mysql_fetch_object( $result ); 
			
		?>
		
		
		<form action="" method="POST">
			<label> Full Name: </label>
				<input type="text" value="<?php echo $data->fname ?>" class="input-medium" name="fname" />
				<input type="text" value="<?php echo $data->mname ?>" class="input-medium" name="mname" />
				<input type="text" value="<?php echo $data->lname ?>" class="input-medium" name="lname"/>
			<label> Address: </label>
				<textarea class="span7" name="addr"><?php echo $data->addr ?></textarea>
			<label> Gender: </label>
				<select class="span2" name="gender">
					<?php if($data->gender=='Male'): ?>
						<option value="Male" selected>Male</option>
						<option value="Female">Female</option>
					<?php else: ?>
						<option value="Male">Male</option>
						<option value="Female" selected>Female</option>
					<?php endif; ?>
				</select>
			<label> Course you want to enroll: </label>
				<input type="text" value="<?php echo $data->course ?>" class="input-xxlarge" name="course" />
			<label> Year and Section </label>
				<input type="text" value="<?php echo $data->year ?>" class="input-medium" name="year"/>
				<input type="text" value="<?php echo $data->section ?>" class="input-medium" name="section"/>
			<br />
			<input type="submit" name="update" value="Update" class="btn btn-info" />	
			
		</form>		
	</div>	
</div>
</body>
</html>
