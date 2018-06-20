<?php
/*
Plugin Name: BEA PHP Version
Plugin URI: https://github.com/BeAPI/bea-phpversion
Description: Be API PHP version
Author: https://beapi.fr
Version: 0.1.2
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
		add_action( 'wp_footer', array( $this, 'add_ribbon' ) );
		add_action( 'admin_footer', array( $this, 'add_ribbon' ) );
	}

	public function generate_inline_styles( $version_not_match ) {
		$styles       = 'position: fixed;top: 2rem;right: 2rem;padding: 1rem;z-index: 999;';
		$life_is_cool = esc_attr( apply_filters( 'bea_phpversion_success_inline_styles', 'background-color: #dff0d8;border: 1px solid #d0e9c6;color: #3c763d;' ) );
		$achtung      = esc_attr( apply_filters( 'bea_phpversion_error_inline_styles', 'background-color: #f2dede;border: 1px solid #ebcccc;color: #a94442;' ) );
		$styles       .= $version_not_match ? $achtung : $life_is_cool;

		return esc_attr( apply_filters( 'bea_phpversion_inline_styles', $styles ) );
	}

	public function add_ribbon() {

		// we do not want this for all users
		if ( ! $this->is_allowed() ) {
			return;
		}

		$version           = $this->normalize_php_version( $this->get_version() );
		$version_not_match = $this->version_not_match( $version );

		echo sprintf( '<div id="phpversion" class="phpversion" style="%s">%s</div>', $this->generate_inline_styles( $version_not_match ), $this->generate_message( $version, $version_not_match ) );
	}

	protected function generate_message( $version, $version_not_match ) {
		$message = ( $version_not_match )
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
		return ( phpversion( 'tidy' ) ) ? phpversion( 'tidy' ) : phpversion();
	}

}

add_action( 'plugins_loaded', 'bea_phpversion_load' );
function bea_phpversion_load() {
	$bea_phpversion = new BEA_PHP_Version;
	$bea_phpversion->hooks();
}

add_action( 'init', 'bea_phpversion_load_i18n' );
function bea_phpversion_load_i18n() {
	load_muplugin_textdomain( 'bea-phpversion', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
