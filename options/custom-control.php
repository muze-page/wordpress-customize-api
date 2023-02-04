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

//自定义带数字显示的滑块控件

	/**
	 * 仅允许某个最小值和最大值范围之间的值
	 *
	 * @param  number	Input to be sanitized
	 * @return number	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_in_range' ) ) {
		function skyrocket_in_range( $input, $min, $max ){
			if ( $input < $min ) {
				$input = $min;
			}
			if ( $input > $max ) {
				$input = $max;
			}
			return $input;
		}
	}

	/**
	 * 滑块净化
	 *
	 * @param  string	Slider value to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_range_sanitization_c' ) ) {
		function skyrocket_range_sanitization_c( $input, $setting ) {
			$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

			$min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
			$max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
			$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

			$number = floor( $input / $attrs['step'] ) * $attrs['step'];

			return skyrocket_in_range( $number, $min, $max );
		}
	}


	/**
	 * Slider Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Slider_Custom_Control_c extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'slider_control_c';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js', plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="slider-custom-control">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
				<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
			</div>
            
            <style>
                /* ==========================================================================
   Slider
   ========================================================================== */
.slider-custom-control {
	margin-bottom: 30px;
}

.slider-custom-control input[type=number]::-webkit-inner-spin-button,
.slider-custom-control input[type=number]::-webkit-outer-spin-button {
	-webkit-appearance: none;
	margin: 0;
}

.slider-custom-control input[type=number] {
	-moz-appearance: textfield;
}

.slider-custom-control  .customize-control-title {
	display: inline-block;
}

.slider-custom-control input[type=number] {
	text-align: right;
	width: 50px;
	float: right;
}

.slider-custom-control .slider {
	width: 85%;
	float: left;
	margin: 20px 0 10px;
}

.slider-custom-control .slider-reset {
	float: right;
	cursor: pointer;
}

.slider-custom-control .slider-value {
	border: none;
	text-align: right;
	width: 50px;
	margin-right: 5px;
}

.slider-custom-control .slider-value,
.slider-custom-control .slider-unit {
	float: right;
}

.slider-custom-control .ui-widget.ui-widget-content {
	border: 1px solid #f4f4f4;
}

.slider-custom-control .ui-corner-all,
.slider-custom-control .ui-corner-bottom,
.slider-custom-control .ui-corner-right,
.slider-custom-control .ui-corner-br {
	border-bottom-right-radius: 3px;
}

.slider-custom-control .ui-corner-all,
.slider-custom-control .ui-corner-bottom,
.slider-custom-control .ui-corner-left,
.slider-custom-control .ui-corner-bl {
	border-bottom-left-radius: 3px;
}

.slider-custom-control .ui-corner-all,
.slider-custom-control .ui-corner-top,
.slider-custom-control .ui-corner-right,
.slider-custom-control .ui-corner-tr {
	border-top-right-radius: 3px;
}

.slider-custom-control .ui-corner-all,
.slider-custom-control .ui-corner-top,
.slider-custom-control .ui-corner-left,
.slider-custom-control .ui-corner-tl {
	border-top-left-radius: 3px;
}

.slider-custom-control .ui-widget-content {
	background: #f4f4f4 none repeat scroll 0 0;
	color: #333;
}

.slider-custom-control .ui-slider-horizontal {
	height: 3px;
}

.slider-custom-control .ui-slider {
	position: relative;
	text-align: left;
}

.slider-custom-control .ui-state-default,
.slider-custom-control .ui-widget-content .ui-state-default,
.slider-custom-control .ui-widget-header .ui-state-default,
.slider-custom-control .ui-button,
.slider-custom-control .ui-button.ui-state-disabled:hover,
.slider-custom-control .ui-button.ui-state-disabled:active {
	background: #2885bb none repeat scroll 0 0;
	border: 1px solid #2885bb;
	color: #454545;
	font-weight: normal;
}

.slider-custom-control .ui-slider-horizontal .ui-slider-handle {
	margin-left: -7px;
	top: -7px;
	border-radius: 50%;
}

