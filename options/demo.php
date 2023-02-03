<?php 
//最小的控制面板


//注册一个菜单
function api_customize_register( $wp_customize ) {
    // Add all your Customizer content ( i.e. Panels, Sections, Settings & Controls ) here...
    //在此处添加所有自定义器内容（即面板、节、设置和控件）。。。

    //添加面板


//添加部分
/**
 * Add our Sample Section
 */
$wp_customize->add_section( 'demo_custom_controls_section',
   array(
      'title' => __( '最小化自定义控件示例' ),
      'description' => esc_html__( '以下是Customizer自定义控件的示例。' ),
      //'panel' => 'api_panel', // 仅当将节添加到面板时才需要
   )
);

//添加控件
$wp_customize->add_setting( 'demo_default_text',
   array(
      'default' => '',
      'transport' => 'refresh',
   )
);
 
$wp_customize->add_control( 'demo_default_text',
   array(
      'label' => __( '默认文本控件' ),
      'description' => esc_html__( '文本控件类型可以是文本、电子邮件、url、数字、隐藏或日期' ),
      'section' => 'demo_custom_controls_section',
      'type' => 'text', // Can be either text, email, url, number, hidden, or date
   )
);

}
;
add_action( 'customize_register', 'api_customize_register' );
?>