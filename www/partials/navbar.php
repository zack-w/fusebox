<div class="subnavbar">

	<div class="subnavbar-inner">
	
		<div class="container">

			<ul class="mainnav">
			
				<li <?php if(empty($request['args'][2]) || $request['args'][2] == "dashboard") echo "class='active'"; ?>>
					<a href="<?php echo $BASEURL; ?>">
						<i class="icon-home"></i>
						<span><?php echo $LANGUAGE['page_dashboard']; ?></span>
					</a>	    				
				</li>

				<li <?php if($request['args'][2] == "support") echo "class='active'"; ?>>					
					<a href="<?php echo $BASEURL; ?>support/" class="dropdown-toggle">
						<i class="icon-comment"></i>
						<span><?php echo $LANGUAGE['page_support']; ?></span>
					</a>	  				
				</li>
			
			</ul>

			

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->

</div> <!-- /subnavbar -->