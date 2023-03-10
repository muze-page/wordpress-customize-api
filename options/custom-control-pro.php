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


//文本单选按钮控件

	/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'skyrocket_radio_sanitization_c' ) ) {
		function skyrocket_radio_sanitization_c( $input, $setting ) {
			//get the list of possible radio box or select options
		 $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}


   	/**
	 * Text Radio Button Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	 class Skyrocket_Text_Radio_Button_Custom_Control_e extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'text_radio_button_e';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="text_radio_button_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<div class="radio-buttons">
					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label">
							<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
							<span><?php echo esc_attr( $value ); ?></span>
						</label>
					<?php	} ?>
				</div>
			</div>
         <style>
/* ==========================================================================
   Text Radio Buttons
   ========================================================================== */
   .text_radio_button_control:after {
	content: " ";
	display: block;
	clear: both;
}

.text_radio_button_control .radio-buttons {
	display: inline-block;
	border: 1px solid #f9f9fe;
}

.text_radio_button_control .radio-button-label {
	cursor: pointer;
	float: left;
}

.text_radio_button_control .radio-button-label > input {
	display: none;
}

.text_radio_button_control .radio-button-label span {
	cursor: pointer;
	font-weight: 500;
	border: 2px solid #f9f9fe;
	margin: 0;
	background-color: #eee;
	padding: 5px 15px;
	display: inline-block;
}

.text_radio_button_control .radio-button-label span:hover {
	background-color: rgba(255, 255, 255, .2);
	color: #2885bb;
}

.text_radio_button_control .radio-button-label > input:checked + span {
	background-color: #2084bd;
	color: #fff;
}

.text_radio_button_control .radio-button-label > input:checked + span:hover {
	color: #fff;
}
            </style>
		<?php
		}
	}


		//文本单选按钮自定义控件测试
		$wp_customize->add_setting( 'sample_text_radio_button_e',
			array(
				'default' =>'right',
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_radio_sanitization_c'
			)
		);
		$wp_customize->add_control( new Skyrocket_Text_Radio_Button_Custom_Control_e( $wp_customize, 'sample_text_radio_button_e',
			array(
				'label' => __( '文本单选按钮控件', 'skyrocket' ),
				'description' => esc_html__( '自定义控件说明示例', 'skyrocket' ),
				'section' => 'section_pro',
				'choices' => array(
					'left' => __( 'Left', 'skyrocket' ),
					'centered' => __( 'Centered', 'skyrocket' ),
					'right' => __( 'Right', 'skyrocket'  )
				)
			)
		) );

