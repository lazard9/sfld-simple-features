<?php defined( 'WPINC' ) or die();

/**
 * Fired during plugin deactivation
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\Includes;

if ( ! class_exists( 'SFLD_Deactivator', false ) ) : class SFLD_Deactivator
{

    public static function deactivate() {

    }

} endif;
