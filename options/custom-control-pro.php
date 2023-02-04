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