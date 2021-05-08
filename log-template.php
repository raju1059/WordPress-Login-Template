<?php
/*
Plugin Name:  T Login Template
Text Domain: tlog
Plugin URI:http://raju_ahmed.wordpress.org
Description: This plugin can change login template in the wordpress  website.
Version: 2.1
Author: Raju Ahmed
Author URI:http://raju_ahmed.wordpress.org
License: GPLv2 or later
*/
require_once dirname( __FILE__ ) . '/class-setting.php';
require_once dirname( __FILE__ ) . '/class-disply.php';
require_once dirname( __FILE__ ) . '/class-featur.php';
/**
 * WordPress Login Template API
 *
 * @author Raju Ahmed
 */
if ( !class_exists('TistaLoginAPI' ) ):
class TistaLoginAPI {
	
    private $api;
    	
	function __construct() {
        $this->api = new TistaLoginSetting;
        new TistaLoginDisplay;
        new TistaLoginTemFeature;
        add_action( 'plugins_loaded', array($this, 'texdomain') );
        add_action( 'admin_menu', array($this, 'adminmenu') );
		add_action( 'admin_init', array($this, 'jmra_set_section') );		
    }
	/**
     * Load Textdomain
     *
     * @return prameter
     */
	function texdomain() {
		$lang = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		load_plugin_textdomain('tit', false, $lang);
	}
	/**
     * Register admin menu
     *
     * @return array
     */
	function adminmenu(  ) { 
		$menu_page = add_menu_page( __( 'T Login Template','tit' ), __( 'T Login Template','tit' ), 'read', 'tlogtemplate', array($this, 'custom_form'));
		
		add_action('admin_print_scripts-' . $menu_page, array($this, 'custom_style'));
	}
	/**
     * Load custom style 
     *
     * @return array
     */
	function custom_style(){
		wp_register_style('tcss', plugins_url( '/css/options_page.css' , __FILE__ ) );
		wp_enqueue_style( 'tcss' );
	}
	function jmra_set_section() {
		
		//set the settings);
        $this->api->set_fields( $this->jmra_field() );

        //initialize settings
        $this->api->jmra_setion();
    }
	/**
     * Register form field
     *
     * @return array
     */
	function jmra_field(){
		
		$arg = array(
			array(
				'name'=>'imagecolor',
				'label'=> __( 'Background option', 'tit' ),
				'desc'=> __( 'you can set login template background image or background color ', 'tit' ),
				'default'=>'yes',
				'type'=>'radio',
				'options' => array(
                        'yes' => __( 'Enable background image', 'tit' ),
                        'no' => __( 'Enable background color', 'tit' ),
                    )
			),
			array(
				'name'=>'backgroundcolor',
				'label'=> __( 'Background color', 'tit' ),
				'desc'=> __( 'You can change login template the Background color.', 'tit' ),
				'type'=>'color',
				'default'=>'#81d742',
				'size'=>'',
			),
			array(
				'name' => 'loginlogo',
				'label' => __( 'Logo', 'tit' ),
				'desc' => __( 'You can change login template logo', 'tit' ),
				'type' => 'file',
				'default' => '',
				'size'=>'',
			),
			array(
				'name' => 'backgroundimage',
				'label' => __( 'Background image', 'tit' ),
				'desc' => __( 'You can change login template background image', 'tit' ),
				'type' => 'file',
				'default' => '',
				'size'=>'',
			),
		);
		return $arg;
	}
	/**
     * Load custom form 
     *
     * @return array
     */
	function custom_form(  ) { 	
			$this->api->show_forms();
	}
}
endif;
$titapi = new TistaLoginAPI();