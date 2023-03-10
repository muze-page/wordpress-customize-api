<?php
//自定义控件 - 基础


function api_separator( $wp_customize ) {

    $wp_customize->add_section( 'separator_section',
    array(
        'title' => __( '基础自定义控件' ),
        'description' => esc_html__( '以下是自定义控件的示例。' ),
    )
);


//最新帖子下拉菜单（列出最新十篇文章控件）
if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Latest_Post_Control extends WP_Customize_Control {
		public $type = 'latest_post_dropdown';
		public $post_type = 'post';
 
		public function render_content() {

		$latest = new WP_Query( array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
			'orderby'     => 'date',
			'order'       => 'DESC'
		));

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?>>
					<?php 
					while( $latest->have_posts() ) {
						$latest->the_post();
						echo "<option " . selected( $this->value(), get_the_ID() ) . " value='" . get_the_ID() . "'>" . the_title( '', '', false ) . "</option>";
					}
					?>
				</select>
			</label>
		<?php
		}
	}
endif;

$wp_customize->add_setting(
  'api_new_list_post',
  array(
    'default' => '1',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
  )
);

$wp_customize->add_control( new WP_Customize_Latest_Post_Control( 
	$wp_customize, 
	'api_new_list_post', 
	array(
		'label'	=> __( '选择一篇特色文章', 'themename' ),
		'section' => 'separator_section',
        //'post_type' => 'page'//页面
        'post_type' => 'post'//文章
        
	) 
));






//添加自定义分隔符控件


/*************************************************************************/
//分隔符控件
//代码来自2020主题
//themes/twentytwenty/classes/class-twentytwenty-separator-control.php
//themes/twentytwenty/classes/class-twentytwenty-customize.php - 325行



    class TwentyTwenty_Separator_Controlss extends WP_Customize_Control {

        public function render_content() {
            echo '<hr/><br />我是分隔符控件';
        }

    }
   



$wp_customize->add_setting(
    'cover_template_separator_1s',
    array(
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    )
);

$wp_customize->add_control(
    new TwentyTwenty_Separator_Controlss(
        $wp_customize,
        'cover_template_separator_1s',
        array(
            'section' => 'separator_section',
        )
    )
);




//添加自定义滑块控件
//https://developer.wordpress.org/themes/customize-api/customizer-objects/#controls
$wp_customize->add_setting(
   'cover_template_range',
   array(
       'sanitize_callback' => 'wp_filter_nohtml_kses',
   )
);

$wp_customize->add_control( 'cover_template_range',
   array(
      'label' => __( '滑块控件' ),
      'description' => esc_html__( '一个简单的滑块控件' ),
      'section' => 'separator_section',
      'type' => 'range', // Can be either text, email, url, number, hidden, or date
      'input_attrs' => array(
         'min' => 0,
         'max' => 10,
         'step' => 2,
       ),
   )
);




 //添加图片
 $wp_customize->add_setting( 'sample_default_media_image',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'absint'
   )
);
 
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'sample_default_media_image',
   array(
      'label' => __( '默认图片媒体控件' ),
      'description' => esc_html__( '这是媒体控件的说明' ),
      'section' => 'separator_section',
      'mime_type' => 'image',  // Required. Can be image, audio, video, application, text
      'button_labels' => array( // Optional
         'select' => __( '选择图片' ),
         'change' => __( '重选图片' ),
         'default' => __( 'Default' ),
         'remove' => __( '移除' ),
         'placeholder' => __( '未选择图片' ),
         'frame_title' => __( '选择图片' ),
         'frame_button' => __( 'Choose File' ),
      )
   )
) );   
//添加音频控件
$wp_customize->add_setting(
   'cover_template_audio',
   array(
       'sanitize_callback' => 'wp_filter_nohtml_kses',
   )
);
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'cover_template_audio', array(
   'label' => __( '选择您需要的音频' ),
   'description' => esc_html__( '可以是一首动听的音乐' ),
   'section' => 'separator_section',
   'mime_type' => 'audio',
   'button_labels' => array( // Optional.
      'select' => __( '选择音频' ),
      'change' => __( '重选' ),
      'remove' => __( 'Remove' ),
      'default' => __( 'Default' ),
      'placeholder' => __( '没有选择音频' ),
      'frame_title' => __( '选择音频' ),
      'frame_button' => __( '挑选音频' ),
   )
 ) ) );


 //添加视频控件
