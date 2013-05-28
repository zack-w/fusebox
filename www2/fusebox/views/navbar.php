<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<ul class="mainnav">
				
				<?php
					foreach( $this->nav->Locations as $PageID => $Page )
					{
						if( $this->nav->Accessible( $PageID ) )
						{
							$Text = lang("base_page_" . $Page["PageID"]);
							
							if( $Page[ "NoPrefix" ] == true )
								$Prefix = "";
							else
								$Prefix = ( $this->ion_auth->is_staff() )?( "admin/" ):( "users/" );
							
							if( $Page[ "SubElements" ] != 0 )
							{
								$Class = "";
							
								foreach( $Page[ "SubElements" ] as $Element ) {
									if( is_active( $Element[1] ) ) {
										$Class = "active";
										break;
									}
								}
								
								echo "
									<li class='dropdown {$Class}'>
										<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
											<i class='" . $Page["Icon"] . "'></i>
											<span>{$Text}</span>
											<b class='caret'></b>
										</a>
										
										<ul class='dropdown-menu'>
								";
								
								foreach( $Page[ "SubElements" ] as $Element ) {
									$ElementText = lang("base_page_" . $Page["PageID"] . "_" . $Element[0]);
									echo "<li><a href='" . base_url( $Prefix . $Element[1] ) . "'>{$ElementText}</a></li>";
								}
								
								echo "</ul></li>";
							}else{
								$Class = (is_active($Page["PageID"]))?("active"):("");
								
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
					}
				?>
				
			</ul>
		</div> <!-- /container -->
	</div> <!-- /subnavbar-inner -->
</div> <!-- /subnavbar -->