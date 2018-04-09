<?php

class Index{

    // Here initialize our namespace and resource name.
    public function __construct() {
        $this->namespace     = '/index';
    }

    // Register our routes.
    public function registerRoutes() {
        register_rest_route( $this->namespace, '/nav', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'getNav' ),
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

    /**
     * @param $arr  所有的nav导航list
     * @param $id   需要找到对应的id
     * @return array
     */
    private function findAndDelete(&$arr,$id){
        $b=[];
        foreach($arr as $i=>$value){
            if($value->menu_item_parent == $id){
                array_push($b,$arr[$i]);
                unset($arr[$i]);
            }
        }
        return $b;
    }

    /**
     * 构建导航
     * @param $res          所有的nav导航list
     * @param $hash      承载导航的hash表
     */
    private function buildNav(&$res,&$hash){
        //组装导航
        foreach($hash as $i =>$value){
            $id = $value->ID;

            $b =$this->findAndDelete($res,$id);
            $value->sub= $b;

            // 是否有子目录
            if(count($b)>0){
                $this->buildNav($res,$value->sub);
            }
        }
    }

    public function getNav($request){
        $menu_name = 'main-menu';   // 获取主导航位置
        $locations = get_nav_menu_locations();
        $menu_id = $locations[ $menu_name ] ;
        $menu = wp_get_nav_menu_object($menu_id);    //根据locations反查menu
        $res = wp_get_nav_menu_items($menu->term_id);

        // 组装嵌套的导航,
        $hash = $this->findAndDelete($res,0);

        $this->buildNav($res,$hash);

        return rest_ensure_response( $hash );
    }
}

function prefix_register_Index_routes() {
    $controller = new Index();
    $controller->registerRoutes();
}

function deepNav($currentNav){
    $currentObj = array(
        sub=>[]
    );
    foreach ($currentNav as $nav){
        if($nav->menu_item_parent!==0){

        }
    }
}

add_action( 'rest_api_init', 'prefix_register_Index_routes' );

?>