$wp_customize->add_setting(
   'cover_template_video',
   array(
       'sanitize_callback' => 'wp_filter_nohtml_kses',
   )
);
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'cover_template_video', array(
   'label' => __( '选择您需要视频' ),
   'description' => esc_html__( '可以是一部感人的视频' ),
   'section' => 'separator_section',
   'mime_type' => 'video',
   'button_labels' => array( // Optional.
      'select' => __( '选择视频' ),
      'change' => __( '重选' ),
      'remove' => __( 'Remove' ),
      'default' => __( 'Default' ),
      'placeholder' => __( '没有选择视频' ),
      'frame_title' => __( '选择视频' ),
      'frame_button' => __( '挑选视频' ),
   )
 ) ) );



 //自定义分类列表
 //Get an array with the category list
 $rjs_categories_full_list = get_categories( array( 'orderby' => 'name', ) );

 //Create an empty array
 $rjs_choices_list = [];

 //Loop through the array and add the correct values every time
 foreach ( $rjs_categories_full_list as $rjs_single_cat ) {
     $rjs_choices_list[ $rjs_single_cat->slug ] = esc_html__( $rjs_single_cat->name, 'text-domain' );
 }

 //Register the setting
 $wp_customize->add_setting( 'rjs_category_dropdown', array(
     'type'       => 'theme_mod',
     'capability' => 'edit_theme_options',
     'default' => 'uncategorized',
 ) );

 //Register the control
 $wp_customize->add_control( 'rjs_category_dropdown', array(
     'type' => 'select',
     'section' => 'separator_section',
     'label' => __( '选择类别' ),
     'description' => __( 'Description.' ),
     'choices' => $rjs_choices_list, //Add the list with options
 ) );


 //包含帖子数的分类下拉列表
 $rjs_choices_list_number = [];
 foreach( $rjs_categories_full_list as $rjs_single_cat ) {
     $rjs_category_name = $rjs_single_cat->name;         //Retrieve the name
     $rjs_category_post_count = $rjs_single_cat->count;     //Retrieve the count
  
     $rjs_choices_list_number[$rjs_single_cat->slug] = esc_html__( "{$rjs_category_name} ({$rjs_category_post_count})", 'text-domain' );
  
     //Note: don't forget the double quotes when concatenating the name, otherwise it will not work.
        }

        //Register the setting
        $wp_customize->add_setting( 'rjs_category_dropdown_number', array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => 'uncategorized',
        ) );

        //Register the control
        $wp_customize->add_control( 'rjs_category_dropdown_number', array(
            'type' => 'select',
            'section' => 'separator_section',
            'label' => __( '包含帖子数的分类下拉列表' ),
            'description' => __( 'Description.' ),
            'choices' => $rjs_choices_list_number, //Add the list with options
        ) );

        //单选按钮
        //Register the setting
//        $wp_customize->add_setting( 'rjs_category_dropdown_radio', array(
//            'type'       => 'theme_mod',
//            'capability' => 'edit_theme_options',
//            'default' => 'uncategorized',
//        ) );
//
//        //Register the control
//        $wp_customize->add_control( 'rjs_category_dropdown_radio', array(
//            'type' => 'radio',
//            'section' => 'separator_section',
//            'label' => __( '包含帖子数的分类下拉列表' ),
//            'description' => __( 'Description.' ),
//            'choices' => $rjs_choices_list_number, //Add the list with options
//        ) );

        //自定义按钮控件
        //https://developer.wordpress.org/themes/customize-api/customizer-objects/#custom-controls-sections-and-panels

        class WP_New_Menu_Customize_Control extends WP_Customize_Control {
            public $type = 'new_menu';
            /**
            * 渲染控件的内容。
   */
   public function render_content() {
   ?>
   <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
     <button class="button button-primary" id="create-new-menu-submit"><?php _e( '自定义菜单' ); ?></button>
  <script>
    var btn = document.getElementById("create-new-menu-submit");

    btn.onclick = function () {
      alert("这就是点击事件~");
    };
  </script>

   <?php
   }
 }

 $wp_customize->add_setting('cover_template_style',
   array(
       'sanitize_callback' => 'wp_filter_nohtml_kses',
   )
);

 $wp_customize->add_control(new WP_New_Menu_Customize_Control(
     $wp_customize, // WP_Customize_Manager
     'cover_template_style', // Setting id
     array( // 参数，包括任何自定义参数。
       'label' => __( '单击有弹窗' ),
       'section' => 'separator_section',
     )
   )
 );


//自定义控件，范围滑块
if( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Range extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min' => 0,
                'max' => 10,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
        }

		public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
            <input onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() )" type='text' value='<?php echo esc_attr( $this->value() ); ?>'>

		</label>
        
        <script>
        ( function( $ ) {
            wp.customize( 'cd_photocount', function( value ) {
	value.bind( function( newval ) {
		$( '#photocount span' ).html( newval );
	} );
} );

} )( jQuery );
            </script>
		<?php
		}
	}
}



$wp_customize->add_setting( 'cd_photocount' , array(
    'default'     => 0,
    'transport'   => 'postMessage',
) );

$wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'cd_photocount', array(
	'label'	=>  '自定义范围滑动',
    'min' => 10,
    'max' => 9999,
    'step' => 10,//步长
	'section' => 'separator_section',
) ) );



//添加文章选择控件
 //获取包含文章列表的数组
 $list_one = get_posts();//文章

 //添加空数组
 $list_two = [];

 //循环遍历数组并每次添加正确的值
 foreach ( $list_one as $list_three ) {
    $list_two[ $list_three->ID ] = esc_html__( $list_three->post_title, 'text-domain' );
 }

 //Register the setting
 $wp_customize->add_setting( 'list_content', array(
     'type'       => 'theme_mod',
     'capability' => 'edit_theme_options',
     'default' => '',
 ) );

 //Register the control
 $wp_customize->add_control( 'list_content', array(
     'type' => 'select',
     'section' => 'separator_section',
     'label' => __( '选择文章' ),
     'description' => __( 'Description.' ),
     'choices' => $list_two, //添加带有选项的列表
 ) );

 function ppps( $data ) {
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
}
//echo ppps($list_one);






}
;
add_action( 'customize_register', 'api_separator' );




            ?>