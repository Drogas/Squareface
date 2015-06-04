<script src="../js/bootstrap-filestyle.min.js"> </script>

<?php  		
	//connection
	include("../include/functions.php");
	$conex = connection();
	
	//session start
	session_start();
	
	//id of place
	$id_place = $_GET["id_place"];
	
	//select all from the table 'place' whit the id
	$query = "SELECT * FROM place WHERE id='$id_place'";
	$result = $conex->query($query);
	$row = $result->fetch_assoc();
		$place_id = $row['id'];
		$place_name = $row['name'];
		$place_address = $row['address'];
		$place_city = $row['city'];
		$place_phone = $row['phone'];
		$place_schedule = $row['schedule'];
		$place_rating = $row['rating'];
		
		$place_id_cat = $row['category_id'];
		$place_tags = $row['tags_id'];
		$place_image = $row['image'];
		//select category's name
		$query_category = "SELECT name FROM category WHERE id='$place_id_cat'";
		$result_category = $conex->query($query_category);
		$row_category = $result_category->fetch_assoc();
			$category_name = $row_category['name'];
		//select image of place
		$select_image = "SELECT * FROM image WHERE id='$place_image'";
		$result_image = $conex->query($select_image);
		$row_image = $result_image->fetch_assoc();
		  $ext = $row_image['img_type'];
		  $image_type = $row_image['type'];	
		  $filename = "../photos/place/$image_type/$place_image$ext";			
			if (file_exists($filename)) {
				$filename = $filename;
			} 
			else {
				$filename = "../photos/place/$image_type/default.png";
			}		
	?>

