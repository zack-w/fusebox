<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<ul class="mainnav">
				
				<?php
					foreach( $this->nav->Locations as $PageID => $Page )
					{
						if( $this->nav->Accessible( $PageID ) )
						{
							$Class = (is_active($Page["PageID"]))?("active"):("");
							$Text = lang("base_page_" . $Page["PageID"]);
							
							if( $Page[ "NoPrefix" ] == true )
								$Prefix = "";
							else
								$Prefix = ( $this->ion_auth->is_staff() )?( "admin/" ):( "users/" );
							
							echo "
								<li class='{$Class}'>
									<a href='" . base_url( $Prefix . $Page["PageID"] ) . "' class='dropdown-toggle'>
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