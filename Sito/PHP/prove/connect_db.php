<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'bwgv1ndudfu2g1dgtqva-mysql.services.clever-cloud.com');
define('DB_USERNAME', 'utl78xajidnhmswn');
define('DB_PASSWORD', 'bzyrrA36mIQM0nkYAUl7');
define('DB_NAME', 'bwgv1ndudfu2g1dgtqva');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
