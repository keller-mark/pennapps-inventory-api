<?php



/* DEVELOPMENT ONLY */
error_reporting(E_ALL);
ini_set('display_errors', 1);
/* END DEVELOPMENT ONLY		*/

date_default_timezone_set('America/New_York');
setlocale(LC_MONETARY,"en_US");

require 'flight/Flight.php';
require 'DB.php';
require 'CMS.php';
require 'Model.php';

require 'Item.php';
require 'Items.php';

require 'Inflector.php';

function dollar_format($amount) {
    return number_format($amount, 2, '.', ',');
}
