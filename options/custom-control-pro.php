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

//按钮控件
	/**
	 * Switch sanitization
	 *
	 * @param  string		Switch value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'skyrocket_switch_sanitization_a' ) ) {
		function skyrocket_switch_sanitization_a( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Toggle Switch Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Toggle_Switch_Custom_control_a extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'toggle_switch_a';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue(){
			//wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content(){
		?>
			<div class="toggle-switch-control">
				<div class="toggle-switch">
					<input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
					<label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
						<span class="toggle-switch-inner"></span>
						<span class="toggle-switch-switch"></span>
					</label>
				</div>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
         <style>
            /* ==========================================================================
   Toggle Switch
   ========================================================================== */
.toggle-switch-control .customize-control-title {
	display: inline-block;
}

.toggle-switch {
	position: relative;
	width: 64px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	float: right;
}

.toggle-switch .toggle-switch-checkbox {
	display: none;
}

.toggle-switch .toggle-switch-label {
	display: block;
	overflow: hidden;
	cursor: pointer;
	border: 2px solid #ddd;
	border-radius: 20px;
	padding: 0;
	margin: 0;
}

.toggle-switch-inner {
	display: block;
	width: 200%;
	margin-left: -100%;
	transition: margin 0.3s ease-in 0s;
}

.toggle-switch-inner:before,
.toggle-switch-inner:after {
	display: block;
	float: left;
	width: 50%;
	height: 22px;
	padding: 0;
	line-height: 22px;
	font-size: 14px;
	color: white;
	font-family: Trebuchet, Arial, sans-serif;
	font-weight: bold;
	box-sizing: border-box;
}

.toggle-switch-inner:before {
	content: "开";
	padding-left: 8px;
	background-color: #2885bb;
	color: #FFFFFF;
}

.toggle-switch-inner:after {
	content: "关";
	padding-right: 8px;
	background-color: #eeeeee;
	color: #999999;
	text-align: right;
}

.toggle-switch-switch {
	display: block;
	width: 16px;
	margin: 3px;
	background-color: #ffffff;
	position: absolute;
	top: 0;
	bottom: 0;
	right: 38px;
	border: 2px solid #ddd;
	border-radius: 20px;
	transition: all 0.3s ease-in 0s;
}

.toggle-switch-checkbox:checked + .toggle-switch-label .toggle-switch-inner {
	margin-left: 0;
}

.toggle-switch-checkbox:checked + .toggle-switch-label .toggle-switch-switch {
	right: 0px;
}
            </style>
		<?php
		}
	}

   		// Test of Toggle Switch Custom Control
		$wp_customize->add_setting( 'sample_toggle_switch_a',
      array(
         'default' =>0,
         'transport' => 'refresh',
         'sanitize_callback' => 'skyrocket_switch_sanitization_a'
      )
   );
   $wp_customize->add_control( new Skyrocket_Toggle_Switch_Custom_control_a( $wp_customize, 'sample_toggle_switch_a',
      array(
         'label' => __( '拨动开关', 'skyrocket' ),
         'description' => esc_html__( '自定义拨动开关', 'skyrocket' ),
         'section' => 'section_pro'
      )
   ) );


   

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
              'section' => 'section_pro',
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
            'section' => 'section_pro',
            'input_attrs' => array(
                'min' => 0,
                'max' => 4,
                'step' => .5,
            ),
        )
    ) );



    //可排序中继器


	/**
	 * URL sanitization
	 *
	 * @param  string	要清理的输入（包含单个url或多个url的字符串，用逗号分隔）
	 * @return string	消毒输入
	 */
	if ( ! function_exists( 'skyrocket_url_sanitization_a' ) ) {
		function skyrocket_url_sanitization_a( $input ) {
			if ( strpos( $input, ',' ) !== false) {
				$input = explode( ',', $input );
			}
			if ( is_array( $input ) ) {
				foreach ($input as $key => $value) {
					$input[$key] = esc_url_raw( $value );
				}
				$input = implode( ',', $input );
			}
			else {
				$input = esc_url_raw( $input );
			}
			return $input;
		}
	}

   	/**
	 * Sortable Repeater Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Sortable_Repeater_Custom_Control_c extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'sortable_repeater_c';
		/**
		 * Button labels
		 */
		public $button_labels = array();
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Merge the passed button labels with our default labels
			$this->button_labels = wp_parse_args( $this->button_labels,
				array(
					'add' => __( 'Add', 'skyrocket' ),
				)
			);
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizers.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
		  <div class="sortable_repeater_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
				<div class="sortable_repeater sortable">
					<div class="repeater">
						<input type="text" value="" class="repeater-input" placeholder="https://" /><span class="dashicons dashicons-sort"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a>
					</div>
				</div>
				<button class="button customize-control-sortable-repeater-add" type="button"><?php echo $this->button_labels['add']; ?></button>
			</div>
         <style>
            /* ==========================================================================
   可排序中继器
   ========================================================================== */
.sortable {
	list-style-type: none;
	margin: 0;
	padding: 0;
}

.sortable input[type="text"] {
	margin: 5px 5px 5px 0;
	width: 80%;
}

