<?php
/*
Plugin Name:  Block Attributes
Plugin URI:   https://maxpertici.fr#block-attributes
Description:  Add attributes to Gutenberg blocks.
Version:      0.1.0
Author:       @maxpertici
Author URI:   https://maxpertici.fr
Contributors:
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  block-attributes
Domain Path:  /languages/
*/

defined( 'ABSPATH' ) or die();

use MXP\BlockAttributes\Core\App ;

require __DIR__ . '/vendor/autoload.php';

$app = App::instance();
$app->createFromFile( __FILE__ );
$app->load();
