<?php
namespace PressForward\Core\API;

use Intraxia\Jaxion\Contract\Core\HasActions;

use PressForward\Core\Admin\PFTemplater;

use WP_Ajax_Response;
use WP_Error;

class NominateThisEndpoint implements HasActions {

	protected $api_base;

	function __construct( $api_base, PFTemplater $templates ) {
		$this->api_base = $api_base;
		$this->api_base['endpoint'] = 'nominatethis';
		$this->templates = $templates;
		$namespace = $this->api_base['base_namespace'] . $this->api_base['version'];
		$base = $this->api_base['endpoint'];
		$this->api_base['authpoint'] = 'nominate';
		$this->endpoint_for_nominate_this_endpoint = $namespace. '/' . $base;
		$this->endpoint_for_nominate_endpoint = $namespace. '/' . 	$this->api_base['authpoint'];
	}

	public function action_hooks() {
		//add_action( 'rest_api_init', 'activate_pf_rest_controller', 11 );
		$actions = array(
			array(
				'hook' => 'rest_api_init',
				'method' => 'activate',
				'priority'	=> 11
			),
		);
		return $actions;
	}

	function activate() {
		$controller = $this;
		$controller->register_routes();
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = $this->api_base['base_namespace'] . $this->api_base['version'];
		$base = $this->api_base['endpoint'];
		register_rest_route( $namespace, '/' . $base, array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_nominate_this_template' ),
				'args' => array(
			      'context' => array(
					  // description should be a human readable description of the argument.
					'description' => esc_html__( 'Supplies the Nominate This template for building the bookmarklet.', 'pf' ),
					// type specifies the type of data that the argument should be.
					'type'        => 'string',
					// Set the argument to be required for the endpoint.
					'required'    => false,
					'default'	  => 'view'
			      ),
			    ),
				'permission_callback' => function () {
					//return true;
					if (true === rest_cookie_check_errors()){
						return true;
					}
					$nominate_access = get_option('pf_menu_all_content_access');
  				  //pressforward('admin.templates')->users->pf_get_defining_capability_by_role( 'contributor' );//get_option('pf_menu_all_content_access');
	  				if ( ! current_user_can( get_option( 'pf_menu_nominate_this_access', pressforward( 'controller.users' )->pf_get_defining_capability_by_role( 'contributor' ) ) ) ){
	  				  	//wp_die( __( 'You do not have the capacity to access the Nominate This bookmarklet.', 'pf' ) );
	  				  	return false;
					} else {
						return true;
					} //$this->templates->users->pf_get_defining_capability_by_role( 'contributor' );
			  	},
				'priority'  => 10,
			),
		));
		register_rest_route($namespace, '/'.$this->api_base['authpoint'], array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_nominate_this' ),
				'args' => array(
				  'context' => array(
					  // description should be a human readable description of the argument.
					'description' => esc_html__( 'Supplies the Nominate This template for building the bookmarklet.', 'pf' ),
					// type specifies the type of data that the argument should be.
					'type'        => 'string',
					// Set the argument to be required for the endpoint.
					'required'    => false,
					'default'	  => 'view'
				  ),
				  'u' => array(
					  // description should be a human readable description of the argument.
					'description' => esc_html__( 'Supplies the Nominate This template for building the bookmarklet.', 'pf' ),
					// type specifies the type of data that the argument should be.
					'type'        => 'string',
					// Set the argument to be required for the endpoint.
					'required'    => false,
					'default'	  => 'view'
				  ),
				  's' => array(
					  // description should be a human readable description of the argument.
					'description' => esc_html__( 'Supplies the Nominate This template for building the bookmarklet.', 'pf' ),
					// type specifies the type of data that the argument should be.
					'type'        => 'string',
					// Set the argument to be required for the endpoint.
					'required'    => false,
					'default'	  => 'view'
				  ),
				  'v' => array(
					  // description should be a human readable description of the argument.
					'description' => esc_html__( 'Supplies the Nominate This template for building the bookmarklet.', 'pf' ),
					// type specifies the type of data that the argument should be.
					'type'        => 'string',
					// Set the argument to be required for the endpoint.
					'required'    => false,
					'default'	  => ''
				  ),
				),
				'permission_callback' => function () {
					return true;
				},
				'priority'  => 10,
			),
		));

	}

	public function get_nominate_this_template($request){
		define( 'IFRAME_REQUEST' , true );
		define( 'WP_ADMIN', false );
		global $pagenow;
		//wp_verify_nonce( $nonce, 'wp_rest' );
		return rest_ensure_response(
				include( PF_ROOT.'/includes/nomthis/nominate-this-core.php' )
			);
	}

	public function get_nominate_this($request){
		define( 'IFRAME_REQUEST' , true );
		define( 'WP_ADMIN', true );
		//var_dump($request); var_dump($_GET); die();
		global $pagenow;
		header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
		$nonce = wp_create_nonce( 'wp_rest' );
		ob_start();
		wp_login_form(array(
			'redirect'	=>	rest_url($this->endpoint_for_nominate_this_endpoint.'?nonce='.$nonce, 'html')
		));
		$login = ob_get_clean();
		echo $login;
		die();

	}


}