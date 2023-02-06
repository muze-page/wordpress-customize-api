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

//自定义控件 - 基础
require_once dirname( __FILE__ ) . '/options/custom-control.php' ;

//自定义控件 - 高级
require_once dirname( __FILE__ ) . '/options/custom-control-pro.php' ;

//加载测试框架
require_once dirname( __FILE__ ) . '/options/demo.php' ;
//测试控件
//require_once dirname( __FILE__ ) . '/test.php' ;

//add_action( 'wp_head', 'test_tops' );

function test_tops() {

    $a =  plugin_dir_url( __FILE__ ) . 'public/css/fontawesome-all.min.css';
    $b = '我被加载咯';
    //$add_content = '<h1>'.p( test ).'</h1>';
    $add_content = '<h5>'.$a.'</h5>';
    echo $add_content;
}
;

//加载面板图标

function THEMENAME_custom_customize_enqueue() {
    wp_enqueue_style( 'customizer-css', plugin_dir_url( __FILE__ ) . 'public/css/customizer-css.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'THEMENAME_custom_customize_enqueue' );

/* ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===
*自定义自定义控件
* ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  === */

/**
*排队脚本和样式。
*我们的示例社交图标使用字体真棒图标，因此我们需要在查看网站时包含FA CSS
*Single Accordion控件还在Customizer中显示一些FA图标，因此我们也需要在Customizer中将FA CSS排队
*
* @return void
*/
if ( ! function_exists( 'skyrocket_scripts_styles_a' ) ) {
    function skyrocket_scripts_styles_a() {
        // Register and enqueue our icon font
        // We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
		wp_register_style( 'fontawesome',  plugin_dir_url( __FILE__ ) . 'public/css/fontawesome-all.min.css' , array(), '5.8.2', 'all' );
		wp_enqueue_style( 'fontawesome' );
	}
}
add_action( 'wp_enqueue_scripts', 'skyrocket_scripts_styles_a' );//前台
add_action( 'customize_controls_print_styles', 'skyrocket_scripts_styles_a' );//自定义控件

        ?>
