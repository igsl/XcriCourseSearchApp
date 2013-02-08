<?php
	require_once("appConfig.php");

	// Construct channelUrl
	$FBchannel = $FBprotocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$FBchannel .= (substr($FBchannel, -1)!='/' ? '/' : '') . 'lib/channel.php';
?><div id="fb-root"></div>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '<?php echo $FBappID; ?>',
				cookie     : true,
				logging    : false,
				status     : true,
				xfbml      : true,
				channelUrl : '<?php echo $FBchannel; ?>',
				frictionlessRequests : true
				});
		};

		(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));

		// Auto-size iframe and start at top of page
		window.onload = function() {
			FB.Canvas.scrollTo(0,0);
			FB.Canvas.setSize(<?php echo (isset($FBcanvasSize) ? "{height:$FBcanvasSize}" : "") ?>);
		};
	</script>
