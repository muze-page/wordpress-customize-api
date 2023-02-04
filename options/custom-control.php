<?php
//自定义控件 - 基础


function api_separator( $wp_customize ) {

    $wp_customize->add_section( 'separator_section',
    array(
        'title' => __( '控件 - 自定义' ),
        'description' => esc_html__( '以下是自定义控件的示例。' ),
    )
);

//基础类



//布局选择控件
    	/**
	 * 单选按钮和选择消毒
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'skyrocket_radio_sanitization_a' ) ) {
		function skyrocket_radio_sanitization_a( $input, $setting ) {
			//获取可能的单选框列表或选择选项
		 $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}

class Skyrocket_Image_Radio_Button_Custom_Control_b extends WP_Customize_Control {

    
    /**
     * 正在呈现的控件类型
     */
    public $type = 'image_radio_button_a';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue() {
        //加载控件所需样式
       // wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
    }
    /**
     * 在自定义程序中渲染控件
     */
    public function render_content() {
    ?>
        <div class="image_radio_button_control">
            <?php if( !empty( $this->label ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>
            <?php if( !empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>

            <?php foreach ( $this->choices as $key => $value ) { ?>
                <label class="radio-button-label">
                    <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                    <img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
                    
                </label>
            <?php	} ?>
        </div>
        <style>
            /*控件所需样式*/
            /* ==========================================================================
   Image Radio Buttons
   ========================================================================== */
.image_radio_button_control .radio-button-label > input {
	display: none;
}

.image_radio_button_control .radio-button-label > img {
	cursor: pointer;
	border: 3px solid #ddd;
}

.image_radio_button_control .radio-button-label > input:checked + img {
	border: 3px solid #2885bb;
}

            </style>
    <?php
    }



}

$wp_customize->add_setting( 'sample_image_radio_button_a',
array(
    'transport' => 'refresh',
    'sanitize_callback' => 'skyrocket_radio_sanitization_a'
)
);
$wp_customize->add_control( new Skyrocket_Image_Radio_Button_Custom_Control_b( $wp_customize, 'sample_image_radio_button_a',
array(
    'label' => __( '图像单选按钮控件', 'skyrocket' ),
    'description' => esc_html__( '自定义控件说明示例', 'skyrocket' ),
    'section' => 'separator_section',
    'choices' => array(
        'sidebarleft' => array(
            'image' => plugin_dir_url( __DIR__ ) . 'public/images/sidebar-left.png',
            'name' => __( 'Left Sidebar', 'skyrocket' )
        ),
        'sidebarnone' => array(
            'image' => plugin_dir_url( __DIR__ ) . 'public/images/sidebar-none.png',
            'name' => __( 'No Sidebar', 'skyrocket' )
        ),
        'sidebarright' => array(
            'image' => plugin_dir_url( __DIR__ ) . 'public/images/sidebar-right.png',
            'name' => __( 'Right Sidebar', 'skyrocket' )
        )
    )
)
) );





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
						echo "<option " . selected( $this->value(), get_the_ID() ) . " value='' . get_the_ID() . ''>" . the_title( '', '', false ) . "</option>";
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



//多图片选择控件
	/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	消毒输入
	 */
	if ( ! function_exists( 'skyrocket_text_sanitization_d' ) ) {
		function skyrocket_text_sanitization_d( $input ) {
			if ( strpos( $input, ',' ) !== false) {
				$input = explode( ',', $input );
			}
			if( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[$key] = sanitize_text_field( $value );
				}
				$input = implode( ',', $input );
			}
			else {
				$input = sanitize_text_field( $input );
			}
			return $input;
		}
	}

	/**
	 * 图像复选框自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
    class Skyrocket_Image_Checkbox_Custom_Control_d extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'image_checkbox_dssd';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
            //wp_enqueue_script( 'skyrocket-custom-controls-js', plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="image_checkbox_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<?php	$chkboxValues = explode( ',', esc_attr( $this->value() ) ); ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-multi-image-checkbox" <?php $this->link(); ?> />
				<?php foreach ( $this->choices as $key => $value ) { ?>
					<label class="checkbox-label">
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( esc_attr( $key ), $chkboxValues ), 1 ); ?> class="multi-image-checkbox"/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
					</label>
				<?php	} ?>
			</div>
            <style>

/* ==========================================================================
   Image Checkboxes
   ========================================================================== */
.image_checkbox_control .checkbox-label > input {
	display: none;
}

.image_checkbox_control .checkbox-label > img {
	cursor: pointer;
	border: 3px solid #ddd;
}

.image_checkbox_control .checkbox-label > input:checked + img {
	border: 3px solid #2885bb;
}
                </style>
            <script>
                jQuery( document ).ready(function($) {
	"use strict";
                	/**
	 * Image Checkbox Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	$('.multi-image-checkbox').on('change', function () {
	  skyrocketGetAllImageCheckboxes($(this).parent().parent());
	});

	// Get the values from the checkboxes and add to our hidden field
	function skyrocketGetAllImageCheckboxes($element) {
	  var inputValues = $element.find('.multi-image-checkbox').map(function() {
	    if( $(this).is(':checked') ) {
	      return $(this).val();
	    }
	  }).toArray();
	  // Important! Make sure to trigger change event so Customizer knows it has to save the field
	  $element.find('.customize-control-multi-image-checkbox').val(inputValues).trigger('change');
	}

});
                </script>
		<?php
		}
	}

    		// Test of Image Checkbox Custom Control
		$wp_customize->add_setting( 'sample_image_checkbox_d',
        array(
            'default' => 'stylebold,styleallcaps',
            'transport' => 'refresh',
            //'sanitize_callback' => 'skyrocket_text_sanitization_d'
        )
    );
    $wp_customize->add_control( new Skyrocket_Image_checkbox_Custom_Control_d( $wp_customize, 'sample_image_checkbox_d',
        array(
            'label' => __( '图像复选框控件', 'skyrocket' ),
            'description' => esc_html__( '自定义控件说明示例', 'skyrocket' ),
            'section' => 'separator_section',
            'choices' => array(
                'stylebold' => array(
                    'image' => plugin_dir_url( __DIR__ ) . 'public/images/Bold.png',
                    'name' => __( 'Bold', 'skyrocket' )
                ),
                'styleitalic' => array(
                    'image' => plugin_dir_url( __DIR__ ) . 'public/images/Italic.png',
                    'name' => __( 'Italic', 'skyrocket' )
                ),
                'styleallcaps' => array(
                    'image' => plugin_dir_url( __DIR__ ) . 'public/images/AllCaps.png',
                    'name' => __( 'All Caps', 'skyrocket' )
                ),
                'styleunderline' => array(
                    'image' => plugin_dir_url( __DIR__ ) . 'public/images/Underline.png',
                    'name' => __( 'Underline', 'skyrocket' )
                )
            )
        )
    ) );



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