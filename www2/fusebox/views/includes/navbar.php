<div class="subnavbar">

	<div class="subnavbar-inner">
	
		<div class="container">

			<ul class="mainnav">
			
				<li <?php if(is_active("dashboard")) echo "class='active'"; ?>>
					<a href="<?php echo base_url("dashboard"); ?>">
						<i class="icon-home"></i>
						<span><?php echo lang('base_page_dashboard'); ?></span>
					</a>	    				
				</li>

				<li <?php if(is_active("support")) echo "class='active'"; ?>>					
					<a href="<?php echo base_urL("support"); ?>" class="dropdown-toggle">
						<i class="icon-comment"></i>
						<span><?php echo lang('base_page_support'); ?></span>
					</a>	  				
				</li>
			
			</ul>

			

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->

</div> <!-- /subnavbar -->