//图像复选框自定义控件
	/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	Sanitized input
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
	 * 
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
            'sanitize_callback' => 'skyrocket_text_sanitization_d'
        )
    );
    $wp_customize->add_control( new Skyrocket_Image_checkbox_Custom_Control_d( $wp_customize, 'sample_image_checkbox_d',
        array(
            'label' => __( '图像复选框控件', 'skyrocket' ),
            'description' => esc_html__( '自定义控件说明示例', 'skyrocket' ),
            'section' => 'section_pro',
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


    //单手风琴控件
    	/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_text_sanitization_f' ) ) {
		function skyrocket_text_sanitization_f( $input ) {
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
	 * Single Accordion Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Single_Accordion_Custom_Control_f extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'single_accordion_f';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'i' => array(
					'class' => array()
				),
			);
		?>
			<div class="single-accordion-custom-control">
				<div class="single-accordion-toggle"><?php echo esc_html( $this->label ); ?><span class="accordion-icon-toggle dashicons dashicons-plus"></span></div>
				<div class="single-accordion customize-control-description">
					<?php
						if ( is_array( $this->description ) ) {
							echo '<ul class="single-accordion-description">';
							foreach ( $this->description as $key => $value ) {
								echo '<li>' . $key . wp_kses( $value, $allowed_html ) . '</li>';
							}
							echo '</ul>';
						}
						else {
							echo wp_kses( $this->description, $allowed_html );
						}
				  ?>
				</div>
			</div>
         <style>
            /* ==========================================================================
   单手风琴
   ========================================================================== */
.single-accordion-toggle {
	font-size: 14px;
	font-weight: 600;
	line-height: 24px;
	padding: 10px 5px 5px 0;
	cursor: pointer;
}

.accordion-icon-toggle {
	font-size: 18px;
	margin-left: 5px;
	margin-top: 5px;
	-webkit-transition: -webkit-transform 0.3s ease-in-out;
	-moz-transition: -moz-transform 0.3s ease-in-out;
	-o-transition: -o-transform 0.3s ease-in-out;
	transition: transform 0.3s ease-in-out;
}

.single-accordion-toggle-rotate .accordion-icon-toggle {
	filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=-0.5);
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	transform: rotate(-45deg);
	display: inline-block;
}

.single-accordion {
	display: none;
}

.single-accordion ul {
	margin: 0;
	padding: 0;
}

.single-accordion li {
	background-color: #e4e4e4;
	color: #888;
	width: 115px;
	display: inline-block;
	padding: 5px;
	margin: 5px;
	text-align: center;
}

.single-accordion li i {
	margin-left: 5px;
}
            </style>
            <script>
               jQuery( document ).ready(function($) {
	"use strict";
               /**
	 * 单手风琴自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	$('.single-accordion-toggle').click(function() {
		var $accordionToggle = $(this);
		$(this).parent().find('.single-accordion').slideToggle('slow', function() {
			$accordionToggle.toggleClass('single-accordion-toggle-rotate', $(this).is(':visible'));
		});
	});
});
               </script>
		<?php
		}
	}

    		// 单手风琴控制测试
		$sampleIconsList = array(
			'Behance' => __( '<i class="fab fa-behance"></i>', 'skyrocket' ),
			'Bitbucket' => __( '<i class="fab fa-bitbucket"></i>', 'skyrocket' ),
			'CodePen' => __( '<i class="fab fa-codepen"></i>', 'skyrocket' ),
			'DeviantArt' => __( '<i class="fab fa-deviantart"></i>', 'skyrocket' ),
			'Discord' => __( '<i class="fab fa-discord"></i>', 'skyrocket' ),
			'Dribbble' => __( '<i class="fab fa-dribbble"></i>', 'skyrocket' ),
			'Etsy' => __( '<i class="fab fa-etsy"></i>', 'skyrocket' ),
			'Facebook' => __( '<i class="fab fa-facebook-f"></i>', 'skyrocket' ),
			'Flickr' => __( '<i class="fab fa-flickr"></i>', 'skyrocket' ),
			'Foursquare' => __( '<i class="fab fa-foursquare"></i>', 'skyrocket' ),
			'GitHub' => __( '<i class="fab fa-github"></i>', 'skyrocket' ),
			'Google+' => __( '<i class="fab fa-google-plus-g"></i>', 'skyrocket' ),
			'Instagram' => __( '<i class="fab fa-instagram"></i>', 'skyrocket' ),
			'Kickstarter' => __( '<i class="fab fa-kickstarter-k"></i>', 'skyrocket' ),
			'Last.fm' => __( '<i class="fab fa-lastfm"></i>', 'skyrocket' ),
			'LinkedIn' => __( '<i class="fab fa-linkedin-in"></i>', 'skyrocket' ),
			'Medium' => __( '<i class="fab fa-medium-m"></i>', 'skyrocket' ),
			'Patreon' => __( '<i class="fab fa-patreon"></i>', 'skyrocket' ),
			'Pinterest' => __( '<i class="fab fa-pinterest-p"></i>', 'skyrocket' ),
			'Reddit' => __( '<i class="fab fa-reddit-alien"></i>', 'skyrocket' ),
			'Slack' => __( '<i class="fab fa-slack-hash"></i>', 'skyrocket' ),
			'SlideShare' => __( '<i class="fab fa-slideshare"></i>', 'skyrocket' ),
			'Snapchat' => __( '<i class="fab fa-snapchat-ghost"></i>', 'skyrocket' ),
			'SoundCloud' => __( '<i class="fab fa-soundcloud"></i>', 'skyrocket' ),
			'Spotify' => __( '<i class="fab fa-spotify"></i>', 'skyrocket' ),
			'Stack Overflow' => __( '<i class="fab fa-stack-overflow"></i>', 'skyrocket' ),
			'Tumblr' => __( '<i class="fab fa-tumblr"></i>', 'skyrocket' ),
			'Twitch' => __( '<i class="fab fa-twitch"></i>', 'skyrocket' ),
			'Twitter' => __( '<i class="fab fa-twitter"></i>', 'skyrocket' ),
			'Vimeo' => __( '<i class="fab fa-vimeo-v"></i>', 'skyrocket' ),
			'Weibo' => __( '<i class="fab fa-weibo"></i>', 'skyrocket' ),
			'YouTube' => __( '<i class="fab fa-youtube"></i>', 'skyrocket' ),
		);
		$wp_customize->add_setting( 'sample_single_accordion_f',
			array(
				'default' => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_text_sanitization_f'
			)
		);
		$wp_customize->add_control( new Skyrocket_Single_Accordion_Custom_Control_f( $wp_customize, 'sample_single_accordion_f',
			array(
				'label' => __( '单手风琴控制', 'skyrocket' ),
				'description' => $sampleIconsList,
				'section' => 'section_pro'
			)
		) );


      //简单通知自定义控件

      	/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_text_sanitization_a' ) ) {
		function skyrocket_text_sanitization_a( $input ) {
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
	 * 简单的自定义通知控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Simple_Notice_Custom_Control_a extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'simple_notice_a';
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'i' => array(
					'class' => array()
				),
				'span' => array(
					'class' => array(),
				),
				'code' => array(),
			);
		?>
			<div class="simple-notice-custom-control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>
			</div>
		<?php
		}
	}


      		// Test of Simple Notice control
		$wp_customize->add_setting( 'sample_simple_notice_a',
      array(
         'default' => '',
         'transport' => 'postMessage',
         'sanitize_callback' => 'skyrocket_text_sanitization_a'
      )
   );
   $wp_customize->add_control( new Skyrocket_Simple_Notice_Custom_control_a( $wp_customize, 'sample_simple_notice_a',
      array(
         'label' => __( '一个简单有趣的通知', 'skyrocket' ),
         'description' => __( '此自定义控件允许您向用户显示简单的标题和描述. You can even include <a href="http://google.com" target="_blank">basic html</a>.', 'skyrocket' ),
         'section' => 'section_pro'
      )
   ) );


      //Alpha颜色选择器控件

      	/**
	 * 阿尔法颜色（十六进制和RGBa）消毒
	 *
	 * @param  string	Input to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_hex_rgba_sanitization_f' ) ) {
		function skyrocket_hex_rgba_sanitization_f( $input, $setting ) {
			if ( empty( $input ) || is_array( $input ) ) {
				return $setting->default;
			}

			if ( false === strpos( $input, 'rgba' ) ) {
				// If string doesn't start with 'rgba' then santize as hex color
				$input = sanitize_hex_color( $input );
			} else {
				// Sanitize as RGBa color
				$input = str_replace( ' ', '', $input );
				sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
				$input = 'rgba(' . skyrocket_in_range( $red, 0, 255 ) . ',' . skyrocket_in_range( $green, 0, 255 ) . ',' . skyrocket_in_range( $blue, 0, 255 ) . ',' . skyrocket_in_range( $alpha, 0, 1 ) . ')';
			}
			return $input;
		}
	}

   /**
	 * Alpha Color Picker Custom Control
	 *
	 * @author Braad Martin <http://braadmartin.com>
	 * @license http://www.gnu.org/licenses/gpl-3.0.html
	 * @link https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
	 */
	class Skyrocket_Customize_Alpha_Color_Control_f extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'alpha-color-f';
		/**
		 * Add support for palettes to be passed in.
		 *
		 * Supported palette values are true, false, or an array of RGBa and Hex colors.
		 */
		public $palette;
		/**
		 * Add support for showing the opacity value on the slider handle.
		 */
		public $show_opacity;
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {

			// Process the palette
			if ( is_array( $this->palette ) ) {
				$palette = implode( '|', $this->palette );
			} else {
				// Default to true.
				$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
			}

			// Support passing show_opacity as string or boolean. Default to true.
			$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

			?>
				<label>
					<?php // Output the label and description if they were passed in.
					if ( isset( $this->label ) && '' !== $this->label ) {
						echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
					}
					if ( isset( $this->description ) && '' !== $this->description ) {
						echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
					} ?>
				</label>
				<input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />

            <style>
               /* ==========================================================================
   Alpha颜色选择器
   ========================================================================== */
.customize-control-alpha-color .wp-picker-container .iris-picker {
	border-bottom:none;
}

.customize-control-alpha-color .wp-picker-container {
	max-width: 257px;
}

.customize-control-alpha-color .wp-picker-open + .wp-picker-input-wrap {
	width: 100%;
}

.customize-control-alpha-color .wp-picker-input-wrap input[type="text"].wp-color-picker.alpha-color-control {
	float: left;
	width: 195px;
}

.customize-control-alpha-color .wp-picker-input-wrap .button {
	margin-left: 0;
	float: right;
}

.wp-picker-container .wp-picker-open ~ .wp-picker-holder .alpha-color-picker-container {
	display: block;
}

.alpha-color-picker-container {
	border: 1px solid #dfdfdf;
	border-top: none;
	display: none;
	background-color: #fff;
	padding: 0 11px 10px;
	position: relative;
}

.alpha-color-picker-container .ui-widget-content,
.alpha-color-picker-container .ui-widget-header,
.alpha-color-picker-wrap .ui-state-focus {
	background: transparent;
	border: none;
}

.alpha-color-picker-wrap a.iris-square-value:focus {
	-webkit-box-shadow: none;
	box-shadow: none;
}

.alpha-color-picker-container .ui-slider {
	position: relative;
	z-index: 1;
	height: 24px;
	text-align: center;
	margin: 0 auto;
	width: 88%;
	width: calc( 100% - 28px );
}

.alpha-color-picker-container .ui-slider-handle,
.alpha-color-picker-container .ui-widget-content .ui-state-default {
	color: #777;
	background-color: #fff;
	text-shadow: 0 1px 0 #fff;
	text-decoration: none;
	position: absolute;
	z-index: 2;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	border: 1px solid #aaa;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	margin-top: -2px;
	top: 0;
	height: 26px;
	width: 26px;
	cursor: ew-resize;
	font-size: 0;
	padding: 0;
	line-height: 27px;
	margin-left: -14px;
}
.alpha-color-picker-container .ui-slider-handle.show-opacity {
	font-size: 12px;
}

.alpha-color-picker-container .click-zone {
	width: 14px;
	height: 24px;
	display: block;
	position: absolute;
	left: 10px;
}

.alpha-color-picker-container .max-click-zone {
	right: 10px;
	left: auto;
}

.alpha-color-picker-container .transparency {
	height: 24px;
	width: 100%;
	background-color: #fff;
	background-image: url(<?php echo plugin_dir_url( __DIR__ ) . 'public/images/color-picker-transparency-grid.png'; ?>);
	box-shadow: 0 0 5px rgba(0,0,0,0.4) inset;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	padding: 0;
	margin-top: -24px;
}

@media only screen and (max-width: 782px) {
	.customize-control-alpha-color .wp-picker-input-wrap input[type="text"].wp-color-picker.alpha-color-control {
		width: 184px;
	}
}

@media only screen and (max-width: 640px) {
	.customize-control-alpha-color .wp-picker-input-wrap input[type="text"].wp-color-picker.alpha-color-control {
		width: 172px;
		height: 33px;
	}
}
               </style>
               
               <script>
                  jQuery( document ).ready(function($) {
	"use strict";
	/**
 	 * Alpha颜色选取器自定义控件
 	 *
 	 * @author Braad Martin <http://braadmartin.com>
 	 * @license http://www.gnu.org/licenses/gpl-3.0.html
 	 * @link https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
 	 */

	// 循环每个控件并将其转换为我们的颜色选择器。
	$( '.alpha-color-control' ).each( function() {

		// Scope the vars.
		var $control, startingColor, paletteInput, showOpacity, defaultColor, palette,
			colorPickerOptions, $container, $alphaSlider, alphaVal, sliderOptions;

		// Store the control instance.
		$control = $( this );

		// Get a clean starting value for the option.
		startingColor = $control.val().replace( /\s+/g, '' );

		// Get some data off the control.
		paletteInput = $control.attr( 'data-palette' );
		showOpacity  = $control.attr( 'data-show-opacity' );
		defaultColor = $control.attr( 'data-default-color' );

		// Process the palette.
		if ( paletteInput.indexOf( '|' ) !== -1 ) {
			palette = paletteInput.split( '|' );
		} else if ( 'false' == paletteInput ) {
			palette = false;
		} else {
			palette = true;
		}

		// Set up the options that we'll pass to wpColorPicker().
		colorPickerOptions = {
			change: function( event, ui ) {
				var key, value, alpha, $transparency;

				key = $control.attr( 'data-customize-setting-link' );
				value = $control.wpColorPicker( 'color' );

				// Set the opacity value on the slider handle when the default color button is clicked.
				if ( defaultColor == value ) {
					alpha = acp_get_alpha_value_from_color( value );
					$alphaSlider.find( '.ui-slider-handle' ).text( alpha );
				}

				// Send ajax request to wp.customize to trigger the Save action.
				wp.customize( key, function( obj ) {
					obj.set( value );
				});

				$transparency = $container.find( '.transparency' );

				// Always show the background color of the opacity slider at 100% opacity.
				$transparency.css( 'background-color', ui.color.toString( 'no-alpha' ) );
			},
			palettes: palette // Use the passed in palette.
		};

		// Create the colorpicker.
		$control.wpColorPicker( colorPickerOptions );

		$container = $control.parents( '.wp-picker-container:first' );

		// Insert our opacity slider.
		$( '<div class="alpha-color-picker-container">' +
				'<div class="min-click-zone click-zone"></div>' +
				'<div class="max-click-zone click-zone"></div>' +
				'<div class="alpha-slider"></div>' +
				'<div class="transparency"></div>' +
			'</div>' ).appendTo( $container.find( '.wp-picker-holder' ) );

		$alphaSlider = $container.find( '.alpha-slider' );

		// If starting value is in format RGBa, grab the alpha channel.
		alphaVal = acp_get_alpha_value_from_color( startingColor );

		// Set up jQuery UI slider() options.
		sliderOptions = {
			create: function( event, ui ) {
				var value = $( this ).slider( 'value' );

				// Set up initial values.
				$( this ).find( '.ui-slider-handle' ).text( value );
				$( this ).siblings( '.transparency ').css( 'background-color', startingColor );
			},
			value: alphaVal,
			range: 'max',
			step: 1,
			min: 0,
			max: 100,
			animate: 300
		};

		// Initialize jQuery UI slider with our options.
		$alphaSlider.slider( sliderOptions );

		// Maybe show the opacity on the handle.
		if ( 'true' == showOpacity ) {
			$alphaSlider.find( '.ui-slider-handle' ).addClass( 'show-opacity' );
		}

		// Bind event handlers for the click zones.
		$container.find( '.min-click-zone' ).on( 'click', function() {
			acp_update_alpha_value_on_color_control( 0, $control, $alphaSlider, true );
		});
		$container.find( '.max-click-zone' ).on( 'click', function() {
			acp_update_alpha_value_on_color_control( 100, $control, $alphaSlider, true );
		});

		// Bind event handler for clicking on a palette color.
		$container.find( '.iris-palette' ).on( 'click', function() {
			var color, alpha;

			color = $( this ).css( 'background-color' );
			alpha = acp_get_alpha_value_from_color( color );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );

			// Sometimes Iris doesn't set a perfect background-color on the palette,
			// for example rgba(20, 80, 100, 0.3) becomes rgba(20, 80, 100, 0.298039).
			// To compensante for this we round the opacity value on RGBa colors here
			// and save it a second time to the color picker object.
			if ( alpha != 100 ) {
				color = color.replace( /[^,]+(?=\))/, ( alpha / 100 ).toFixed( 2 ) );
			}

			$control.wpColorPicker( 'color', color );
		});

		// Bind event handler for clicking on the 'Clear' button.
		$container.find( '.button.wp-picker-clear' ).on( 'click', function() {
			var key = $control.attr( 'data-customize-setting-link' );

			// The #fff color is delibrate here. This sets the color picker to white instead of the
			// defult black, which puts the color picker in a better place to visually represent empty.
			$control.wpColorPicker( 'color', '#ffffff' );

			// Set the actual option value to empty string.
			wp.customize( key, function( obj ) {
				obj.set( '' );
			});

			acp_update_alpha_value_on_alpha_slider( 100, $alphaSlider );
		});

		// Bind event handler for clicking on the 'Default' button.
		$container.find( '.button.wp-picker-default' ).on( 'click', function() {
			var alpha = acp_get_alpha_value_from_color( defaultColor );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Bind event handler for typing or pasting into the input.
		$control.on( 'input', function() {
			var value = $( this ).val();
			var alpha = acp_get_alpha_value_from_color( value );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Update all the things when the slider is interacted with.
		$alphaSlider.slider().on( 'slide', function( event, ui ) {
			var alpha = parseFloat( ui.value ) / 100.0;

			acp_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, false );

			// Change value shown on slider handle.
			$( this ).find( '.ui-slider-handle' ).text( ui.value );
		});

	});

	/**
	 * 重写stock-color.js-toString（）方法以添加对输出RGBa或Hex的支持。
	 */
	Color.prototype.toString = function( flag ) {

		// If our no-alpha flag has been passed in, output RGBa value with 100% opacity.
		// This is used to set the background color on the opacity slider during color changes.
		if ( 'no-alpha' == flag ) {
			return this.toCSS( 'rgba', '1' ).replace( /\s+/g, '' );
		}

		// If we have a proper opacity value, output RGBa.
		if ( 1 > this._alpha ) {
			return this.toCSS( 'rgba', this._alpha ).replace( /\s+/g, '' );
		}

		// Proceed with stock color.js hex output.
		var hex = parseInt( this._color, 10 ).toString( 16 );
		if ( this.error ) { return ''; }
		if ( hex.length < 6 ) {
			for ( var i = 6 - hex.length - 1; i >= 0; i-- ) {
				hex = '0' + hex;
			}
		}

		return '#' + hex;
	};

	/**
	 * 给定RGBa、RGB或十六进制颜色值，返回alpha通道值。
	 */
	function acp_get_alpha_value_from_color( value ) {
		var alphaVal;

		// Remove all spaces from the passed in value to help our RGBa regex.
		value = value.replace( / /g, '' );

		if ( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ ) ) {
			alphaVal = parseFloat( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ )[1] ).toFixed(2) * 100;
			alphaVal = parseInt( alphaVal );
		} else {
			alphaVal = 100;
		}

		return alphaVal;
	}

	/**
	 * 强制更新颜色选择器对象的alpha值，可能还有alpha滑块。
	 */
	 function acp_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, update_slider ) {
		var iris, colorPicker, color;

		iris = $control.data( 'a8cIris' );
		colorPicker = $control.data( 'wpWpColorPicker' );

		// Set the alpha value on the Iris object.
		iris._color._alpha = alpha;

		// Store the new color value.
		color = iris._color.toString();

		// Set the value of the input.
		$control.val( color );

		// Update the background color of the color picker.
		colorPicker.toggler.css({
			'background-color': color
		});

		// Maybe update the alpha slider itself.
		if ( update_slider ) {
			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		}

		// Update the color value of the color picker object.
		$control.wpColorPicker( 'color', color );
	}

	/**
	 * 更新滑块控制柄位置和标签。
	 */
	function acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider ) {
		$alphaSlider.slider( 'value', alpha );
		$alphaSlider.find( '.ui-slider-handle' ).text( alpha.toString() );
	}

});


                  </script>
                 
			<?php
		}
	}


      		// Alpha颜色选择器控件测试
		$wp_customize->add_setting( 'sample_alpha_color_f',
      array(
         'default' => 'rgba(209,0,55,0.7)',
         'transport' => 'postMessage',
         'sanitize_callback' => 'skyrocket_hex_rgba_sanitization_f'
      )
   );
   $wp_customize->add_control( new Skyrocket_Customize_Alpha_Color_Control_f( $wp_customize, 'sample_alpha_color_f',
      array(
         'label' => __( 'Alpha颜色选取器控件', 'skyrocket' ),
         'description' => esc_html__( '简单描述', 'skyrocket' ),
         'section' => 'section_pro',
         'show_opacity' => true,
         'palette' => array(
            '#000',
            '#fff',
            '#df312c',
            '#df9a23',
            '#eef000',
            '#7ed934',
            '#1571c1',
            '#8309e7'
         )
      )
   ) );


   //WPColorPicker Alpha颜色选择器

   	/**
	 * 阿尔法颜色（十六进制和RGBa）消毒
	 *
	 * @param  string	Input to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_hex_rgba_sanitization_a' ) ) {
		function skyrocket_hex_rgba_sanitization_a( $input, $setting ) {
			if ( empty( $input ) || is_array( $input ) ) {
				return $setting->default;
			}

			if ( false === strpos( $input, 'rgba' ) ) {
				// If string doesn't start with 'rgba' then santize as hex color
				$input = sanitize_hex_color( $input );
			} else {
				// Sanitize as RGBa color
				$input = str_replace( ' ', '', $input );
				sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
				$input = 'rgba(' . skyrocket_in_range( $red, 0, 255 ) . ',' . skyrocket_in_range( $green, 0, 255 ) . ',' . skyrocket_in_range( $blue, 0, 255 ) . ',' . skyrocket_in_range( $alpha, 0, 1 ) . ')';
			}
			return $input;
		}
	}


   	/**
	 * WPColorPicker Alpha颜色选择器自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 *
	 * 支持Alpha通道的WPColorPicker脚本的Props@kallookoo
	 *
	 * @author Sergio <https://github.com/kallookoo>
	 * @license http://www.gnu.org/licenses/gpl-3.0.html
	 * @link https://github.com/kallookoo/wp-color-picker-alpha
	 */
	class Skyrocket_Alpha_Color_Control_a extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'wpcolorpicker-alpha-color_a';
		/**
		 * ColorPicker Attributes
		 */
		public $attributes = "";
		/**
		 * Color palette defaults
		 */
		public $defaultPalette = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			$this->attributes .= 'data-default-color="' . esc_attr( $this->value() ) . '"';
			$this->attributes .= 'data-alpha="true"';
			$this->attributes .= 'data-reset-alpha="' . ( isset( $this->input_attrs['resetalpha'] ) ? $this->input_attrs['resetalpha'] : 'true' ) . '"';
			$this->attributes .= 'data-custom-width="0"';
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
        
			//wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
			wp_enqueue_script( 'wp-color-picker-alpha',  plugin_dir_url( __DIR__ )  . 'public/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0', true );
			//wp_enqueue_style( 'wp-color-picker' );
		}
		/**
		 * Pass our Palette colours to JavaScript
		 */
		public function to_json() {
			parent::to_json();
			$this->json['colorpickerpalette'] = isset( $this->input_attrs['palette'] ) ? $this->input_attrs['palette'] : $this->defaultPalette;
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
		  <div class="wpcolorpicker_alpha_color_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="text" class="color-picker" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-colorpicker-alpha-color" <?php echo $this->attributes; ?> <?php $this->link(); ?> />
			</div>
         <style>
            </style>
            <script>
               
               </script>
		<?php
		}
	}

   		// WPColorPicker Alpha颜色选择器控件的测试
		$wp_customize->add_setting( 'sample_wpcolorpicker_alpha_color_a',
      array(
         'default' => 'rgba(55,55,55,0.5)',
         'transport' => 'refresh',
         'sanitize_callback' => 'skyrocket_hex_rgba_sanitization_a'
      )
   );
   $wp_customize->add_control( new Skyrocket_Alpha_Color_Control_a( $wp_customize, 'sample_wpcolorpicker_alpha_color_a',
      array(
         'label' => __( 'WP颜色选择器Alpha颜色选择器', 'skyrocket' ),
         'description' => esc_html__( 'Sample color control with Alpha channel', 'skyrocket' ),
         'section' => 'section_pro',
         'input_attrs' => array(
            'palette' => array(
               '#000000',
               '#ffffff',
               '#dd3333',
               '#dd9933',
               '#eeee22',
               '#81d742',
               '#1e73be',
               '#8224e3',
            )
         ),
      )
   ) );

   // WPColorPicker Alpha颜色选择器控件的另一个测试
   $wp_customize->add_setting( 'sample_wpcolorpicker_alpha_color2_a',
      array(
         'default' => 'rgba(33,33,33,0.8)',
         'transport' => 'refresh',
         'sanitize_callback' => 'skyrocket_hex_rgba_sanitization_a'
      )
   );
   $wp_customize->add_control( new Skyrocket_Alpha_Color_Control_a( $wp_customize, 'sample_wpcolorpicker_alpha_color2_a',
      array(
         'label' => __( 'WP颜色选择器Alpha颜色选择器', 'skyrocket' ),
         'description' => esc_html__( 'Sample color control with Alpha channel', 'skyrocket' ),
         'section' => 'section_pro',
         'input_attrs' => array(
            'resetalpha' => false,
            'palette' => array(
               'rgba(99,78,150,1)',
               'rgba(67,78,150,1)',
               'rgba(34,78,150,.7)',
               'rgba(3,78,150,1)',
               'rgba(7,110,230,.9)',
               'rgba(234,78,150,1)',
               'rgba(99,78,150,.5)',
               'rgba(190,120,120,.5)',
            ),
         ),
      )
   ) );


