<?php
	require_once("appConfig.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:fb="http://ogp.me/ns/fb#" xml:lang="en" lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
	<?php include_once("lib/og_search.php") ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="noindex, nofollow">
	<title>XCRI-CAP Facebook Course Search Demonstrator - Search</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
	<?php include_once("lib/analytics.php") ?>
	<?php $FBcanvasSize = 600; ?>
	<?php include_once("lib/FBjsSDK.php") ?>

    <div class="FBpage_tab">

		<!-- Main Header -->
		<div id="hd_main">
			<h1>Facebook Course Search</h1>
			<h2>XCRI-CAP Demonstrator</h2>
		</div>

		<!-- Main body container -->
		<div id="mn_container">

			<!-- Search parameters form -->
			<form name="search" method="get" action="showcourses.php">
				<br/>
				<input type="hidden" name="size" value="15" />
				<input type="hidden" name="from" value="0" />

				<label for="keyword">Search for:</label>
				<input type="text" name="keyword" id="keyword" maxlength="45" tabindex="1"/>

				<br/>
				<input type="submit" class="FBnavButton" value="Get me some courses..." tabindex="2" onclick="_gaq.push(['_trackEvent', 'Click', 'Search', (document.forms['search']['keyword'].value) ? document.forms['search']['keyword'].value : '*']);" />
			</form>
		</div>
		<div class="search_spacer"></div>

		<?php include_once("lib/pageFooter.php") ?>
	</div>

</body>
</html>
