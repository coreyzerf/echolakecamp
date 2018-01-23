<?php
	$title = "Staff - Echolakecamp.ca";
	require('header.php');
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div>
			<div>
				<div>
					<div class="staff">
						<h2>SUMMER CAMP STAFF</h2>
						<div class="first">
							<h3>Staff Login</h3>
							<form action="index.php">
								<input type="text" value="Username" onblur="this.value=!this.value?'Username':this.value;" onfocus="this.select()" onclick="this.value='';">
								<input type="password" value="">
								<a href="#">Forgot your password?</a>
								<button type="submit">Login</button>
							</form>
						</div>
						<div>
							<h3>This is just a place holder</h3>
							<p>
								Donec vel arcu ante, accumsan imperdiet eros. Sed varius justo eget arcu ornare commodo. Nulla urna odio, elementum id pretium quis, viverra non nibh. Suspendisse egestas placerat felis in adipiscing. Mauris nisl risus, rhoncus non ultricies a, bibendum eget erat.
							</p>
							<h3>This is just a place holder</h3>
							<ul>
								<li>
									<p>
										Donec vitae ligula a mi condimentum fermentum. Duis pulvinar leo in est sodales ac malesuada neque dapibus.
									</p>
								</li>
								<li>
									<p>
										Morbi commodo sem imperdiet magna imperdiet auctor. Vestibulum tempus.
									</p>
								</li>
								<li>
									<p>
										Duis nibh lacus malesuada in dignissim ac aliquam eu ipsum. Maecenas libero nulla consectetur.
									</p>
								</li>
							</ul>
							<h3>This is just a place holder</h3>
							<p>
								Nullam sodales convallis sollicitudin. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris rhoncus laoreet lectus, ac porttitor ligula faucibus sed. Aliquam consequat massa a lectus euismod eu accumsan quam semper.
							</p>
							<p>
								Cras congue ante nec orci volutpat non aliquet nisl interdum. Integer gravida, felis eget posuere pellentesque, ligula libero porta lacus, nec ultrices arcu lectus et metus. Aenean quis tortor neque, in accumsan erat. Aliquam diam massa dignissim a ultricies sagittis.
							</p>
							<a href="application.php">Apply Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>