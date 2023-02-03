<?php
//自定义控件

//注册一个菜单
function api_separator( $wp_customize ) {
    // Add all your Customizer content ( i.e. Panels, Sections, Settings & Controls ) here...
    //在此处添加所有自定义器内容（即面板、节、设置和控件）。。。

    //添加面板


//添加部分
/**
 * Add our Sample Section
 */
$wp_customize->add_section( 'separator_section',
   array(
      'title' => __( '控件 - 自定义' ),
      'description' => esc_html__( '以下是自定义控件的示例。' ),
   )
);

//布局选择控件
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom layout control
 */
class Layout_Picker_Custom_Control extends WP_Customize_Control
{
      /**
       * Render the content on the theme customizer page
       */
      public function render_content()
       {
            ?>
                <label>
                  <span class="customize-layout-control"><?php echo esc_html( $this->label ); ?></span>
                  <ul>
                    <li><img src="http://magick.plugin/wp-content/uploads/2013/09/dsc20050604_133440_34211.jpg" alt="Full Width" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[full_width]" value="1" /></li>
                    <li><img src="/2cl.png" alt="Left Sidebar" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[left_sidebar]" value="1" /></li>
                    <li><img src="/2cr.png" alt="Right Sidebar" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[right_sidebar]" value="1" /></li>
                  </ul>
                </label>
            <?php
       }
}


$wp_customize->add_setting(
  'api_list_radio',
  array(
      'sanitize_callback' => 'wp_filter_nohtml_kses',
  )
);

$wp_customize->add_control( new Layout_Picker_Custom_Control( 
	$wp_customize, 
	'api_list_radio', 
	array(
		'label'	=> __( '选择一篇特色文章', 'themename' ),
		'section' => 'separator_section',
    'type' => 'radio'
	) 
));



//最新帖子下拉菜单（列出最新十篇文章控件）
if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Latest_Post_Control extends WP_Customize_Control {
		public $type = 'latest_post_dropdown';
 
		public function render_content() {

		$latest = new WP_Query( array(
			'post_type'   => 'post',
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
      'sanitize_callback' => 'wp_filter_nohtml_kses',
  )
);

$wp_customize->add_control( new WP_Customize_Latest_Post_Control( 
	$wp_customize, 
	'api_new_list_post', 
	array(
		'label'	=> __( '选择一篇特色文章', 'themename' ),
		'section' => 'separator_section',
    'post_type' => 'page'
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
             $wp_customize->add_setting( 'rjs_category_dropdown_radio', array(
                 'type'       => 'theme_mod',
                 'capability' => 'edit_theme_options',
                 'default' => 'uncategorized',
             ) );
         
             //Register the control
             $wp_customize->add_control( 'rjs_category_dropdown_radio', array(
                 'type' => 'radio',
                 'section' => 'separator_section',
                 'label' => __( '包含帖子数的分类下拉列表' ),
                 'description' => __( 'Description.' ),
                 'choices' => $rjs_choices_list_number, //Add the list with options
             ) );






 //自定义控件
 //https://developer.wordpress.org/themes/customize-api/customizer-objects/#custom-controls-sections-and-panels
 class WP_New_Menu_Customize_Control extends WP_Customize_Control {
   public $type = 'new_menu';
   /**
   * Render the control's content.
   */
   public function render_content() {
   ?>
     <button class="button button-primary" id="create-new-menu-submit" tabindex="0">111<?php _e( '自定义菜单' ); ?>222</button>
   <?php
   }
 }

 $wp_customize->add_setting(
   'cover_template_style',
   array(
       'sanitize_callback' => 'wp_filter_nohtml_kses',
   )
);

 $wp_customize->add_control(
   new WP_New_Menu_Customize_Control(
     $wp_customize, // WP_Customize_Manager
     'cover_template_style', // Setting id
     array( // Args, including any custom ones.
       'label' => __( 'Accent Color' ),
       'section' => 'separator_section',
     )
   )
 );




//添加追加销售控件





}
;
add_action( 'customize_register', 'api_separator' );





?>