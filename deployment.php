<?php
	
	/**
	 * @package Multi_Deployment
	 * @version 1.0
	 */
	/*
	Plugin Name: Multi Deployment
	*/

	 add_action('init', array('Multi_Deployment', 'init'));

	 /**
	 * 	Wrapper class
	 *	
	 *	@since 1.0
	 */
	 class Multi_Deployment {

	 	public static 
	 		$current, 
	 		$hostnames,
	 		$http_paths,
	 		$save_options,
	 		$form_action = 'options-general.php?page=rapid-deploy-settings';

	 	static function init(){

	 		// Hooks //
			add_action('admin_menu', array('Multi_Deployment', 'add_options_page'));
			add_action('admin_notices', array('Multi_Deployment', 'save_options_notice'));

			self :: init_options();
	 		self :: get_options();
	 		self :: save_options();
	 		self :: check_host_has_changed();
	 	}

	 	static function init_options(){
	 		add_option('deployment_env_local', 'localhost');
	 		add_option('deployment_env_stage', '');
	 		add_option('deployment_env_prod', '');
	 		add_option('deployment_http_local', get_option('siteurl'));
	 		add_option('deployment_http_stage', '');
	 		add_option('deployment_http_prod', '');
	 		add_option('deployment_current_env', '');
	 	}

	 	static function get_options(){

	 		self :: $current = get_option('deployment_current_env');

	 		self :: $hostnames = array(
	 			'local' => get_option('deployment_env_local'),
	 			'stage' => get_option('deployment_env_stage'),
	 			'prod' => get_option('deployment_env_prod')
	 		);

	 		self :: $http_paths = array(
	 			'local' => get_option('deployment_http_local'),
	 			'stage' => get_option('deployment_http_stage'),
	 			'prod' => get_option('deployment_http_prod')
	 		);

	 		self :: $save_options = array(
	 			'deployment_env_local',
	 			'deployment_env_stage',
	 			'deployment_env_prod',
	 			'deployment_http_local',
	 			'deployment_http_stage',
	 			'deployment_http_prod',
	 		);
	 		
	 	}

	 	static function check_host_has_changed(){
			switch( true ){
	 			case $_SERVER['HTTP_HOST'] == self :: $current :
	 				return false;
	 				break;
	 			case in_array( $_SERVER['HTTP_HOST'], self :: $hostnames ) :
	 				self :: reset_option( $_SERVER['HTTP_HOST'] );
	 				break;
	 		}
	 	}

	 	static function reset_option( $the_hostname ){
	 		foreach( self :: $hostnames as $type => $hostname ){
	 			if( $hostname == $the_hostname ){
	 				update_option('siteurl', self :: $http_paths[ $type ] );
	 				update_option('home', self :: $http_paths[ $type ] );
	 				update_option('deployment_current_env', $hostname );
	 				flush_rewrite_rules();
	 				break;
	 			}
	 		}
	 	}

	 	static function settings_view(){
	 		$opts = self :: $hostnames;
	 		$http = self :: $http_paths;
	 		return include('views/settings.php');
	 	}

	 	static function add_options_page(){
	 		add_options_page( 
	 			'Rapid Deployment Settings', 
	 			'Rapid Deployment', 
	 			'manage_options', 
	 			'rapid-deploy-settings', 
	 			array('Multi_Deployment', 'settings_view') 
	 		);
	 	}

	 	static function save_options(){

	 		if( ! empty($_POST) && isset( $_POST['_rapid_deployment_nonce'] ) ){
	 			if( ! wp_verify_nonce( $_POST['_rapid_deployment_nonce'], 'save_settings' ) ){
	 				print 'Nonce did not verify.';
   					exit;
	 			}
	 		} else {
	 			return;
	 		}

	 		foreach( self :: $save_options as $field ){
	 			update_option( $field, $_POST[ $field ] );
	 		}
	 		
	 		self :: check_host_has_changed();

	 		self :: get_options();
	 		
	 	}

	 	static function save_options_notice(){
		    echo '<div class="updated">
		       <p>Configuration saved.</p>
		    </div>';
		}

	 }