.sortable div {
	cursor: move;
}

.customize-control-sortable-repeater-delete {
	color: #d4d4d4;
}

.customize-control-sortable-repeater-delete:hover {
	color: #f00;
}

.customize-control-sortable-repeater-delete .dashicons-no-alt {
	text-decoration: none;
	margin: 8px 0 0 0;
	font-weight: 600;
}

.customize-control-sortable-repeater-delete:active,
.customize-control-sortable-repeater-delete:focus {
	outline: none;
	-webkit-box-shadow: none;
	box-shadow: none;
}

.repeater .dashicons-sort {
	margin: 8px 5px 0 5px;
	color: #d4d4d4;
}

.repeater .dashicons-sort:hover {
	color: #a7a7a7;
}
            </style>
            <script>
 
 jQuery(document).ready(function ($) {
	"use strict";

	/**
	 * 可排序中继器自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	// 更新所有输入字段的值并初始化可排序中继器
	$('.sortable_repeater_control').each(function () {
		// If there is an existing customizer value, populate our rows
		var defaultValuesArray = $(this).find('.customize-control-sortable-repeater').val().split(',');
		var numRepeaterItems = defaultValuesArray.length;

		if (numRepeaterItems > 0) {
			// Add the first item to our existing input field
			$(this).find('.repeater-input').val(defaultValuesArray[0]);
			// Create a new row for each new value
			if (numRepeaterItems > 1) {
				var i;
				for (i = 1; i < numRepeaterItems; ++i) {
					skyrocketAppendRow($(this), defaultValuesArray[i]);
				}
			}
		}
	});

	// Make our Repeater fields sortable
	$(this).find('.sortable_repeater.sortable').sortable({
		update: function (event, ui) {
			skyrocketGetAllInputs($(this).parent());
		}
	});

	// Remove item starting from it's parent element
	$('.sortable_repeater.sortable').on('click', '.customize-control-sortable-repeater-delete', function (event) {
		event.preventDefault();
		var numItems = $(this).parent().parent().find('.repeater').length;

		if (numItems > 1) {
			$(this).parent().slideUp('fast', function () {
				var parentContainer = $(this).parent().parent();
				$(this).remove();
				skyrocketGetAllInputs(parentContainer);
			})
		}
		else {
			$(this).parent().find('.repeater-input').val('');
			skyrocketGetAllInputs($(this).parent().parent().parent());
		}
	});

	// Add new item
	$('.customize-control-sortable-repeater-add').click(function (event) {
		event.preventDefault();
		skyrocketAppendRow($(this).parent());
		skyrocketGetAllInputs($(this).parent());
	});

	// Refresh our hidden field if any fields change
	$('.sortable_repeater.sortable').change(function () {
		skyrocketGetAllInputs($(this).parent());
	})

	// Add https:// to the start of the URL if it doesn't have it
	$('.sortable_repeater.sortable').on('blur', '.repeater-input', function () {
		var url = $(this);
		var val = url.val();
		if (val && !val.match(/^.+:\/\/.*/)) {
			// Important! Make sure to trigger change event so Customizer knows it has to save the field
			url.val('https://' + val).trigger('change');
		}
	});

	// 将新行附加到元素列表
	function skyrocketAppendRow($element, defaultValue = '') {
		var newRow = '<div class="repeater" style="display:none"><input type="text" value="' + defaultValue + '" class="repeater-input" placeholder="https://" /><span class="dashicons dashicons-sort"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a></div>';

		$element.find('.sortable').append(newRow);
		$element.find('.sortable').find('.repeater:last').slideDown('slow', function () {
			$(this).find('input').focus();
		});
	}

	// 从中继器输入字段获取值并添加到隐藏字段
	function skyrocketGetAllInputs($element) {
		var inputValues = $element.find('.repeater-input').map(function () {
			return $(this).val();
		}).toArray();
		// Add all the values from our repeater fields to the hidden field (which is the one that actually gets saved)
		$element.find('.customize-control-sortable-repeater').val(inputValues);
		// Important! Make sure to trigger change event so Customizer knows it has to save the field
		$element.find('.customize-control-sortable-repeater').trigger('change');
	}





});



               </script>
		<?php
		}
	}




    		// 为社交媒体URL添加我们的可排序中继器设置和自定义控件
		$wp_customize->add_setting( 'sample_sortable_repeater_control_c',
      array(
         'default' => '',
         'transport' => 'refresh',
         'sanitize_callback' => 'skyrocket_url_sanitization_a'
      )
   );
   $wp_customize->add_control( new Skyrocket_Sortable_Repeater_Custom_Control_c( $wp_customize, 'sample_sortable_repeater_control_c',
      array(
         'label' => __( '可排序中继器', 'skyrocket' ),
         'description' => esc_html__( '这是控制说明.', 'skyrocket' ),
         'section' => 'section_pro',
         'button_labels' => array(
            'add' => __( 'Add Row', 'skyrocket' ),
         )
      )
   ) );


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
    'section' => 'section_pro',
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





   /**
    * WP_Customize_Control
	*		wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
	*		wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );

   */

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