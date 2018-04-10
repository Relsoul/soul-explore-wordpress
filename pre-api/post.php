<?php

/**
 * 获取post的时候做预处理
 */
class prePost{
    public function __construct()
    {
        $this->init();
    }

    public function init(){
        add_action( 'rest_api_init', function () {
            $this->addTags();
            $this->addCategories();
            $this->addAuthorStr();
            $this->addPostView();
            $this->addPostFeatureImg();
            $this->addAuthorAvatar();
        } );
    }

    private function addTags(){
        register_rest_field( 'post', 'tagStrArr', array(
            'get_callback' => function( $postArr ) {
                $tagStrArr = $this->__transformArrToStrArr($postArr['tags'],'post_tag');
                return $tagStrArr;
            },
        ) );
    }

    /**
     * @param $filedArr             需要转换的字段
     * @param $taxonomy         对应的字段taxonomy
     * @return array
     */
    private function __transformArrToStrArr($filedArr,$taxonomy){
        $resArr=[];
        if(count($filedArr)>0){
            $includeIdStr = implode(",", $filedArr);
            //根据id查找当前的tags object
            $Arr = get_terms(array(
                'taxonomy'=>$taxonomy,
                'include'=>$includeIdStr
            ));
            $resArr = array_map(function($n){
                return $n->name;
            },$Arr);
        }
        return $resArr;
    }

    private function addCategories(){
        register_rest_field( 'post', 'categoryStrArr', array(
            'get_callback' => function( $postArr ) {
                $categoryStrArr = $this->__transformArrToStrArr($postArr['categories'],'category');

                return $categoryStrArr;
            },
        ) );
    }

    private function addAuthorStr(){
        register_rest_field( 'post', 'authorStr', array(
            'get_callback' => function( $postArr ) {
                $userObj = get_user_meta($postArr['author'],'nickname');
                return $userObj[0];
            },
        ) );
    }

    private function addAuthorAvatar(){
        register_rest_field( 'post', 'authorAvatar', array(
            'get_callback' => function( $postArr ) {
                $userObj = get_avatar($postArr['author']);
                preg_match_all("/src=\"([^\"]+)\"/",$userObj,$matches);
                return $matches[1][0];
            },
        ) );
    }

    private function addPostView(){
        register_rest_field( 'post', 'view', array(
            'get_callback' => function( $postArr ) {
                $views = (int)get_post_meta($postArr['id'], 'views', true);

                return $views;
            },
        ) );
    }

    private function addPostFeatureImg(){
        register_rest_field( 'post', 'featureImg', array(
            'get_callback' => function( $postArr ) {

                $postThumbnailId=get_post_thumbnail_id($postArr['id']);
                $postThumbnailKey = 0;
                $args = array(
                    'post_type'   => 'attachment',
                    'numberposts' => -1,
                    'post_status' => 'any',
                    'post_parent' => $postArr['id'],
//                    'exclude'     =>$postThumbnailId ,
                );

                $attachments = get_posts( $args );
                $attachments = array_map(function($item)use($postThumbnailId,&$postThumbnailKey,$attachments){
                    if($item->ID == $postThumbnailId){
                        $currentKey=array_search($item,$attachments);
                        $postThumbnailKey=$currentKey;
                    }

                    return $item->guid;
                },$attachments);

                //如果存在特色图片则添加至数组第一
                if(has_post_thumbnail($postArr['id'])){
                    //将特色图片移至数组第一位
                    $postThumbnail = get_the_post_thumbnail($postArr['id']);
                    $postUrl = $attachments[$postThumbnailKey];
                    array_splice($attachments,$postThumbnailKey,1);
                    array_unshift($attachments,$postUrl);
                }

                if(count($attachments)>5){
                    array_splice($attachments,0,5);
                }

                if(count($attachments)<=0){
                    array_push($attachments,'https://cn.bing.com//az/hprichbg/rb/ElephantSibs_ZH-CN13499373865_1920x1080.jpg');
                }

                return (array)$attachments;
            },
        ) );
    }
}

?>