<div class="container">
	<div class="col-md-12">
		<div class="col-md-1"></div>
		<div class="col-md-10" id="popup_place_container">
			<h4 class="popup_place_title">Place Info</h4>
			<!--categories botons-->
			<div id="owl_buttons_place" class="btn-group btn-group-justified owl-carousel popup_place_content_botons" role="group" aria-label="...">
			    <div class="btn-group" role="group">
					<a class="btn btn-primary owl-item active popup_place_botons" id="button_place" href="#" role="button">Place</a>
			    </div>			
			    <div class="btn-group" role="group">
					<a class="btn btn-primary owl-item popup_place_botons" id="button_comments" href="#" role="button">Comments</a>
			  	</div>
			  	<div class="btn-group" role="group">
					<a class="btn btn-primary owl-item popup_place_botons" id="button_gallery" href="#" role="button">Gallery</a>
			 	</div>
			  	<div class="btn-group" role="group">
					<a class="btn btn-primary owl-item popup_place_botons" id="button_promotions" href="#" role="button">Promotions</a>
			    </div>
			</div>
			</br>			
			<!--content place's buttons------------------------------------>
			<div class="popup_place_content_info">
				<!--title of place----------------------------------------->
				<div class="name_rating">
					<h4 class="popup_place_name_place"><?php echo $category_name." ".$place_name;?></h4></br>
					<h5 class='popup_place_place_raiting'>
					  <?php
						$cont = 0;
						for($cont; $cont<$place_rating; $cont ++){
							if($cont==0){
								echo"<span class='glyphicon glyphicon-star place_rating_color' aria-hidden='true'></span>";
							}
							if($cont==1){
								echo"<span class='glyphicon glyphicon-star place_rating_color' aria-hidden='true'></span>";
							}
							if($cont==2){
								echo"<span class='glyphicon glyphicon-star place_rating_color' aria-hidden='true'></span>";
							}
							if($cont==3){
								echo"<span class='glyphicon glyphicon-star place_rating_color' aria-hidden='true'></span>";
							}
							if($cont==4){
								echo"<span class='glyphicon glyphicon-star place_rating_color' aria-hidden='true'></span>";
							}
						}
						for($cont; $cont<5; $cont ++){
							echo"<span class='glyphicon glyphicon-star rating_popup_default' aria-hidden='true'></span>";
						}						
					  ?>
					</h5> </br>
				</div>	
				<!--button place----------------------------------------------------------->
				<div class="button_place" id="ajax_button_place">
					<div class="col-md-3 button_place_info">
						<h4 class="button_place_title_info">Place information</h4> </br>
						<p class="button_place_info_details">				  	
						  <strong>Address: </strong><?php echo $place_address;?></br>
						  <strong>City: </strong><?php echo $place_city;?></br>
						  <strong>Phone: </strong><?php echo $place_phone;?></br>
						  <strong>Shedule: </strong><?php echo $place_schedule;?></br>
						</p>
					</div>
					<div class="col-md-6 button_place_image">
						<img class="button_place_image_details" src="<?php echo $filename; ?>">
					</div>
					<div class="col-md-3 button_place_tags">
						<h4 class="button_place_title_tags">Tags</h4></br>
						<p class="button_place_tags_details">				  	  
						  <?php
							  //tags
							  $place_tags;	
							  $tag_list = explode(",", $place_tags);
							  $tag_ids = array();					  
							  foreach($tag_list as $tag){
								  $tag_ids[] = trim($tag, "|");
							  }		  					  
							  $select_tags = "SELECT name FROM tags WHERE id in (".implode(",", $tag_ids).") OR category_id = 0 limit 10";
							  $result_tags = $conex->query($select_tags);	
						   
							  $cont = 0;
							  while ($row_tags = $result_tags->fetch_assoc()){
								$cont ++;
								if ($cont == 10){
									$tags_name = $row_tags['name'];
									echo $tags_name.".";
								}
								else{
									$tags_name = $row_tags['name'];
									echo $tags_name.", ";
								}						    
							  }
						  ?>	
						</p>
					</div>
				</div>	
				<!--button coments------------------------------------------------------->
				<div class="button_comments" id="ajax_button_comments">
					<!--show comments-------->
					<p class="button_comments_title_comms"><strong>Comments</strong></p>
					<div class="col-md-6 scroll_comments_y">						
					<?php	
						$select_comments = "SELECT * FROM comment WHERE place_id = '$place_id' ORDER BY id DESC limit 7";
						$result_comments = $conex->query($select_comments);
						if ($result_comments->num_rows > 0) {
							while ($comment_row = $result_comments->fetch_assoc()){
								$com_comment = $comment_row['comment'];
								$com_date = $comment_row['date'];
								$com_image = $comment_row['image'];
								$com_place_id = $comment_row['place_id'];
								$com_user_id = $comment_row['user_id'];
								
								//select image---------comment--------
								$sel_comm_img = "SELECT * FROM image WHERE id='$com_image'";
								$res_comm_img = $conex->query($sel_comm_img);
								$row_comm_img = $res_comm_img->fetch_assoc();
								
								$c_ext = $row_comm_img['img_type'];
								$c_image_type = $row_comm_img['type'];	
								$c_filename = "../photos/$c_image_type/$com_image$c_ext";
											
								if (file_exists($c_filename)) {
									$c_filename = $c_filename;
								} 
								else {
									$c_filename = "../photos/$c_image_type/default.png";
								}	
								
								//select image---------user--------
								$sel_user_img = "SELECT * FROM image WHERE type='user' AND papa_id='$com_user_id'";
								$res_user_img = $conex->query($sel_user_img);
								$row_user_img = $res_user_img->fetch_assoc();
								
								$u_id = $row_user_img['id'];
								$u_ext = $row_user_img['img_type'];
								$u_image_type = $row_user_img['type'];	
								$u_filename = "../photos/$u_image_type/$u_id$u_ext";
											
								if (file_exists($u_filename)) {
									$u_filename = $u_filename;
								} 
								else {
									$u_filename = "../photos/$u_image_type/default.png";
								}	
								
								//select user nickname			
								$sel_user_nickname = "SELECT nickname FROM user WHERE id='$com_user_id'";
								$res_user_nickname = $conex->query($sel_user_nickname);
								$row_user_nickname = $res_user_nickname->fetch_assoc();								
									$user_nickname = $row_user_nickname['nickname'];
									
							}
					?>								
							<!--Show information -->
							<div class="col-md-12 container_one_comment">	
								<div class="col-md-3 cont_one_user">		
									<img class="comment_user_image" src="<?php echo $u_filename; ?>"></br>
									<p class="comment_user_nickname"><?php echo $user_nickname;?></p>
								</div>
								<div class="col-md-6 cont_one_comment">	
									<p class="comment_comment_date"><?php echo $com_date;?></p>
									<p class="comment_comment_details"><?php echo $com_comment;?></p>
								</div>
								<div class="col-md-3 cont_one_comment_image">	
									<img class="comment_comment_image" src="<?php echo $c_filename; ?>">
								</div>
							</div>		
							<div class="col-md-12 container_one_comment">	
								<div class="col-md-3 cont_one_user">		
									<img class="comment_user_image" src="<?php echo $u_filename; ?>"></br>
									<p class="comment_user_nickname"><?php echo $user_nickname;?></p>
								</div>
								<div class="col-md-6 cont_one_comment">	
									<p class="comment_comment_date"><?php echo $com_date;?></p>
									<p class="comment_comment_details"><?php echo $com_comment;?></p>
								</div>
								<div class="col-md-3 cont_one_comment_image">	
									<img class="comment_comment_image" src="<?php echo $c_filename; ?>">
								</div>
							</div>	
							<div class="col-md-12 container_one_comment">	
								<div class="col-md-3 cont_one_user">		
									<img class="comment_user_image" src="<?php echo $u_filename; ?>"></br>
									<p class="comment_user_nickname"><?php echo $user_nickname;?></p>
								</div>
								<div class="col-md-6 cont_one_comment">	
									<p class="comment_comment_date"><?php echo $com_date;?></p>
									<p class="comment_comment_details"><?php echo $com_comment;?></p>
								</div>
								<div class="col-md-3 cont_one_comment_image">	
									<img class="comment_comment_image" src="<?php echo $c_filename; ?>">
								</div>
							</div>	
							<div class="col-md-12 container_one_comment">	
								<div class="col-md-3 cont_one_user">		
									<img class="comment_user_image" src="<?php echo $u_filename; ?>"></br>
									<p class="comment_user_nickname"><?php echo $user_nickname;?></p>
								</div>
								<div class="col-md-6 cont_one_comment">	
									<p class="comment_comment_date"><?php echo $com_date;?></p>
									<p class="comment_comment_details"><?php echo $com_comment;?></p>
								</div>
								<div class="col-md-3 cont_one_comment_image">	
									<img class="comment_comment_image" src="<?php echo $c_filename; ?>">
								</div>
							</div>	
							<div class="col-md-12 container_one_comment">	
								<div class="col-md-3 cont_one_user">		
									<img class="comment_user_image" src="<?php echo $u_filename; ?>"></br>
									<p class="comment_user_nickname"><?php echo $user_nickname;?></p>
								</div>
								<div class="col-md-6 cont_one_comment">	
									<p class="comment_comment_date"><?php echo $com_date;?></p>
									<p class="comment_comment_details"><?php echo $com_comment;?></p>
								</div>
								<div class="col-md-3 cont_one_comment_image">	
									<img class="comment_comment_image" src="<?php echo $c_filename; ?>">
								</div>
							</div>							
					<?php												
						} 
						else {
							echo "<p class='no_comments'>This place has not comments</p>";
						}		 
					?>
					</div>
					<!--add comment-------->
					<p class="button_comments_title_addcomms"><strong>Add Comment</strong></p>
					<div class="col-md-6">
						<?php
							//select user whit open session
							$select_sesion = "SELECT nickname, image FROM user WHERE id = '$_SESSION[id]'";
							$result_sesion = $conex->query($select_sesion);
							$sesion_row = $result_sesion->fetch_assoc();							
								$sesion_nickname = $sesion_row['nickname'];
								$sesion_image = $sesion_row['image'];
							
							//select image user whit open sesion
							$sel_sesion_img = "SELECT * FROM image WHERE type='user' AND papa_id='$_SESSION[id]'";
							$res_sesion_img = $conex->query($sel_sesion_img);
							$row_sesion_img = $res_sesion_img->fetch_assoc();
							
							$sesion_id = $row_sesion_img['id'];
							$sesion_ext = $row_sesion_img['img_type'];
							$sesion_image_type = $row_sesion_img['type'];	
							$sesion_filename = "../photos/$sesion_image_type/$sesion_id$sesion_ext";
										
							if (file_exists($sesion_filename)) {
								$sesion_filename = $sesion_filename;
							} 
							else {
								$sesion_filename = "../photos/$sesion_image_type/default.png";
							}
						?>
					    <div class="col-md-12 container_add_comment">	
							<div class="col-md-3 cont_add_user">		
								<img class="add_user_image" src="<?php echo $sesion_filename; ?>"></br>
								<p class="add_user_nickname"><?php echo $sesion_nickname;?></p>
							</div>
							<div class="col-md-9 cont_add_comment">	
								<form>
								  <div class="form-group">
									<label>Comment</label>
									<textarea class="form-control tam_textarea" rows="5" maxlength="150" placeholder="Write a comment" autofocus required></textarea>
								  </div>								 
								  <div class="form-group">
									<label for="exampleInputFile">Choose an image for the comment</label>
									<input type="file" class="filestyle" data-buttonText="Choose image" data-size="sm" data-iconName="glyphicon glyphicon-picture">
								  </div>								  
								  <button type="submit" class="btn btn-primary tam_but_ok">Ok</button>
								</form>
							</div>
						</div>	
					</div>
				</div>
				<!--button gallery-------------------------------------------------------->
				<div class="button_gallery" id="ajax_button_gallery">
					galerias
				</div>
				<!--button promotions----------------------------------------------------->
				<div class="button_promotions" id="ajax_button_promotions">
					<?php	
						$select_promotion = "SELECT * FROM promotion WHERE place_id = '$place_id' limit 10";
						$result_promotion = $conex->query($select_promotion);
						if ($result_promotion->num_rows > 0) {
						
						//create carrucel for promos
						echo "<div id='button_promotions_promos' class='owl-carousel'>";
						
							//select info of promos
							while ($promo_row = $result_promotion->fetch_assoc()){
								$promo_day = $promo_row['day'];
						        $promo_promotion = $promo_row['promotion'];
							    $promo_image = $promo_row['image'];
								
								//select day name
								$day_name;
								  if ($promo_day == 1){
									$day_name="Sunday";
								  }
								  if ($promo_day == 2){
									$day_name="Monday";
								  }
								  if ($promo_day == 3){
									$day_name="Tuesday";
								  }
								  if ($promo_day == 4){
									$day_name="Wednesday";
								  }
								  if ($promo_day == 5){
									$day_name="Thursday";
								  }
								  if ($promo_day == 6){
									$day_name="Friday";
								  }
								  if ($promo_day == 7){
									$day_name="Saturday";
								  }	  
								
								//select image on promos
								$pro_select_image = "SELECT * FROM image WHERE id='$promo_image'";
								$pro_result_image = $conex->query($pro_select_image);
								$pro_row_image = $pro_result_image->fetch_assoc();
								
								$pro_ext = $pro_row_image['img_type'];
								$pro_image_type = $pro_row_image['type'];	
								$pro_filename = "../photos/$pro_image_type/$promo_image$pro_ext";		
								
								if (file_exists($pro_filename)) {
									$pro_filename = $pro_filename;
								} 
								else {
									$pro_filename = "../photos/$pro_image_type/default.jpg";
								}	
					?>			
								<!--Show information -->
								<div>
									<div class="col-md-2"></div>
									<div class="col-md-5">								
										<img class="button_promotions_image_details" src="<?php echo $pro_filename;?>" title="<?php echo $promo_promotion;?>">
									</div>
									<div class="col-md-4 button_promotions_promo_details">
										<h4 class="button_promotions_title_details">Promotion</h4></br>
										<p class="button_promotions_info_details">	
										  <strong>Date: </strong>Every <?php echo $day_name;?></br>		  	  
										  <strong>Promo: </strong><?php echo $promo_promotion;?></br>
										</p></br>
									</div>	
									<div class="col-md-1"></div>
								</div>
					<?php			
							}
						echo "</div>";									
						} 
						else {
							echo "<p class='no_promos'>This place has not promotions</p>";
						}	 
					?>
				</div>
				<!--end button promotions----------------------------------------------------->
			</div>
			<!--options_place----------------------------------------------------->
			<div class="popup_place_options_place">
				<a class="btn btn-primary popup_place_option_check" href="#" role="button">Check in</a></br>
				<a class="btn btn-primary popup_place_option_take" href="#" onClick="calcRoute(<?php echo $place_id;?>)" role="button">Take me here</a></br>
				<a class="btn btn-primary popup_place_option_rating" href="#" role="button">Rate</a></br>
			</div>	
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
<?php
	$conex->close();