//可排序药丸复选框自定义控件
	/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_text_sanitization_w' ) ) {
		function skyrocket_text_sanitization_w( $input ) {
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
	 * 可排序药丸复选框自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Pill_Checkbox_Custom_Control_w extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'pill_checkbox_w';
		/**
		 * Define whether the pills can be sorted using drag 'n drop. Either false or true. Default = false
		 */
		private $sortable = false;
		/**
		 * The width of the pills. Each pill can be auto width or full width. Default = false
		 */
		private $fullwidth = false;
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Check if these pills are sortable
			if ( isset( $this->input_attrs['sortable'] ) && $this->input_attrs['sortable'] ) {
				$this->sortable = true;
			}
			// Check if the pills should be full width
			if ( isset( $this->input_attrs['fullwidth'] ) && $this->input_attrs['fullwidth'] ) {
				$this->fullwidth = true;
			}
		}		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$reordered_choices = array();
			$saved_choices = explode( ',', esc_attr( $this->value() ) );

			// Order the checkbox choices based on the saved order
			if( $this->sortable ) {
				foreach ( $saved_choices as $key => $value ) {
					if( isset( $this->choices[$value] ) ) {
						$reordered_choices[$value] = $this->choices[$value];
					}
				}
				$reordered_choices = array_merge( $reordered_choices, array_diff_assoc( $this->choices, $reordered_choices ) );
			}
			else {
				$reordered_choices = $this->choices;
			}
		?>
			<div class="pill_checkbox_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-pill-checkbox" <?php $this->link(); ?> />
				<div class="sortable_pills<?php echo ( $this->sortable ? ' sortable' : '' ) . ( $this->fullwidth ? ' fullwidth_pills' : '' ); ?>">
				<?php foreach ( $reordered_choices as $key => $value ) { ?>
					<label class="checkbox-label">
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( esc_attr( $key ), $saved_choices, true ), true ); ?> class="sortable-pill-checkbox"/>
						<span class="sortable-pill-title"><?php echo esc_attr( $value ); ?></span>
						<?php if( $this->sortable && $this->fullwidth ) { ?>
							<span class="dashicons dashicons-sort"></span>
						<?php } ?>
					</label>
				<?php	} ?>
				</div>
			</div>
			<style>
				/* ==========================================================================
   Pill Checkboxes
   ========================================================================== */
