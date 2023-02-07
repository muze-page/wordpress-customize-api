<?php 
//基础功能演示
//注册一个菜单
/**
* Add our Customizer content
*/

function mytheme_customize_register( $wp_customize ) {
    // Add all your Customizer content ( i.e. Panels, Sections, Settings & Controls ) here...
    //在此处添加所有自定义器内容（即面板、节、设置和控件）。。。

    //添加面板
    /**
 * Add our Header & Navigation Panel
 * 添加标题和导航面板
 */
 $wp_customize->add_panel( 'header_naviation_panel',
 array(
    'title' => __( '标题和导航-基础功能演示' ),
    'description' => esc_html__( '调整标题和导航部分。' ), // Include html tags such as 

    'priority' => 160, // Not typically needed. Default is 160
    'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
    'theme_supports' => '', // Rarely needed
    'active_callback' => '', // Rarely needed
 )
);

//添加部分
/**
 * Add our Sample Section
 */
$wp_customize->add_section( 'sample_custom_controls_section',
   array(
      'title' => __( '自定义控件示例' ),
      'description' => esc_html__( '以下是Customizer自定义控件的示例。' ),
      'panel' => 'header_naviation_panel', // Only needed if adding your Section to a Panel
      'priority' => 160, // Not typically needed. Default is 160
      'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
      'theme_supports' => '', // Rarely needed
      'active_callback' => '', // Rarely needed
      'description_hidden' => 'false', // Rarely needed. Default is False
   )
);
//添加设置
//$wp_customize->add_setting( 'sample_default_text',
//   array(
//      'default' => '', // Optional.
//      'transport' => 'refresh', // Optional. 'refresh' or 'postMessage'. Default: 'refresh'
//      'type' => 'theme_mod', // Optional. 'theme_mod' or 'option'. Default: 'theme_mod'
//      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
//      'theme_supports' => '', // Optional. Rarely needed
//      'validate_callback' => '', // Optional. The name of the function that will be called to validate Customizer settings
//      'sanitize_callback' => '', // Optional. The name of the function that will be called to sanitize the input data before saving it to the database
//      'sanitize_js_callback' => '', // Optional. The name of the function that will be called to sanitize the data before outputting to javascript code. Basically to_json.
//      'dirty' => false, // Optional. Rarely needed. Whether or not the setting is initially dirty when created. Default: False
//   )
//);
//添加控件
$wp_customize->add_setting( 'sample_default_text',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'skyrocket_text_sanitization'
   )
);
 
$wp_customize->add_control( 'sample_default_text',
   array(
      'label' => __( '默认文本控件' ),
      'description' => esc_html__( '文本控件类型可以是文本、电子邮件、url、数字、隐藏或日期' ),
      'section' => 'sample_custom_controls_section',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'text', // Can be either text, email, url, number, hidden, or date
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'input_attrs' => array( // Optional.
         'class' => 'my-custom-class',
         'style' => 'border: 1px solid rebeccapurple',
         'placeholder' => __( 'Enter name...' ),
      ),
   )
);

//不要面板
$wp_customize->add_section( 'api_custom_controls_section',
   array(
      'title' => __( '不用面板-基础功能演示' ),
      'description' => esc_html__( '以下是Customizer自定义控件的示例。' ),
      //'panel' => 'api_panel', // 仅当将节添加到面板时才需要
   )
);

//添加控件
$wp_customize->add_setting( 'api_default_text',
   array(
      'default' => '',
      'transport' => 'refresh',
   )
);
 
$wp_customize->add_control( 'api_default_text',
   array(
      'label' => __( '默认文本控件' ),
      'description' => esc_html__( '文本控件类型可以是文本、电子邮件、url、数字、隐藏或日期' ),
      'section' => 'api_custom_controls_section',
      'type' => 'text', // Can be either text, email, url, number, hidden, or date
   )
);

}
;
add_action( 'customize_register', 'mytheme_customize_register' );
?>