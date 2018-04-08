<?php

class Admin extends Auth {

    // Here initialize our namespace and resource name.
    public function __construct() {
        $this->namespace     = '/admin';
    }

    // Register our routes.
    public function registerRoutes() {

        $this->addRoute($this->namespace,'/index', array(
            'methods'   => 'GET',
            'callback'  => array( $this, 'indexConf' ),
        ));

    }

    public function indexConf($request){

        return rest_ensure_response( array(
            'isok'=>true
        ));
    }
}

function prefix_register_admin_routes() {
    $controller = new Admin();
    $controller->registerRoutes();
}

add_action( 'rest_api_init', 'prefix_register_admin_routes' );

?>