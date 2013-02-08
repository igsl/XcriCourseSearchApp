<?php
	require_once("appConfig.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta property="fb:app_id" content="<?php echo $FBappID; ?>" />
    <link rel="stylesheet" type="text/css" href="css/main.css" >
	<title>XCRI-CAP Facebook Course Search Demonstrator - Install app</title>
</head>

<body>
	<?php include_once("lib/analytics.php") ?>
	<?php $FBcanvasSize = 600; ?>
	<?php include_once("lib/FBjsSDK.php") ?>

    <div class="FBcanvas">

		<!-- Main Header -->
		<div id="hd_main">
			<h1>Facebook Course Search</h1>
			<h2>Install app on Facebook page</h2>
		</div>

		<!-- Main body container -->
		<div id="mn_container">

			<!-- Action button -->

			<a class="FBnavButton" onclick='installApp(); return false;'>Install app</a>

			<script type="text/javascript">
				function installApp() {
					FB.login(function(response) {
						if (response.authResponse) {
							FB.api('/me');
							FB.ui({
								method: 'pagetab',
								redirect_uri: 'http://www.facebook.com',
							});
						}
					});
				};
			</script>
		</div>

		<!-- Page Footer -->
		<div id="ft_sub_footer" class="float_container">
			<div class="float_left"></div>
			<div class="float_right">&copy; 2013 InGenius Solutions Ltd</div>
		</div>
	</div>

</body>
</html>
