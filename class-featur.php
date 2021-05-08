<?php
if ( !class_exists('TistaLoginTemFeature' ) ):
class TistaLoginTemFeature {
	
	public function __construct(){
		//load feature
		add_filter( 'login_headerurl', array($this, 'login_url') );
		add_filter( 'login_headertitle', array($this, 'login_title') );
		add_action( 'login_head', array($this, 'login_page_shake') );
		add_filter( 'login_redirect', array($this, 'admin_login_redirect'),10,3 );
	}

	//Change the Login Logo URL

	function login_url() {
		return 'http://raju_ahmed.wordpress.org' ;
	}

	function login_title() {
		return 'Wordpress Custom Login Theme';
	}

	//Hide the Login Error Message	

	//Remove the Login Page Shake
	function login_page_shake() {
		remove_action('login_head', 'wp_shake_js', 12);
	}
	//Change the Redirect URL
	function admin_login_redirect( $redirect_to, $request, $user )
	{
		global $user;
		if( isset( $user->roles ) && is_array( $user->roles ) ) {
		if( in_array( "administrator", $user->roles ) ) {
		return $redirect_to;
		} else {
		return home_url();
		}
		}
		else
		{
		return $redirect_to;
		}
	}
}
endif;