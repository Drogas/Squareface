<?php  		
	//connection
	include("../include/functions.php");
	$conex = connection();
	
	//session start
	session_start();
		
	//query
	$modif_user = "SELECT name, last_name, nickname, email, image FROM user WHERE id = '$_SESSION[id]'";
	$result = $conex->query($modif_user);
	$row_modif_user = $result->fetch_assoc();
		$name = $row_modif_user['name'];
		$last_name = $row_modif_user['last_name'];
		$nickname = $row_modif_user['nickname'];
		$email = $row_modif_user['email'];
		$image = $row_modif_user['image'];
?> 

<script src="../js/bootstrap-filestyle.min.js"> </script>

	<div class="container">
		<div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6" id="complete_register_container">
				<h4 class="complete_register_title">Complete your information</h4>
				<form class="form-horizontal form_complete_register" role="form" method="post" name="update_user" action="../user/update_user.php" enctype="multipart/form-data">
				<div class="col-md-4 first">
					<div class="form-group">
						<img class="image_complete_register" name="image_user" src="<?php user_avatar(); ?>">
					</div>
					<div class="form-group">
						<input type="hidden" name="id_image" value="<?php echo $image; ?>">
						<input type="file" name="new_image_user" class="filestyle" data-buttonText="Change image" data-size="sm" data-iconName="glyphicon glyphicon-user">
					</div>
				</div>	
				<div class="col-md-8 second">
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">Name:</label>
					  <div class="col-sm-8 info_complete_register">
						<p class="form-control-static tablet_2"><?php echo $name; ?></p>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">Last name:</label>
					  <div class="col-sm-8 info_complete_register">
						<p class="form-control-static tablet_2"><?php echo $last_name; ?></p>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">Birthdate:</label>
					  <div class="col-sm-8">
						<input type="date" name="birthdate" class="form-control mobile" data-format="yyyy-mm-dd" placeholder="12/05/1995" autofocus>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">City:</label>
					  <div class="col-sm-8">
						<input type="text" name="city" onkeypress="javascript: return letter()" class="form-control mobile" pattern="[a-z A-Z]*" placeholder="Ej: Morelia" maxlength="20">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">Phone:</label>
					  <div class="col-sm-8">
						<input type="tel" name="phone" onkeypress="javascript: return number()" pattern="[0-9]*" class="form-control mobile" maxlength="10" placeholder="Ej: 4345542134">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register">Nickname:</label>
					  <div class="col-sm-8 info_complete_register">
						<p class="form-control-static tablet_2"><?php echo $nickname; ?></p>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label labels_complete_register email_labels_complete_register">E-mail:</label>
					  <div class="col-sm-8 info_complete_register">
						<p class="form-control-static email_info_complete_register"><?php echo $email; ?></p>
					  </div>
					</div>
				</div>	
					<button class="btn btn-lg btn-primary but_save" type="submit">Save</button>	
					<button type="button" class="btn btn-lg btn-default but_skip" id="skip">Skip</button>		
				</form>
			</div>
			<div class="col-md-3"></div>
        </div>
	</div>
	
	<?php
		$conex->close();
	?>
	
  <script>	
	$(document).ready(function(){	   
	   $("#skip").click(function(evento){
		  evento.preventDefault();		  
		  $('.mfp-close').click();
	   });   	   
	});
  </script>