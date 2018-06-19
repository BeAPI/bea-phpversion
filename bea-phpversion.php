<?php
/*
Plugin Name: BEA PHP Version
Plugin URI: https://github.com/BeAPI/bea-phpversion
Description: Be API PHP version
Author: https://beapi.fr
Version: 0.1.0
Author URI: https://beapi.fr
 ----
 Copyright 2018 Be API Technical team (human@beapi.fr)
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

defined( 'ABSPATH' )
	or die( '-No-' );

class BEA_PHP_Version {

	public function hooks() {
		add_action( 'dashboard_glance_items', array( $this, 'dashboard_glance_items' ) );
		add_action( 'admin_head', array( $this, 'add_styles' ) );
		add_action( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
	}

	public function admin_footer_text( $text ) {
		return '<span class="glance-phpversion">' . $this->generate_message() . '</span> | ' . $text;
	}

	public function dashboard_glance_items( $items ) {
		// we do not want this for all users
		if ( ! $this->is_allowed() ) {
			return;
		}
		
		$items[] = sprintf( '<li id="glance-phpversion"><span>%s</span></li>', $this->generate_message() );
		return $items;
	}

	public static function add_styles() {
		// we do not want this for all users
		if ( ! $this->is_allowed() ) {
			return;
		}

		$version = $this->normalize_php_version( $this->get_version() );

		if ( $this->version_not_match( $version ) ) {
			$this->generate_inline_styles( 'red' );
		}	
	}

	protected function generate_inline_styles( $color ) {
		// we do not want this for all users
		if ( ! $this->is_allowed() ) {
			return;
		}
		?>
        <style>
            #dashboard_right_now li#glance-phpversion span, .glance-phpversion {
                color: <?php echo sanitize_html_class( $color ); ?> !important;
            }
        </style>
		<?php
	}


	protected function generate_message() {
		$version = $this->normalize_php_version( $this->get_version() );
		$message = ( $this->version_not_match( $version ) ) 
							? __( 'The current PHP version does not match project\'s version !', 'bea-phpversion' )
							: sprintf( 'PHP %s', $version );
		
		return $message;
	}

	protected function version_not_match( $current ) {
		return defined( 'BEA_PHP_VERSION' ) && BEA_PHP_VERSION !== $current;
	}

	protected function is_allowed() {
		// we do not want this for all users
		return apply_filters( 'bea_phpversion_is_allowed', is_super_admin() );
	}

	protected function normalize_php_version( $version ) {
		return substr( $version, 0, 3 );
	}

	protected function get_version() {
		return ( phpversion('tidy') ) ? phpversion('tidy') : phpversion();
	}

}

$bea_phpversion = new BEA_PHP_Version;
$bea_phpversion->hooks();