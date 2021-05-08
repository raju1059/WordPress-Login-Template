<?php
if ( !class_exists('TistaLoginDisplay' ) ):
class TistaLoginDisplay {
	
	private $loginlogo;
	private $background;
	private $outer;
	
	public function __construct() {
		$logo = plugins_url( '/img/logo.png', __FILE__ );
		$bg = plugins_url( '/img/bg.jpg', __FILE__ );
		$this->loginlogo = esc_attr( $this->jmra_get_option('loginlogo','tlogoption',$logo));
		$this->background = esc_attr( $this->jmra_get_option('backgroundimage','tlogoption',$bg));
		$this->outer = plugins_url( '/img/outer.png', __FILE__ );
		
		//enable background image or background color
		$imagecolor = esc_attr( $this->jmra_get_option('imagecolor','tlogoption',''));
		switch($imagecolor){
			case 'yes':
					add_action( 'login_enqueue_scripts', array($this, 'login_imgbackground') );
			break;
			case 'no':
				add_action( 'login_enqueue_scripts', array($this, 'login_colorbackground') );
			break;
			default:
			add_action( 'login_enqueue_scripts', array($this, 'login_imgbackground') );
		}
    }
	/**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
    */
    function jmra_get_option( $option, $section, $default = '' ) {
        $options = get_option( $section );
        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }else{
        return $default;
		}
    }
	/**
     * Display background image 
     *
     * @return array
     */
	function login_imgbackground() {	
			echo '<style type="text/css">
				body{
					background-image: url("'.$this->background.'")  !important;
					background-repeat:no-repeat;
					background-position:fixed;
					background-size:cover;
				}
				body.login div#login {
					 background: url("'.$this->outer.'") ;
					 height: auto;
					 left: 50%;
					 margin: -225px auto auto -200px;
					 padding: 40px;
					 position: absolute;
					 top: 50%;
					 width: 320px;	
				}
				body.login h1 a{
					background-image:url("'.$this->loginlogo.'") !important;
				}
			</style>';
	}
	/**
     * Display background color 
     *
     * @return array
     */
	function login_colorbackground() {
		$background = esc_attr( $this->jmra_get_option('backgroundcolor','tlogoption',''));
			echo '<style type="text/css">
				body{
					background: '.$background.' !important;
				}
				body.login div#login {
					 background: url( "'.$this->outer.'") ;
					 height: auto;
					 left: 50%;
					 margin: -225px auto auto -200px;
					 padding: 40px;
					 position: absolute;
					 top: 50%;
					 width: 320px;	
				}
				body.login h1 a{
					background-image:url("'.$this->loginlogo.'") !important;
				}
			</style>';
	}
}
endif;