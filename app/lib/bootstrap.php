<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" xml:lang="en" lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
	<?php
		require_once("../appConfig.php");
		// Build Page Tab app url
		$FBpageTabURL = $FBpageName . (substr($FBpageName, -1)!='/' ? '/' : '') . 'app_' . $FBappID;
	?>

	<!-- Redirect needs to be client side/javascript -->
	<script type="text/javascript">
	window.top.location.href= "<?php echo $FBpageTabURL; ?>";
	</script>

	<!-- OpenGraph meta data for Search object -->
	<?php include_once("og_search.php") ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="noindex, nofollow">
</head></html>
