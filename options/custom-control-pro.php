<?php 
//高级自定义控件


function customize_register_pro( $wp_customize ) {

//添加部分

$wp_customize->add_section( 'section_pro',
   array(
      'title' => __( '高级自定义控件' ),
      'description' => esc_html__( '这里的控件有点难度哦' ),
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
      'section' => 'section_pro',
      'type' => 'text', // Can be either text, email, url, number, hidden, or date
   )
);

}
;
add_action( 'customize_register', 'customize_register_pro' );
?>