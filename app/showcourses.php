<?php
	require_once("appConfig.php");

	// Check we've got the minimum parameters required
	$params = array();
	if (count($_GET) > 0) {$params = $_GET;} else {$params = $_POST;}
	if (isset($params["keyword"]) AND isset($params["size"]) AND isset($params["from"])) {
		// Process parameters
		$keyword = trim($params["keyword"]);
		$size = (int) trim($params["size"]);
		$from = (int) trim($params["from"]);
		if (empty($keyword)) $keyword='*';
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
	<title>XCRI-CAP Facebook Course Search Demonstrator - Search Results</title>
</head>

<body>
	<?php include_once("lib/analytics.php") ?>
	<?php include_once("lib/FBjsSDK.php") ?>

    <div class="FBpage_tab">

		<!-- Main Header -->
		<div id="hd_main">
			<h1>Facebook Course Search</h1>
			<h2>Search Results</h2>
		</div>

		<!-- Main body container -->
		<div id="mn_container">

			<?php
				// Query the aggregator and retrieve the course data
				require_once('lib/ElasticSearch.php');
				$es = ElasticSearch::getES();

				// recstats:public = Double check we only publish courses that are public info
				$response = $es->query('course',"provid:".$AppProvID." AND recstatus:public AND title:$keyword", $size, $from);

				$hitcount = $response->hits->total;
				$duration = $response->took;
				$hits = $response->hits->hits;

				echo "<p>You searched for: $keyword</p>\n";
				echo "<p>Found: $hitcount matches.</p>\n";
			?>

			<!-- Pseudo-table column headings -->
			<div class="hd_tab_header">
				<div class="hd_tab_header_col tab_col_300"><h3>Course Title</h3></div>
				<div class="hd_tab_header_col tab_col_500"><h3>Description</h3></div>
			</div>

			<table>
				<!-- Fix column widths -->
				<tr class="tab_row_hidden">
					<th class="tab_col_300"></th>
					<th class="tab_col_500"></th>
				</tr>

				<?php
				// Extract the information from the data retrieved (with some defensive coding as structure/content can vary a lot between providers)
				foreach ( $hits as $hit ) {
					if (! empty($hit->_id)) 				{$crs_id	= $hit->_id;}					else {$crs_id = NULL;};
					if (! empty($hit->_source->title)) 		{$crs_title	= $hit->_source->title;}		else {$crs_title = NULL;};
					if (! empty($hit->_source->qual->type))	{$qual_type	= $hit->_source->qual->type;}	else {$qual_type = NULL;};
					if (! empty($hit->_source->description)){$crs_desc	= $hit->_source->description;}	else {$crs_desc = NULL;};
					if (! empty($hit->_source->url))		{$crs_url	= $hit->_source->url;}			else {$crs_url = NULL;};
					// Post processing of data items
					if (! empty($qual_type)) 				{$crs_title		= $qual_type." ".$crs_title;};

					// link to details page in app
					$html ="<tr title='Click to see more details' onclick=\"_gaq.push(['_trackEvent', 'Click', 'View Course', '$crs_title']);window.open('showdetails.php?";
					$html.=http_build_query(array('crs_id'=>$crs_id, 'keyword'=>$keyword, 'size'=>$size, 'from'=>$from));
					$html.="','_self');\">";
					// show table data
					$html .= "<td>".$crs_title."</td>";
					$html .= "<td>".$crs_desc ."</td>";
					echo $html . "</tr>\n";
				}
				?>
			</table>

			<!-- Table footer and Record Set Page Navigation buttons -->
			<div class="hd_tab_footer float_container">
				<div class="float_left">
				</div>

				<div class="float_right">
					<form method="get" action="showcourses.php">
						<input type="hidden" name="keyword" value='<?php echo "$keyword"; ?>' />
						<input type="hidden" name="size" value='<?php echo "$size"; ?>' />
						<input type="hidden" name="from" value='<?php echo "$from"; ?>' />

						<input class="FBnavButton FBnavLeft   FBnavIcon NavIconFirst" type="submit" value="" title="Go to first page" onclick="this.form.elements['from'].value=0;" />
						<input class="FBnavButton FBnavMiddle FBnavIcon NavIconPrev"  type="submit" value="" title="Go to previous page" onclick="this.form.elements['from'].value=<?php echo max($from - $size, 0); ?>;" />
						<input class="FBnavButton FBnavMiddle FBtext" type="submit" value="<?php echo min(floor($from / $size)+1, ceil($hitcount / $size));?>/<?php echo ceil($hitcount / $size);?>" disabled="disabled" />
						<input class="FBnavButton FBnavMiddle FBnavIcon NavIconNext"  type="submit" value="" title="Go to next page" onclick="this.form.elements['from'].value=<?php echo min($from + $size, (floor($hitcount / $size) * $size)); ?>;" />
						<input class="FBnavButton FBnavRight  FBnavIcon NavIconLast"  type="submit" value="" title="Go to last page" onclick="this.form.elements['from'].value=<?php echo floor($hitcount / $size) * $size; ?>;" />
					</form>
				</div>
			</div>

			<!-- Page Navigation button -->
			<br/><a class="FBnavButton" href="search.php">Search again</a>

		</div>

		<?php include_once("lib/pageFooter.php") ?>
	</div>

</body>
</html>
