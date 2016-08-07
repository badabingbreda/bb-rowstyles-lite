<?php
/**
 * bb-rowstyles
 *
 * @package     RowStyles lite
 * @author      Badabingbreda
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Beaver Builder Row Styles Lite
 * Plugin URI:  https://www.beaverplugins.com/plugins/rowstyles-lite/
 * Description: Add Unsplash Images, Youtube video and Shaded layers as a full width background on any row, right from the Row-settings panel. Add a color-shaded overlay over the background to improve visibility of your modules and text.
 * Version:     0.2
 * Author:      BadabingBreda
 * Author URI:  https://www.badabing.nl
 * Text Domain: bb-rowstyles
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'BBROWSTYLESLITE_VERSION' , '0.' );
define( 'BBROWSTYLESLITE_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBROWSTYLESLITE_URL', plugins_url( '/', __FILE__ ) );

//textdomain
load_plugin_textdomain( 'bb-rowstyleslite', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

add_action( 'init', 'BBROWSTYLESLITE_plugin_start' );

function BBROWSTYLESLITE_plugin_start() {

  if ( class_exists( 'FLBuilder' ) ) {

       require_once ( 'includes/rowstyles.php' );

  }

}

/**
 * UPDATER
 */

if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}
$updater = new Smashing_Updater( __FILE__ );
$updater->set_username( 'badabingbreda' );
$updater->set_repository( 'bb-rowstyles-lite' );

$updater->initialize();