.slider-custom-control .ui-slider .ui-slider-handle {
	cursor: pointer;
	height: 14px;
	position: absolute;
	width: 14px;
	z-index: 2;
}

.slider-custom-control .dashicons-image-rotate {
	margin-top: 10px;
	color: #d4d4d4;
	size: 16px;
}

.slider-custom-control .dashicons-image-rotate:hover {
	color: #a7a7a7;
}
                </style>
                <script>
                    jQuery( document ).ready(function($) {
	"use strict";
	/**
	 * Slider Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	// 设置滑块默认值并初始化滑块
	$('.slider-custom-control').each(function(){
		var sliderValue = $(this).find('.customize-control-slider-value').val();
		var newSlider = $(this).find('.slider');
		var sliderMinValue = parseFloat(newSlider.attr('slider-min-value'));
		var sliderMaxValue = parseFloat(newSlider.attr('slider-max-value'));
		var sliderStepValue = parseFloat(newSlider.attr('slider-step-value'));

		newSlider.slider({
			value: sliderValue,
			min: sliderMinValue,
			max: sliderMaxValue,
			step: sliderStepValue,
			change: function(e,ui){
				// Important! When slider stops moving make sure to trigger change event so Customizer knows it has to save the field
				$(this).parent().find('.customize-control-slider-value').trigger('change');
	      }
		});
	});

	// 移动滑块时更改输入字段的值
	$('.slider').on('slide', function(event, ui) {
		$(this).parent().find('.customize-control-slider-value').val(ui.value);
	});

	// 将滑块和输入字段重置为默认值
	$('.slider-reset').on('click', function() {
		var resetValue = $(this).attr('slider-reset-value');
		$(this).parent().find('.customize-control-slider-value').val(resetValue);
		$(this).parent().find('.slider').slider('value', resetValue);
	});

	// 如果输入字段很可能已更改而失去焦点，则更新滑块
	$('.customize-control-slider-value').blur(function() {
		var resetValue = $(this).val();
		var slider = $(this).parent().find('.slider');
		var sliderMinValue = parseInt(slider.attr('slider-min-value'));
		var sliderMaxValue = parseInt(slider.attr('slider-max-value'));

		// Make sure our manual input value doesn't exceed the minimum & maxmium values
		if(resetValue < sliderMinValue) {
			resetValue = sliderMinValue;
			$(this).val(resetValue);
		}
		if(resetValue > sliderMaxValue) {
			resetValue = sliderMaxValue;
			$(this).val(resetValue);
		}
		$(this).parent().find('.slider').slider('value', resetValue);
	});

});
                    </script>
                    
		<?php
		}
	}


  		// Test of Slider Custom Control
          $wp_customize->add_setting( 'sample_slider_control_c',
          array(
            'default' => '20',
              'transport' => 'postMessage',
              'sanitize_callback' => 'absint'
          )
      );
      $wp_customize->add_control( new Skyrocket_Slider_Custom_Control_c( $wp_customize, 'sample_slider_control_c',
          array(
              'label' => __( '滑块控件（像素）', 'skyrocket' ),
              'section' => 'separator_section',
              'input_attrs' => array(
                  'min' => 10,
                  'max' => 90,
                  'step' => 1,
              ),
          )
      ) );  

      //小数点的滑块
      		// Another Test of Slider Custom Control
		$wp_customize->add_setting( 'sample_slider_control_small_step_c',
        array(
            'default' => '1.5',
            'transport' => 'refresh',
            //'sanitize_callback' => 'skyrocket_range_sanitization_c'
        )
    );
    $wp_customize->add_control( new Skyrocket_Slider_Custom_Control_c( $wp_customize, 'sample_slider_control_small_step_c',
        array(
            'label' => __( '具有小步长的滑块控件', 'skyrocket' ),
            'section' => 'separator_section',
            'input_attrs' => array(
                'min' => 0,
                'max' => 4,
                'step' => .5,
            ),
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