?>	

<script>
	//carrucel_buttons
	var owl_but_place = $("#owl_buttons_place");	 
	owl_but_place.owlCarousel({		 
	  itemsCustom : [
		[0, 2],
		[450, 2],
		[527, 3],
		[650, 4]
	  ],
	  navigation : true	 
	});
	
	//carrucel_promos
	var owl_pro_place = $("#button_promotions_promos");	 
	owl_pro_place.owlCarousel({		 
	  itemsCustom : [
		[0, 1],
		[450, 1],
		[527, 1],
		[650, 1]
	  ],
	  navigation : true	 
	});		
	
	$(document).ready(function(){
	  //buttons of place	
	   $("#ajax_button_place").show();
	   $("#ajax_button_comments").hide();
	   $("#ajax_button_gallery").hide();
	   $("#ajax_button_promotions").hide();
	   
	   $("#button_place").click(function(evento){
		  evento.preventDefault();		  
		  $("#ajax_button_place").show();
	   	  $("#ajax_button_comments").hide();
	      $("#ajax_button_gallery").hide();
	      $("#ajax_button_promotions").hide();
	   });
	   
	   $("#button_comments").click(function(evento){
		  evento.preventDefault();		  
		  $("#ajax_button_place").hide();
	   	  $("#ajax_button_comments").show();
	      $("#ajax_button_gallery").hide();
	      $("#ajax_button_promotions").hide();
	   });
	   
	   $("#button_gallery").click(function(evento){
		  evento.preventDefault();		  
		  $("#ajax_button_place").hide();
	   	  $("#ajax_button_comments").hide();
	      $("#ajax_button_gallery").show();
	      $("#ajax_button_promotions").hide();
	   });
			
	   $("#button_promotions").click(function(evento){
		  evento.preventDefault();		  
		  $("#ajax_button_place").hide();
	   	  $("#ajax_button_comments").hide();
	      $("#ajax_button_gallery").hide();
	      $("#ajax_button_promotions").show();
	   });
	   
	   /*close de magnific popup*/ 
	   $(".popup_place_option_take").click(function(evento){
		  evento.preventDefault();		  
		  $('.mfp-close').click();
	   }); 
	   
	   /*scrollbar*/
	   $('.scroll_comments_y').perfectScrollbar();  
	});
</script>