<?php

    /**
     * This is our callback function that embeds our phrase in a WP_REST_Response
     */
    function prefix_get_endpoint_phrase($request) {
        // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.


        $str ='Hello World, this is the WordPress REST API';

        if(isset($request['id'])){

            $str = $str . $request['id'];

        }

        return rest_ensure_response($str);
    }

    /**
     * This function is where we register our routes for our example endpoint.
     */
    function prefix_register_example_routes() {
        // register_rest_route() handles more arguments but we are going to stick to the basics for now.
        register_rest_route( 'hello-world/v1', '/phrase/(?P<id>[\d]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => WP_REST_Server::READABLE,
            // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
            'callback' => 'prefix_get_endpoint_phrase',
        ) );
    }

    add_action( 'rest_api_init', 'prefix_register_example_routes' );
?>