.pill_checkbox_control .checkbox-label > input {
	display: none;
}

.pill_checkbox_control .checkbox-label > .sortable-pill-title {
	box-sizing: border-box;
	cursor: pointer;
	background-color: #ddd;
	padding: 5px 15px;
	border-radius: 20px;
	font-size: 1rem;
	display: inline-block;
	margin-bottom: 5px
}

.pill_checkbox_control .sortable .checkbox-label > .sortable-pill-title {
	cursor: move;
}

.pill_checkbox_control .sortable.fullwidth_pills .checkbox-label > .sortable-pill-title {
	cursor: pointer;
}

.pill_checkbox_control .checkbox-label > input:checked + .sortable-pill-title { 
	background-color: #2084bd;
	color: #fff;
}

.pill_checkbox_control .checkbox-label > input:checked + .sortable-pill-title:before { 
	display: inline-block;
	font-style: normal;
	font-variant: normal;
	text-rendering: auto;
	-webkit-font-smoothing: antialiased;
	font-family: "dashicons";
	font-weight: normal;
	font-size: 24px;
	content: "\f147";
	margin-left: -10px;
	vertical-align: bottom;
}

.pill_checkbox_control .fullwidth_pills .checkbox-label > .sortable-pill-title {
	width: 100%;
	border-radius: 0;
}

