<?php

class WiremonkeyInit{

	public function __construct(){
		$this->initAll();
	}
	
	public function enqueuePublicScripts(){
		$default_opt = array(
			"alwaystop"=>0,
			"isenable"=>1,
			"showicon"=>1,
			"theme"=>1,
			"connect_message" => "Connected to internet.",
			"disconnect_message" => "No internet, please check the connection."
			);

		$params = array_merge(get_option('wiremonkey_opt',$default_opt),array('plugins_url' => plugins_url('../assets/',__FILE__)));
		wp_enqueue_script("wiremonkey-core-js",plugins_url("../assets/js/wiremonkey.js",__FILE__), array('jquery'), null, true);

		wp_enqueue_script("wiremonkey-lib-tostie-js",plugins_url("../assets/libraries/Tostie/jquery.tostie.js",__FILE__), array('jquery'), null, true);
		wp_enqueue_script("wiremonkey-init-js",plugins_url("../assets/js/init.js",__FILE__), array('jquery','wiremonkey-lib-tostie-js','wiremonkey-core-js'), null, true);
		wp_enqueue_style('wiremonkey-css-default',plugins_url('../assets/css/wiremonkey.css',__FILE__));
		wp_enqueue_style('wiremonkey-lib-tostie',plugins_url('../assets/libraries/Tostie/jquery.tostie.css',__FILE__));
		wp_localize_script( 'wiremonkey-core-js', 'wmky_settings', $params );	
	}
	public function enqueueAdminScripts(){
				wp_enqueue_style('wiremonkey-css-default',plugins_url('../assets/css/wiremonkey.css',__FILE__));
	}

	public function initAll(){
		add_action( 'wp_enqueue_scripts', array($this,'enqueuePublicScripts'),20,1);
		add_action( 'admin_enqueue_scripts', array($this,'enqueueAdminScripts'),20,1);
	}


}


