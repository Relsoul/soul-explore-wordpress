<?php

class Auth{
    public  function authThemeOptions(){
        // Restrict endpoint to only users who have the edit_posts capability.
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'OMG you can not view private data.', 'my-text-domain' ), array( 'status' => 401 ) );
        }

        // This is a black-listing approach. You could alternatively do this via white-listing, by returning false here and changing the permissions check.
        return true;
    }

    /**
     * @param $namespace    前缀
     * @param $path               对应路径
     * @param $array              array参数,请参考untils.php的定义 或者{@link https://developer.wordpress.org/rest-api/extending-the-rest-api/controller-classes/}
     */
    public function addRoute($namespace, $path, $array){

        $argArray = array(
            array(
                'methods'   =>$array['methods'],
                'callback'  => $array['callback'],
                'permission_callback' => array( $this, 'authThemeOptions' ),
            )
        );

        if(in_array('schema',$array)){

            $argArray['schema'] = $array['schema'];
        }

        register_rest_route( $namespace, $path, $argArray);
    }
}

/**
 * 注册导航
 */

register_nav_menu( 'main-menu', '主导航' );

include_once (get_template_directory()."./apis/test.php");
include_once (get_template_directory()."./apis/untils.php");
include_once (get_template_directory()."./apis/admin.php");
include_once (get_template_directory()."./apis/index.php");


?>