.pill_checkbox_control .sortable.fullwidth_pills .checkbox-label > .sortable-pill-title {
	width: 90%;
}

.pill-ui-state-highlight {
	display: inline-block;
	padding: 5px 15px;
	border-radius: 20px;
	font-size: 1rem;
	border: 1px dotted #2084bd;
	margin-bottom: 5px;
	height: 16px;
}

.pill_checkbox_control .sortable_pills .pill-ui-state-highlight {
	width: 50px;
	border-radius: 20px;
}

.pill_checkbox_control .sortable_pills.fullwidth_pills .pill-ui-state-highlight {
	width: 90%;
	border-radius: 0;
}

.pill_checkbox_control .dashicons-sort {
	margin: 5px 0 0 1px;
	color: #d4d4d4;
	cursor: move;
}

.pill_checkbox_control .dashicons-sort:hover {
	color: #a7a7a7;
}

.pill_checkbox_control .sortable_pills.fullwidth_pills .ui-sortable-helper {
	width: calc(100% - 25px) !important;
}
			</style>
			
			<script>
				jQuery( document ).ready(function($) {
	"use strict";
	/**
	 * 药丸复选框自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	 $( ".pill_checkbox_control .sortable" ).sortable({
		placeholder: "pill-ui-state-highlight",
		update: function( event, ui ) {
			skyrocketGetAllPillCheckboxes($(this).parent());
		}
	});

	$('.pill_checkbox_control .sortable-pill-checkbox').on('change', function () {
		skyrocketGetAllPillCheckboxes($(this).parent().parent().parent());
	});

	// 从复选框中获取值并添加到隐藏字段
	function skyrocketGetAllPillCheckboxes($element) {
		var inputValues = $element.find('.sortable-pill-checkbox').map(function() {
			if( $(this).is(':checked') ) {
				return $(this).val();
			}
		}).toArray();
		$element.find('.customize-control-sortable-pill-checkbox').val(inputValues).trigger('change');
	}
});
			</script>

		<?php
		}
	}

   		// 药丸复选框自定义控件测试
		$wp_customize->add_setting( 'sample_pill_checkbox_w',
		array(
			'default' => 'tiger,elephant,hippo',
			'transport' => 'refresh',
			'sanitize_callback' => 'skyrocket_text_sanitization_w'
		)
	);
	$wp_customize->add_control( new Skyrocket_Pill_Checkbox_Custom_Control_w( $wp_customize, 'sample_pill_checkbox_w',
		array(
			'label' => __( '药丸复选框控件', 'skyrocket' ),
			'description' => esc_html__( '这是药丸复选框控件示例', 'skyrocket' ),
			'section' => 'section_pro',
			'input_attrs' => array(
				'sortable' => false,
				'fullwidth' => false,
			),
			'choices' => array(
				'tiger' => __( 'Tiger', 'skyrocket' ),
				'lion' => __( 'Lion', 'skyrocket' ),
				'giraffe' => __( 'Giraffe', 'skyrocket'  ),
				'elephant' => __( 'Elephant', 'skyrocket'  ),
				'hippo' => __( 'Hippo', 'skyrocket'  ),
				'rhino' => __( 'Rhino', 'skyrocket'  ),
			)
		)
	) );


			// 可排序
			$wp_customize->add_setting( 'sample_pill_checkbox2_b',
			array(
				'default' => 'captainmarvel,msmarvel,squirrelgirl',
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_text_sanitization_w'
			)
		);
		$wp_customize->add_control( new Skyrocket_Pill_Checkbox_Custom_Control_w( $wp_customize, 'sample_pill_checkbox2_b',
			array(
				'label' => __( '药丸复选框控件', 'skyrocket' ),
				'description' => esc_html__( '这是一个示例可排序药丸复选框控件', 'skyrocket' ),
				'section' => 'section_pro',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => false,
				),
				'choices' => array(
					'captainamerica' => __( 'Captain America', 'skyrocket' ),
					'ironman' => __( 'Iron Man', 'skyrocket' ),
					'captainmarvel' => __( 'Captain Marvel', 'skyrocket'  ),
					'msmarvel' => __( 'Ms. Marvel', 'skyrocket'  ),
					'Jessicajones' => __( 'Jessica Jones', 'skyrocket'  ),
					'squirrelgirl' => __( 'Squirrel Girl', 'skyrocket'  ),
					'blackwidow' => __( 'Black Widow', 'skyrocket'  ),
					'hulk' => __( 'Hulk', 'skyrocket'  ),
				)
			)
		) );

		//全宽 - 可排序
		$wp_customize->add_setting( 'sample_pill_checkbox3_c',
			array(
				'default' => 'author,categories,comments',
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_text_sanitization_w'
			)
		);
		$wp_customize->add_control( new Skyrocket_Pill_Checkbox_Custom_Control_w( $wp_customize, 'sample_pill_checkbox3_c',
			array(
				'label' => __( '药丸复选框控件', 'skyrocket' ),
				'description' => esc_html__( '这是一个示例Sortable Fullwidth Pill复选框控件', 'skyrocket' ),
				'section' => 'section_pro',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => true,
				),
				'choices' => array(
					'date' => __( 'Date', 'skyrocket' ),
					'author' => __( 'Author', 'skyrocket' ),
					'categories' => __( 'Categories', 'skyrocket'  ),
					'tags' => __( 'Tags', 'skyrocket'  ),
					'comments' => __( 'Comments', 'skyrocket'  ),
				)
			)
		) );



		//下拉选择框控件

			/**
	 * 文本净化
	 *
	 * @param  string	要清理的输入（包含单个字符串或多个字符串，用逗号分隔）
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_text_sanitization_t' ) ) {
		function skyrocket_text_sanitization_t( $input ) {
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
	 * 下拉选择2自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Dropdown_Select2_Custom_Control_t extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'dropdown_select2_t';
		/**
		 * The type of Select2 Dropwdown to display. Can be either a single select dropdown or a multi-select dropdown. Either false for true. Default = false
		 */
		private $multiselect = false;
		/**
		 * The Placeholder value to display. Select2 requires a Placeholder value to be set when using the clearall option. Default = 'Please select...'
		 */
		private $placeholder = 'Please select...';
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Check if this is a multi-select field
			if ( isset( $this->input_attrs['multiselect'] ) && $this->input_attrs['multiselect'] ) {
				$this->multiselect = true;
			}
			// Check if a placeholder string has been specified
			if ( isset( $this->input_attrs['placeholder'] ) && $this->input_attrs['placeholder'] ) {
				$this->placeholder = $this->input_attrs['placeholder'];
			}
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'skyrocket-select2-js',  plugin_dir_url( __DIR__ )  . 'public/js/select2.full.min.js', array( 'jquery' ), '4.0.13', true );
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'skyrocket-select2-js' ), '1.0', true );
			wp_enqueue_style( 'skyrocket-custom-controls-css', plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.1', 'all' );
			wp_enqueue_style( 'skyrocket-select2-css',  plugin_dir_url( __DIR__ )  . 'public/css/select2.min.css', array(), '4.0.13', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$defaultValue = $this->value();
			if ( $this->multiselect ) {
				$defaultValue = explode( ',', $this->value() );
			}
		?>
			<div class="dropdown_select2_control">
				<?php if( !empty( $this->label ) ) { ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr( $this->value() ); ?>" name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> />
				<select name="select2-list-<?php echo ( $this->multiselect ? 'multi[]' : 'single' ); ?>" class="customize-control-select2" data-placeholder="<?php echo $this->placeholder; ?>" <?php echo ( $this->multiselect ? 'multiple="multiple" ' : '' ); ?>>
					<?php
						if ( !$this->multiselect ) {
							// When using Select2 for single selection, the Placeholder needs an empty <option> at the top of the list for it to work (multi-selects dont need this)
							echo '<option></option>';
						}
						foreach ( $this->choices as $key => $value ) {
							if ( is_array( $value ) ) {
								echo '<optgroup label="' . esc_attr( $key ) . '">';
								foreach ( $value as $optgroupkey => $optgroupvalue ) {
									if( $this->multiselect ){
										echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . ( in_array( esc_attr( $optgroupkey ), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $optgroupvalue ) . '</option>';
									}
									else{
										echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . selected( esc_attr( $optgroupkey ), $defaultValue, false )  . '>' . esc_attr( $optgroupvalue ) . '</option>';
									}
								}
								echo '</optgroup>';
							}
							else {
								if( $this->multiselect ){
									echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( esc_attr( $key ), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $value ) . '</option>';
								}
								else{
									echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $key ), $defaultValue, false )  . '>' . esc_attr( $value ) . '</option>';
								}
							}
						}
					?>
				</select>
			</div>
			<style>
				</style>
				<script>
					jQuery( document ).ready(function($) {
	"use strict";
					/**
	 * 下拉选择2自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	$('.customize-control-dropdown-select2').each(function(){
		$('.customize-control-select2').select2({
			allowClear: true
		});
	});

	$(".customize-control-select2").on("change", function() {
		var select2Val = $(this).val();
		$(this).parent().find('.customize-control-dropdown-select2').val(select2Val).trigger('change');
	});

});
				</script>
		<?php
		}
	}



				//下拉选择2控件测试（单选）
				$wp_customize->add_setting( 'sample_t',
				array(
					'default' => 'vic',
					'transport' => 'refresh',
					'sanitize_callback' => 'skyrocket_text_sanitization_t'
				)
			);
			$wp_customize->add_control( new Skyrocket_Dropdown_Select2_Custom_Control_t( $wp_customize, 'sample_t',
				array(
					'label' => __( '下拉选择2控件', 'skyrocket' ),
					'description' => esc_html__( '示例下拉选择2自定义控件（单选）', 'skyrocket' ),
					'section' => 'section_pro',
					'input_attrs' => array(
						'placeholder' => __( 'Please select a state...', 'skyrocket' ),
						'multiselect' => false,
					),
					'choices' => array(
						'nsw' => __( 'New South Wales', 'skyrocket' ),
						'vic' => __( 'Victoria', 'skyrocket' ),
						'qld' => __( 'Queensland', 'skyrocket' ),
						'wa' => __( 'Western Australia', 'skyrocket' ),
						'sa' => __( 'South Australia', 'skyrocket' ),
						'tas' => __( 'Tasmania', 'skyrocket' ),
						'act' => __( 'Australian Capital Territory', 'skyrocket' ),
						'nt' => __( 'Northern Territory', 'skyrocket' ),
					)
				)
			) );

					// 下拉选择2控件测试（多选）
		$wp_customize->add_setting( 'sample_2_b',
		array(
			'default' => 'Antarctica/McMurdo,Australia/Melbourne,Australia/Broken_Hill',
			'transport' => 'refresh',
			'sanitize_callback' => 'skyrocket_text_sanitization_t'
		)
	);
	$wp_customize->add_control( new Skyrocket_Dropdown_Select2_Custom_Control_t( $wp_customize, 'sample_2_b',
		array(
			'label' => __( '下拉选择2控件', 'skyrocket' ),
			'description' => esc_html__( '示例下拉选择2自定义控件（多选）', 'skyrocket' ),
			'section' => 'section_pro',
			'input_attrs' => array(
				'multiselect' => true,
			),
			'choices' => array(
				__( 'Antarctica', 'skyrocket' ) => array(
					'Antarctica/Casey' => __( 'Casey', 'skyrocket' ),
					'Antarctica/Davis' => __( 'Davis', 'skyrocket' ),
					'Antarctica/DumontDurville' => __( 'DumontDUrville', 'skyrocket' ),
					'Antarctica/Macquarie' => __( 'Macquarie', 'skyrocket' ),
					'Antarctica/Mawson' => __( 'Mawson', 'skyrocket' ),
					'Antarctica/McMurdo' => __( 'McMurdo', 'skyrocket' ),
					'Antarctica/Palmer' => __( 'Palmer', 'skyrocket' ),
					'Antarctica/Rothera' => __( 'Rothera', 'skyrocket' ),
					'Antarctica/Syowa' => __( 'Syowa', 'skyrocket' ),
					'Antarctica/Troll' => __( 'Troll', 'skyrocket' ),
					'Antarctica/Vostok' => __( 'Vostok', 'skyrocket' ),
				),
				__( 'Atlantic', 'skyrocket' ) => array(
					'Atlantic/Azores' => __( 'Azores', 'skyrocket' ),
					'Atlantic/Bermuda' => __( 'Bermuda', 'skyrocket' ),
					'Atlantic/Canary' => __( 'Canary', 'skyrocket' ),
					'Atlantic/Cape_Verde' => __( 'Cape Verde', 'skyrocket' ),
					'Atlantic/Faroe' => __( 'Faroe', 'skyrocket' ),
					'Atlantic/Madeira' => __( 'Madeira', 'skyrocket' ),
					'Atlantic/Reykjavik' => __( 'Reykjavik', 'skyrocket' ),
					'Atlantic/South_Georgia' => __( 'South Georgia', 'skyrocket' ),
					'Atlantic/Stanley' => __( 'Stanley', 'skyrocket' ),
					'Atlantic/St_Helena' => __( 'St Helena', 'skyrocket' ),
				),
				__( 'Australia', 'skyrocket' ) => array(
					'Australia/Adelaide' => __( 'Adelaide', 'skyrocket' ),
					'Australia/Brisbane' => __( 'Brisbane', 'skyrocket' ),
					'Australia/Broken_Hill' => __( 'Broken Hill', 'skyrocket' ),
					'Australia/Currie' => __( 'Currie', 'skyrocket' ),
					'Australia/Darwin' => __( 'Darwin', 'skyrocket' ),
					'Australia/Eucla' => __( 'Eucla', 'skyrocket' ),
					'Australia/Hobart' => __( 'Hobart', 'skyrocket' ),
					'Australia/Lindeman' => __( 'Lindeman', 'skyrocket' ),
					'Australia/Lord_Howe' => __( 'Lord Howe', 'skyrocket' ),
					'Australia/Melbourne' => __( 'Melbourne', 'skyrocket' ),
					'Australia/Perth' => __( 'Perth', 'skyrocket' ),
					'Australia/Sydney' => __( 'Sydney', 'skyrocket' ),
				)
			)
		)
	) );

	// 使用单阵列选择测试下拉式Select2控件（多选）
	$wp_customize->add_setting( 'sample_2_c',
		array(
			'default' => 'Atlantic/Stanley,Australia/Darwin',
			'transport' => 'refresh',
			'sanitize_callback' => 'skyrocket_text_sanitization_t'
		)
	);
	$wp_customize->add_control( new Skyrocket_Dropdown_Select2_Custom_Control_t( $wp_customize, 'sample_2_c',
		array(
			'label' => __( '下拉选择2控件', 'skyrocket' ),
			'description' => esc_html__( '另一个示例下拉选择2自定义控件（多选）', 'skyrocket' ),
			'section' => 'section_pro',
			'input_attrs' => array(
				'multiselect' => true,
			),
			'choices' => array(
				'Antarctica/Casey' => __( 'Casey', 'skyrocket' ),
				'Antarctica/Davis' => __( 'Davis', 'skyrocket' ),
				'Antarctica/DumontDurville' => __( 'DumontDUrville', 'skyrocket' ),
				'Antarctica/Macquarie' => __( 'Macquarie', 'skyrocket' ),
				'Antarctica/Mawson' => __( 'Mawson', 'skyrocket' ),
				'Antarctica/McMurdo' => __( 'McMurdo', 'skyrocket' ),
				'Antarctica/Palmer' => __( 'Palmer', 'skyrocket' ),
				'Antarctica/Rothera' => __( 'Rothera', 'skyrocket' ),
				'Antarctica/Syowa' => __( 'Syowa', 'skyrocket' ),
				'Antarctica/Troll' => __( 'Troll', 'skyrocket' ),
				'Antarctica/Vostok' => __( 'Vostok', 'skyrocket' ),
				'Atlantic/Azores' => __( 'Azores', 'skyrocket' ),
				'Atlantic/Bermuda' => __( 'Bermuda', 'skyrocket' ),
				'Atlantic/Canary' => __( 'Canary', 'skyrocket' ),
				'Atlantic/Cape_Verde' => __( 'Cape Verde', 'skyrocket' ),
				'Atlantic/Faroe' => __( 'Faroe', 'skyrocket' ),
				'Atlantic/Madeira' => __( 'Madeira', 'skyrocket' ),
				'Atlantic/Reykjavik' => __( 'Reykjavik', 'skyrocket' ),
				'Atlantic/South_Georgia' => __( 'South Georgia', 'skyrocket' ),
				'Atlantic/Stanley' => __( 'Stanley', 'skyrocket' ),
				'Atlantic/St_Helena' => __( 'St Helena', 'skyrocket' ),
				'Australia/Adelaide' => __( 'Adelaide', 'skyrocket' ),
				'Australia/Brisbane' => __( 'Brisbane', 'skyrocket' ),
				'Australia/Broken_Hill' => __( 'Broken Hill', 'skyrocket' ),
				'Australia/Currie' => __( 'Currie', 'skyrocket' ),
				'Australia/Darwin' => __( 'Darwin', 'skyrocket' ),
				'Australia/Eucla' => __( 'Eucla', 'skyrocket' ),
				'Australia/Hobart' => __( 'Hobart', 'skyrocket' ),
				'Australia/Lindeman' => __( 'Lindeman', 'skyrocket' ),
				'Australia/Lord_Howe' => __( 'Lord Howe', 'skyrocket' ),
				'Australia/Melbourne' => __( 'Melbourne', 'skyrocket' ),
				'Australia/Perth' => __( 'Perth', 'skyrocket' ),
				'Australia/Sydney' => __( 'Sydney', 'skyrocket' ),
			)
		)
	) );


	//下拉帖子部件

		/**
	 * Dropdown Posts Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_Dropdown_Posts_Custom_Control_a extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'dropdown_posts';
		/**
		 * Posts
		 */
		private $posts = array();
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Get our Posts
			$this->posts = get_posts( $this->input_attrs );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="dropdown_posts_control">
				<?php if( !empty( $this->label ) ) { ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" <?php $this->link(); ?>>
					<?php
						if( !empty( $this->posts ) ) {
							foreach ( $this->posts as $post ) {
								printf( '<option value="%s" %s>%s</option>',
									$post->ID,
									selected( $this->value(), $post->ID, false ),
									$post->post_title
								);
							}
						}
					?>
				</select>
			</div>
		<?php
		}
	}

			// 下拉帖子测试
			$wp_customize->add_setting( 'sample_dropdown_posts_control_a',
			array(
				'default' =>'',
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control( new Skyrocket_Dropdown_Posts_Custom_Control_a( $wp_customize, 'sample_dropdown_posts_control_a',
			array(
				'label' => __( '下拉帖子测试', 'skyrocket' ),
				'description' => esc_html__( '简单的描述', 'skyrocket' ),
				'section' => 'section_pro',
				'input_attrs' => array(
					'posts_per_page' => -1,
					'orderby' => 'name',
					'order' => 'ASC',
				),
			)
		) );

//TinyMCE编辑器控件



	/**
	 * TinyMCE Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Skyrocket_TinyMCE_Custom_control_a extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'tinymce_editor_a';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue(){
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
			wp_enqueue_editor();
		}
		/**
		 * Pass our TinyMCE toolbar string to JavaScript
		 */
		public function to_json() {
			parent::to_json();
			$this->json['skyrockettinymcetoolbar1'] = isset( $this->input_attrs['toolbar1'] ) ? esc_attr( $this->input_attrs['toolbar1'] ) : 'bold italic bullist numlist alignleft aligncenter alignright link';
			$this->json['skyrockettinymcetoolbar2'] = isset( $this->input_attrs['toolbar2'] ) ? esc_attr( $this->input_attrs['toolbar2'] ) : '';
			$this->json['skyrocketmediabuttons'] = isset( $this->input_attrs['mediaButtons'] ) && ( $this->input_attrs['mediaButtons'] === true ) ? true : false;
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content(){
		?>
			<div class="tinymce-control">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<textarea id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-tinymce-editor" <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
			</div>
			<style>
				</style>
				<script>
					jQuery( document ).ready(function($) {
	"use strict";
						/**
	 * TinyMCE自定义控件
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	$('.customize-control-tinymce-editor').each(function(){
		// Get the toolbar strings that were passed from the PHP Class
		var tinyMCEToolbar1String = _wpCustomizeSettings.controls[$(this).attr('id')].skyrockettinymcetoolbar1;
		var tinyMCEToolbar2String = _wpCustomizeSettings.controls[$(this).attr('id')].skyrockettinymcetoolbar2;
		var tinyMCEMediaButtons = _wpCustomizeSettings.controls[$(this).attr('id')].skyrocketmediabuttons;

		wp.editor.initialize( $(this).attr('id'), {
			tinymce: {
				wpautop: true,
				toolbar1: tinyMCEToolbar1String,
				toolbar2: tinyMCEToolbar2String
			},
			quicktags: true,
			mediaButtons: tinyMCEMediaButtons
		});
	});
	$(document).on( 'tinymce-editor-init', function( event, editor ) {
		editor.on('change', function(e) {
			tinyMCE.triggerSave();
			$('#'+editor.id).trigger('change');
		});
	});

});
					</script>
		<?php
		}
	}


		// TinyMCE控制测试
		$wp_customize->add_setting( 'sample_tinymce_editor_a',
			array(
				'default' => '',
				'transport' => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
			)
		);
		$wp_customize->add_control( new Skyrocket_TinyMCE_Custom_control_a( $wp_customize, 'sample_tinymce_editor_a',
			array(
				'label' => __( 'TinyMCE 控件', 'skyrocket' ),
				'description' => __( '这是TinyMCE编辑器自定义控件', 'skyrocket' ),
				'section' => 'section_pro',
				'input_attrs' => array(
					'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					'mediaButtons' => true,
				)
			)
		) );
		$wp_customize->selective_refresh->add_partial( 'sample_tinymce_editor_a',
			array(
				'selector' => '.footer-credits',
				'container_inclusive' => false,
				'render_callback' => 'skyrocket_get_credits_render_callback_a',
				'fallback_refresh' => false,
			)
		);

		/**
 * 呈现用于显示页脚信用的回调
 */
function skyrocket_get_credits_render_callback_a() {
	echo skyrocket_get_credits_a();
}

/**
 * 返回包含TinyMCE控件示例的字符串
*这是一个示例函数，说明如何在主题中使用TinyMCE控件进行页脚积分
*将以下三行代码添加到footer.php文件中，以显示示例TinyMCE控件的内容
 * <div class="footer-credits">
 *		<?php echo skyrocket_get_credits(); ?>
 *	</div>
 */
if ( ! function_exists( 'skyrocket_get_credits_a' ) ) {
	function skyrocket_get_credits_a() {
		//调用默认值
		//$defaults = skyrocket_generate_defaults_a();

		// wpautop此控件，使其像新的可视化文本小部件一样，因为我们使用的是相同的TinyMCE控件
		//return wpautop( get_theme_mod( 'sample_tinymce_editor', $defaults['sample_tinymce_editor'] ) );
		return wpautop( get_theme_mod( 'sample_tinymce_editor', '' ) );
	}
}


//追加销售部分部件
	/**
	 * Upsell section
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 *
	 */
	class Skyrocket_Upsell_Section_a extends WP_Customize_Section {
		/**
		 * The type of control being rendered
		 */
		public $type = 'skyrocket-upsell_a';
		/**
		 * The Upsell URL
		 */
		public $url = '';
		/**
		 * The background color for the control
		 */
		public $backgroundcolor = '';
		/**
		 * The text color for the control
		 */
		public $textcolor = '';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			//wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the section, and the controls that have been added to it.
		 */
		protected function render() {
			$bkgrndcolor = !empty( $this->backgroundcolor ) ? esc_attr( $this->backgroundcolor ) : '#fff';
			$color = !empty( $this->textcolor ) ? esc_attr( $this->textcolor ) : '#555d66';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="skyrocket_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="upsell-section-title" <?php echo ' style="color:' . $color . ';border-left-color:' . $bkgrndcolor .';border-right-color:' . $bkgrndcolor .';"'; ?>>
					<a href="<?php echo esc_url( $this->url); ?>" target="_blank"<?php echo ' style="background-color:' . $bkgrndcolor . ';color:' . $color .';"'; ?>><?php echo esc_html( $this->title ); ?></a>
				</h3>
			</li>
			
			<?php
		}
	}


		/**
		 * 添加我们的追加销售部分
		 */
		$wp_customize->add_section( new Skyrocket_Upsell_Section_a( $wp_customize, 'upsell_section',
			array(
				'title' => __( '销售推荐', 'skyrocket' ),
				'url' => 'https://skyrocketthemes.com',
				'backgroundcolor' => '#344860',
				'textcolor' => '#fff',
				'priority' => 199,
			)
		) );






	


   /**
    * WP_Customize_Control
	*		wp_enqueue_script( 'skyrocket-custom-controls-js',  plugin_dir_url( __DIR__ )  . 'public/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
	*		wp_enqueue_style( 'skyrocket-custom-controls-css',  plugin_dir_url( __DIR__ )  . 'public/css/customizer.css', array(), '1.0', 'all' );
    * 'section' => 'section_pro',
   */



}
;
add_action( 'customize_register', 'customize_register_pro' );
?>