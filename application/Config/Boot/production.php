<?php

/*
|--------------------------------------------------------------------------
| ERROR DISPLAY
|--------------------------------------------------------------------------
*/

// Don't show ANY in production environments. Instead, let the system catch
// it and display a generic error message.
//ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
/*
|--------------------------------------------------------------------------
| DEBUG MODE
|--------------------------------------------------------------------------
| Debug mode is an experimental flag that can allow changes throughout
| the system. It's not widely used currently, and may not survive
| release of the framework.
*/

define('CI_DEBUG', 0);