		
		<div class="container">
			<div class="span12">
				<img src="cogs/img/slogan.png" />
			</div>
		</div>
		
		<div style="height: 5px;"></div>
		
		<div class="container">
			<div class="span12" style="padding: 0; margin: 0; background: url(cogs/img/header.png); height: 285px; background-repeat: no-repeat; background-position: center center;">
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="span12" style="text-align:center">
						<a class="btn btn-primary btn-large" href="<? echo $APIURL; ?>download.php">
							Download for <b>Windows</b>
						</a>
						<a class="btn btn-default btn-large" href="<? echo $APIURL; ?>download.php?os=Mac">
							Download for <b>Mac OSX</b>
						</a>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<? echo $BASEURL; ?>cogs/jwplayer/jwplayer.js"></script>
		
		<div class="container">
			<div class="row">
				<div class="span12" style="background-image: url(cogs/img/bolt.png); background-repeat: no-repeat; height: 265px;">
					<div style="position: relative; top: 60px; left: 200px;">
						<span class="infoheader">Instant Screenshots. Instant Sharing.</span>
						<div class="infoblock">
							Say goodbye to the print-screen button! Take screenshots (or as we like to call them 'stors') of your desktop in two clicks. We do the rest of the work for you. Forget copying and pasting images from your clipboard, fighting with image uploading sites, and over-complicated FTP setups. 4stor is here to make your life simple, and we do just that.
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container" style="margin-top: 15px; margin-bottom: 15px;">
			<div class="row">
				<div class="span12">
					<span class="infoheader" style="color: #3e66d7; position: relative; top: 35px; left: 147px;">See what 4STOR can do, in a minute-thirty.</span>
					<div class="" style="width:870px; height: 488px; padding-left: 35px; padding-top: 45px;">
						<div id="flashcontent" style=" box-shadow: 0px 0px 10px #000; width:870px; height: 488px;"></div>
						<script type="text/javascript" src="<? echo $BASEURL; ?>cogs/video/swfobject.js"></script>
						<script type="text/javascript">
							var so = new SWFObject("<? echo $BASEURL; ?>cogs/video/videoplayer.swf", "mymovie", "869", "489", "9","#333333");
							so.addParam("menu", "false");
							so.addParam("allowfullscreen", "false");
							so.addParam("wmode", "transparent");
							so.addParam("allowScriptAccess", "always");
					
							

							so.addVariable("setting", "0");
							so.addVariable("xmlPath", "<? echo $BASEURL; ?>cogs/video/settings.xml");
							so.addVariable("videoWidth","870");
							so.addVariable("videoHeight","489");

							so.addVariable("videoPath","https://s3.amazonaws.com/4stor-media/4stor_promo1.mp4");  // It goes here ricky just the youtube hash code!

							so.addVariable("imagePath","/cogs/img/popup.png");
						
							so.addVariable("playerNavigations","ply,sek,vol,ful,hdv,txt");
							
							so.addVariable("videoAutoStart","no");
							
							so.addVariable("reflection","yes");
						
							so.addVariable("titleVerticalSpace","10");
							so.addVariable("videoTitle", "");
							
							so.addVariable("videoDescription","");
							so.write("flashcontent");
						</script>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="span12" style="background-image: url(cogs/img/gallery.png); background-position: right; background-repeat: no-repeat; height: 300px;">
					<div style="position: relative; top: 35px; right: 300px;">
						<span class="infoheader" style="color: #ecac17; float: right;">Your own online gallery. To keep.</span>
						<br class="clearfix" />
						<div class="infoblock" style="text-align: left; float: right; width: 45%;">
							Keep your stors locked away in your own private gallery. Access your gallery from anywhere online with a simple login. Stors can be starred, renamed, edited online, downloaded, and even manually deleted right from the gallery. Every stor on the network is saved forever, we won't ever delete your content unless you want to! It gets better - your gallery will keep every stor you've taken since your first click-and-drag. Your gallery is yours to keep.
						</div>
					</div>
				</div>
			</div>
		</div>		
		
		<div class="container">
			<div class="row">
				<div class="span12" style="background-image: url(cogs/img/world.png); background-repeat: no-repeat; height: 290px;">
					<div style="position: relative; top: 20px; left: 280px;">
						<span class="infoheader" style="color: #d92939;">Your stors. They're worldwide.</span>
						<div class="infoblock">
							After the release of your mouse, your stor is instantly uploaded to our network for instant viewing and sharing. Milliseconds later its pushed out to our world-wide delivery network. Your stor is always accessible, and always ready to be viewed from anywhere in the world at lightning fast speeds. We're not joking when we say 4stor is instant sharing.
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--
		<div class="container" style="margin-top: 35px;">
			<div class="row def_block">
				<div>
					<span class="def_word">4·stor</span> <span class="def_key">[four-store]</span>
				</div>
				<div class="def_body">
					<div class="def_speech">noun</div>
					
					<div class="def_def">The application that provides the fastest and easiest screenshots to share with anyone.</div>
					
					<div class="def_speech">verb</div>
					<div class="def_def">To take a screenshot using 4stor.</div>
					
				</div>
				
				<div>
					<span class="def_word">stor</span> <span class="def_key">[<b>store</b>]</span>
				</div>
				
				<div class="def_body">
					<div class="def_speech">noun</div>
					
					<div class="def_def">A screenshot taken with 4stor</div>
				</div>
			</div>
			!-->
		</div>		
		
	
