<?php
	$title = "Home - Echolakecamp.ca";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d');
	//$username = $_SESSION['username'];
	//$verify = acctverify($username);
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
	?>
</div>
	<div class="content">
		<div>
			<div class="featured">
				<span>
					<img src="slides/img1.JPG" class="mySlides" alt="Bordenball">
					<img src="slides/img2.JPG" class="mySlides" alt="Campfire">
					<img src="slides/img3.JPG" class="mySlides" alt="Laughing">
				</span>
				<script>
					var slideIndex = 0;
					carousel();

					function carousel() {
						var i;
						var x = document.getElementsByClassName("mySlides");
						for (i = 0; i < x.length; i++) {
						  x[i].style.display = "none"; 
						}
						slideIndex++;
						if (slideIndex > x.length) {slideIndex = 1} 
						x[slideIndex-1].style.display = "block";
						setTimeout(carousel, 10000); // Change image every 2 seconds
					} 
				</script>
				<div>
					<div <?php if ( $verify ){echo "style=\"display:none;\"";}?>>
						<h3>LOGIN</h3>
						<p>
							You have to log in before you can register for camp!
						</p>
						<a class="button" href="login.php">Login Now!</a>
						
					</div>
					<div <?php if ( !$verify ){echo "style=\"display:none;\"";}?>>
						<h3>Hi, <?php echo $username; ?>!</h3>
						<?php if ( $isadmin ){echo "<p><a class=\"button\" href=\"admin.php\">Admin Settings</a></p>";} ?>
						<?php if ( !$isadmin ){echo "<p><a class=\"button\" href=\"register.php\">Register for camp</a></p>";} ?>
						<p><a class="button" href="profile.php">Edit your profile</a></p>
						<p><a class="button" href="logout.php">Logout</a></p>
											
					</div>
				</div>
			</div>
			<div>
				<div>
					<div>
						<div class="section">
							<h2>Echo Lake Camp.</h2>
							<p>
								This website template has been designed by <a href="http://www.freewebsitetemplates.com/">Free Website Templates</a> for you, for free. You can replace all this text with your own text.
							</p>
							<ul>
								<li>
									<p>
										Vivamus at justo ut urna porta pulvinar
									</p>
								</li>
								<li>
									<p>
										Pellentesque nunasidp adipiscing sollicitudin dolor id sagittis.
									</p>
								</li>
								<li>
									<p>
										Donec sit amet felis a nibh ornare malesuada.
									</p>
								</li>
								<li>
									<p>
										Etiam et tellus mi, et semper lectus.
									</p>
								</li>
							</ul>
							<ul class="last">
								<li>
									<p>
										Quisque in purus nec purus feugiat consectetur.
									</p>
								</li>
								<li>
									<p>
										Fusce et ipsum dolor lorem ante, at sollicitudin libero.
									</p>
								</li>
								<li>
									<p>
										Etiam et tellus mi, et semper lectus.
									</p>
								</li>
								<li>
									<p>
										Vivamus at justo ut urna porta pulvinar.
									</p>
								</li>
							</ul>
						</div>
						<!--<div>
							<h3>UPCOMING EVENTS</h3>
							<ul>
								<li>
									<div>
										11/10/2011
										<p>
											This is just a place holder, so you can see what the site would look like.
										</p>
									</div>
								</li>
								<li>
									<div>
										11/19/2011
										<p>
											Praesent quis nisl in velit imper diet suscipit a id quam.
										</p>
									</div>
								</li>
								<li class="last">
									<div>
										11/19/2011
										<p>
											Nullam vulputate elementum consequat. Fusce leo felis, bibendum.
										</p>
									</div>
								</li>
							</ul>
							<a class="button buttonwide button-top" href="events.php">View All</a>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>