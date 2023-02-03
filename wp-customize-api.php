<?php
/*
Plugin Name: WordPress Customize API
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: 了解WordPress Customize API机制用
Version: 插件版本号, 例如: 1.0
Author: 插件作者
Author URI: http://URI_Of_The_Plugin_Author作者地址
*/

//基础功能演示
require_once dirname( __FILE__ ) . '/options/basic-demo.php' ;

//自定义控件
require_once dirname( __FILE__ ) . '/options/custom-control.php' ;

//最小化的控件
//require_once dirname( __FILE__ ) . '/options/demo.php' ;
//测试控件
//require_once dirname( __FILE__ ) . '/test.php' ;

//add_action( 'wp_head', 'test_tops' );
//
//function test_tops() {
//
//    $a =  trailingslashit( dirname( __FILE__ ) ) . 'inc/customizer.php';
//    $b = '我被加载咯';
//    //$add_content = '<h1>'.p( test ).'</h1>';
//    $add_content = '<h5>'.$b.'</h5>';
//    echo $add_content;
//}
//;

?>
