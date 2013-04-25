<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<ul class="mainnav">
			
				<?php
					foreach( $this->nav->Locations as $Page )
					{
						if( $Page["AdminOnly"] == false || $admin )
						{
							$Class = (is_active($Page["PageID"]))?("active"):("");
							$Text = lang("base_page_" . $Page["PageID"]);
							
							echo "
								<li class='{$Class}'>
									<a href='" . base_url($Page["PageID"]) . "' class='dropdown-toggle'>
										<i class='" . $Page["Icon"] . "'></i>
										<span>{$Text}</span>
									</a>
								</li>
							";
						}
					}
				?>
			
			</ul>
		</div> <!-- /container -->
	</div> <!-- /subnavbar-inner -->
</div> <!-- /subnavbar -->