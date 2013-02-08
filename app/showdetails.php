<?php
	require_once("appConfig.php");

	// Check we've got the minimum parameters required
	$params = array();
	if (count($_GET) > 0) {$params = $_GET;} else {$params = $_POST;}
	if (isset($params["crs_id"]) AND  isset($params["keyword"]) AND isset($params["size"]) AND isset($params["from"])) {
		// Process parameters
		$crs_id = trim($params["crs_id"]);
		$keyword = trim($params["keyword"]);
		$size = (int) trim($params["size"]);
		$from = (int) trim($params["from"]);
	} else {
		// Minimum param(s) are missing, redirect to search.php
		header("Location: search.php");
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:fb="http://ogp.me/ns/fb#" xml:lang="en" lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
	<?php include_once("lib/og_search.php") ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-Equiv="Pragma" content="no-cache" />
	<meta http-Equiv="Expires" content="0" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
	<title>XCRI-CAP Facebook Course Search Demonstrator - Course Details</title>
</head>

<body>
	<?php include_once("lib/analytics.php") ?>
	<?php include_once("lib/FBjsSDK.php") ?>

	<?php
		// Query the aggregator and retrieve the course data
		require_once('lib/ElasticSearch.php');
		$es = ElasticSearch::getES();

		$response = $es->query('course',"_id:$crs_id");

		$hitcount = $response->hits->total;
		$duration = $response->took;

		// Extract the information from the data retrieved (with some defensive coding as structure/content can vary a lot between providers)
		$hit = $response->hits->hits[0];
		if (! empty($hit->_id)) 						{$crs_id			= $hit->_id;}							else {$crs_id = NULL;};
		if (! empty($hit->_source->title)) 				{$crs_title			= $hit->_source->title;}				else {$crs_title = NULL;};
		if (! empty($hit->_source->qual->type)) 		{$qual_type			= $hit->_source->qual->type;}			else {$qual_type = NULL;};
		if (! empty($hit->_source->description)) 		{$crs_desc			= $hit->_source->description;}			else {$crs_desc = NULL;};
		if (! empty($hit->_source->url))				{$crs_url			= $hit->_source->url;}					else {$crs_url = NULL;};
		// Post processing of data items
		if (! empty($qual_type)) 						{$crs_title			= $qual_type." ".$crs_title;};

		// Read Presentation set
		$crs_duration = $crs_applyto = NULL;
		foreach ( $hit->_source->presentations as $presentation ) {
			if (! empty($presentation->duration))			{$crs_duration	= $presentation->duration;}			else {$crs_duration = NULL;};
			if (! empty($presentation->applyTo))			{$crs_applyto	= $presentation->applyTo;}			else {$crs_applyto = NULL;};
		}

		// Read Subjects set
		$crs_subject = NULL;
		foreach ( $hit->_source->subject as $subject ) {
			if (! empty($subject))							{$crs_subject	= $subject;}						else {$crs_subject = NULL;};
		}
	?>

	<div class="FBpage_tab">
		<!-- Main Header -->
		<div id="hd_main">
			<h1>Facebook Course Search</h1>
			<h2>Course Details</h2>
		</div>

		<!-- Main body container -->
		<div id="mn_container">

			<!-- Course title -->
			<div class="course_title"><?php echo "$crs_title"; ?></div>

			<!-- Course fields -->
			<div class="field_block">
				<?php if(! empty($qual_type))	{echo "<div class='field_title'>Award: </div>		<div class='field_data'>$qual_type</div>";} ?>
				<?php if(! empty($crs_duration)){echo "<div class='field_title'>Duration: </div>	<div class='field_data'>$crs_duration</div>";} ?>
				<?php if(! empty($crs_subject)) {echo "<div class='field_title'>UCAS Code: </div>	<div class='field_data'>$crs_subject</div>";} ?>
			</div>

			<!-- Course text -->
			<div class="field_block">
				<div class="text_title">Introduction</div>
				<div class="text_data"><?php echo "$crs_desc"; ?></div>
			</div>

			<!-- Link buttons to Providers site -->
			<div class="field_block align_left">
				<?php if (substr($crs_url,0,4)=="http") {echo "<a class='ProvLinkButton' href='$crs_url' target='more_$crs_id' title='Find out more' onclick=\"_gaq.push(['_trackEvent', 'Click', 'Find out more', '$crs_title']);\">Find out more</a>\n";} ?>
				<?php if (substr($crs_applyto,0,4)=="http") {echo "<a class='ProvLinkButton' href='$crs_applyto' target='apply_$crs_id' title='Apply now' onclick=\"_gaq.push(['_trackEvent', 'Click', 'Apply now', '$crs_title']);\">Apply now</a>\n";} ?>
			</div>

			<!-- App navigation buttons -->
			<div class="field_block">
				<br/>
				<a class="FBnavButton" href="<?php echo 'showcourses.php?'.http_build_query(array('keyword'=>$keyword, 'size'=>$size, 'from'=>$from)); ?>" >Back to results</a>
				<a class="FBnavButton" href="search.php" >Search again</a>
			</div>
		</div>

		<?php include_once("lib/pageFooter.php") ?>
	</div>

</body>
</html>
