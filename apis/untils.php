<?php

class Untils{

    // Here initialize our namespace and resource name.
    public function __construct() {
        $this->namespace     = '/untils';
    }

    // Register our routes.
    public function registerRoutes() {
        register_rest_route( $this->namespace, '/wallpaper', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'getWallpaper' ),
            )
        ) );
        /*register_rest_route( $this->namespace, '/' . $this->resource_name . '/(?P<id>[\d]+)', array(
            // Notice how we are registering multiple endpoints the 'schema' equates to an OPTIONS request.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            ),
            // Register our schema callback.
            'schema' => array( $this, 'get_item_schema' ),
        ) );*/
    }

    public function getWallpaper($request){
        /***
         *   php curl
         *   get wallpaper
         */
        $time = time();
        $time = $time * 1000;

        //初始化
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, "https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&nc=$time");
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);

        $tmpInfo = json_decode($tmpInfo);

        //var_dump($tmpInfo);

        // Return all of our comment response data.
        return rest_ensure_response( $tmpInfo );
    }
}

function prefix_register_my_rest_routes() {
    $controller = new Untils();
    $controller->registerRoutes();
}

add_action( 'rest_api_init', 'prefix_register_my_rest_routes' );

?>