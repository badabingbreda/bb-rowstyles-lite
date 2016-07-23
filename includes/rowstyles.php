<?php
/**
 * Rowstyles
 *
 * @author Badabing
 * @package rowstyles
 * @subpackage Customizations
 */

namespace BadabingBreda;

// get the helperfunctions
require_once( 'helperfunctions.php' );

add_action( 'wp_enqueue_scripts',					__NAMESPACE__ . '\bb_rowstyles_scripts_styles' );		// enqueue the scripts and styles
add_action( 'fl_builder_before_render_row', 		__NAMESPACE__ . '\do_before_render_row', 10 , 2 );		// change behavior on render_row, add row top and bottom borders

add_filter( 'fl_builder_render_css',				__NAMESPACE__ .'\add_row_style_css', 10, 3 );			// add callback that runs when rendering css. it loops through the rows and adds row dependant css
add_filter( 'fl_builder_render_js', 				__NAMESPACE__ . '\add_row_style_js', 10, 3 );			// add callback that runs when rendering layout js. it loops through the rows and adds js if needed


$global_settings = \FLBuilderModel::get_global_settings();

// get the default settings
$row_settings = \FLBuilderModel::$settings_forms[ 'row' ];

// add a custom tab
$new_tab = array( 'Effects' => array(
				'title' => __( 'Effects', 'bb-rowstyles-lite' ),
				'sections'	=> array(
					'top_row_style'	=> array(
						'title'	=>	__('Top Row Style', 'bb-rowstyles-lite'),
						'fields'=> array(
							'row_style_top' 	=> array(
							    'type'          => 'select',
							    'label'         => __( 'Top Style', 'bb-rowstyles-lite' ),
							    'default'       => 'none',
							    'options'       => array(
							    	'none'					=> __( 'None' , 'bb-rowstyles-lite' ),
							        'slanted_top_left'      => __( 'Slanted Left', 'bb-rowstyles-lite' ),
							        'slanted_top_right'      => __( 'Slanted Right', 'bb-rowstyles-lite' ),
							    ),
							),
							'fill_top' => array(
							    'type'          => 'color',
							    'label'         => __( 'Fill color top', 'fl-builder' ),
							    'default'       => 'FFFFFF',
							    'show_reset'    => true,
							),
							'row_top_height' => array(
							    'type'          => 'text',
							    'label'         => __( 'Top Height', 'bb-rowstyles-lite' ),
							    'default'       => '100',
							    'maxlength'     => '5',
							    'size'          => '10',
							),
							'image_top' => array(
							    'type'          => 'photo',
							    'label'         => __('Seperator Image', 'bb-rowstyles-lite'),
							    'show_remove'	=> true
							),

						)
					),
					'bottom_row_style' => array(
						'title'         => __( 'Bottom Row Style' , 'bb-rowstyles-lite' ),
						'fields'        => array (
							'row_style_bottom' 	=> array(
							    'type'          => 'select',
							    'label'         => __( 'Bottom Style', 'bb-rowstyles-lite' ),
							    'default'       => 'none',
							    'options'       => array(
							    	'none'					=> __( 'None' , 'bb-rowstyles-lite' ),
							        'slanted_bottom_left'      => __( 'Slanted Left', 'bb-rowstyles-lite' ),
							        'slanted_bottom_right'      => __( 'Slanted Right', 'bb-rowstyles-lite' ),
							        'bezier_bottom_left'      => __( 'Bezier Left', 'bb-rowstyles-lite' ),
							        'bezier_bottom_right'      => __( 'Bezier Right', 'bb-rowstyles-lite' ),
							        'round_bottom'      => __( 'Round Bottom', 'bb-rowstyles-lite' ),
							        'arch_bottom'		=> __( 'Arch Bottom', 'bb-rowstyles-lite' ),
							    ),
							),
							'fill_bottom' => array(
							    'type'          => 'color',
							    'label'         => __( 'Fill color bottom', 'fl-builder' ),
							    'default'       => 'FFFFFF',
							    'show_reset'    => true,
							),
							'row_bottom_height' => array(
							    'type'          => 'text',
							    'label'         => __( 'Bottom Height', 'bb-rowstyles-lite' ),
							    'default'       => '100',
							    'maxlength'     => '5',
							    'size'          => '10',
							),
							'image_bottom' => array(
							    'type'          => 'photo',
							    'label'         => __('Seperator Image', 'bb-rowstyles-lite'),
							    'show_remove'	=> true
							),
						),
					),

				),
			) );

$new_bg_option = array(
					'unsplashit'	=> _x( 'Unsplash It','Background type.', 'bb-rowstyles-lite' ),
					'youtube'		=> _x( 'Youtube', 'Background type.',	'bb-rowstyles-lite' ),
				 ) ;

$new_bg_toggle_option = array( 'unsplashit'         => array(
									'sections'      => array('bg_unsplashit'),
								),
								'youtube'			=>	array(
									'sections'		=>	array( 'bg_youtube' ),
								)
						);

$new_bg_section = array(
					'bg_unsplashit' => array(
		  				'title'         => __( 'Unsplash Image' , 'bb-rowstyles-lite' ),
		  				'fields'        => array(
				            'unsplashid' => array(
				                'type'          => 'text',
				                'label'         => __( 'Unsplash ID', 'bb-rowstyles-lite' ),
				                'default'       => '',
				                'maxlength'     => '5',
				                'size'          => '6',
				                'placeholder'   => __( '', 'bb-rowstyles-lite' ),
				                'class'         => 'my-css-class',
				                'description'   => __( '', 'bb-rowstyles-lite' ),
				                'help'          => __( 'Enter a Unsplash ID (https://unsplash.it/images)', 'bb-rowstyles-lite' ),
				            ),
		  					'sizex' => array(
		  					    'type'          => 'text',
		  					    'label'         => __( 'Image Width', 'bb-rowstyles-lite' ),
		  					    'default'       => '1800',
		  					    'maxlength'     => '5',
		  					    'size'          => '5',
		  					    'placeholder'   => __( '', 'bb-rowstyles-lite' ),
				                'description'   => __( 'px', 'bb-rowstyles-lite' ),
		  					),
		  					'sizey' => array(
		  					    'type'          => 'text',
		  					    'label'         => __( 'Image Height', 'bb-rowstyles-lite' ),
		  					    'default'       => '1200',
		  					    'maxlength'     => '5',
		  					    'size'          => '5',
		  					    'placeholder'   => __( '', 'bb-rowstyles-lite' ),
				                'description'   => __( 'px', 'bb-rowstyles-lite' ),
		  					),
			  				'grayscale' 	=> array(
			  				    'type'          => 'select',
			  				    'label'         => __( 'Grayscale', 'bb-rowstyles-lite' ),
			  				    'default'       => 'false',
			  				    'options'       => array(
			  				        'true'      => __( 'Yes', 'bb-rowstyles-lite' ),
			  				        'false'      => __( 'No', 'bb-rowstyles-lite' ),
			  				    ),
			  				),
			  				'blurred' 	=> array(
			  				    'type'          => 'select',
			  				    'label'         => __( 'Blurred', 'bb-rowstyles-lite' ),
			  				    'default'       => 'false',
			  				    'options'       => array(
			  				        'true'      => __( 'Yes', 'bb-rowstyles-lite' ),
			  				        'false'      => __( 'No', 'bb-rowstyles-lite' ),
			  				    ),
			  				),
			  				'random' 	=> array(
			  				    'type'          => 'select',
			  				    'label'         => __( 'Random', 'bb-rowstyles-lite' ),
			  				    'default'       => 'false',
			  				    'options'       => array(
			  				        'true'      => __( 'Yes', 'bb-rowstyles-lite' ),
			  				        'false'      => __( 'No', 'bb-rowstyles-lite' ),
			  				    ),
			  				),
			            	'halign'   => array(
				                'type'          => 'select',
				                'label'         => __( 'Horizontal Alignment', 'bb-rowstyles-lite' ),
				                'default'       => 'left',
				                'options'       => array(
				                    'left'      => __( 'Left', 'bb-rowstyles-lite' ),
				                    'center'      => __( 'Center', 'bb-rowstyles-lite' ),
				                    'right'      => __( 'Right', 'bb-rowstyles-lite' ),
				                )
				            ),
				            'valign'   => array(
				                'type'          => 'select',
				                'label'         => __( 'Vertical Alignment', 'bb-rowstyles-lite' ),
				                'default'       => 'top',
				                'options'       => array(
				                    'top'      => __( 'Top', 'bb-rowstyles-lite' ),
				                    'center'      => __( 'Center', 'bb-rowstyles-lite' ),
				                    'bottom'      => __( 'Bottom', 'bb-rowstyles-lite' ),
				                )
			    	        )
                    	)
                	),
                	'bg_youtube'	=> array(
                		'title'			=> __('Youtube', 'bb-rowstyles-lite'),
                		'fields'		=> array(
                			'youtubeid' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Youtube ID', 'bb-rowstyles-lite' ),
                			    'default'       => 'LSmgKRx5pBo',
                			    'maxlength'     => '15',
                			    'size'          => '30',
                			),
                			'youtube_start' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Start Time (s)', 'bb-rowstyles-lite' ),
                			    'default'       => '0',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'placeholder'   => __( 'Starttime in seconds', 'bb-rowstyles-lite' ),
                			),
                			'youtube_playfor' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Play for', 'bb-rowstyles-lite' ),
                			    'default'       => '0',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'placeholder'   => __( 'x seconds', 'bb-rowstyles-lite' ),
                			),
                			'youtube_placeholder' => array(
                			    'type'          => 'photo',
                			    'label'         => __('Placeholder', 'bb-rowstyles-lite'),
                			    'show_remove'	=> true,
                			),
                		),
                	),
                	'gradient_overlay' => array(
                		'title'         => __( 'Gradient Overlay' , 'bb-rowstyles-lite' ),
                		'fields'        => array (
                			'gradient_overlay' 	=> array(
                			    'type'          => 'select',
                			    'label'         => __( 'Enable Gradient Overlay', 'bb-rowstyles-lite' ),
                			    'default'       => 'no',
                			    'options'       => array(
                			        'yes'      => __( 'Yes', 'bb-rowstyles-lite' ),
                			        'no'      => __( 'No', 'bb-rowstyles-lite' ),
                			    ),
                			    'toggle'        => array(
                			        'yes'      => array(
                			            'fields'        => array( 'gradient_type', 'color1', 'color2', 'color3','center', 'overlay_opacity' ),
                			        ),
                			        'yesadv'	=>	array(
                			        	'fields'		=> array( 'gradient_type', 'color1', 'color2', 'color3', 'color1_opacity','color2_opacity','color3_opacity','center' ),
                			        ),
                			        'no'      => array(),
                			    ),
                			),
                			'gradient_type' 	=> array(
                			    'type'          => 'select',
                			    'label'         => __( 'Gradient Type', 'bb-rowstyles-lite' ),
                			    'default'       => 'dark_diagonal_down',
                			    'options'       => array(
                			        'diagonal_down'      => __( 'Diagonal Down', 'bb-rowstyles-lite' ),
                			        'diagonal_up'      => __( 'Diagonal Up', 'bb-rowstyles-lite' ),
                			        'horizontal'      => __( 'Horizontal', 'bb-rowstyles-lite' ),
                			        'vertical'      => __( 'Vertical', 'bb-rowstyles-lite' ),
                			    ),
                			),
                			'color1' => array(
                			    'type'          => 'color',
                			    'label'         => __( 'Color 1', 'fl-builder' ),
                			    'default'       => '000000',
                			    'show_reset'    => true,
                			),
                			'color1_opacity' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Color 1 Opacity', 'bb-rowstyles-lite' ),
                			    'default'       => '100',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'description'   => '&#37;',
                			),
                			'color2' => array(
                			    'type'          => 'color',
                			    'label'         => __( 'Color 2 (center)', 'fl-builder' ),
                			    'default'       => '000000',
                			    'show_reset'    => true,
                			),
                			'color2_opacity' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Color 2 Opacity', 'bb-rowstyles-lite' ),
                			    'default'       => '80',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'description'   => '&#37;',
                			),
                			'color3' => array(
                			    'type'          => 'color',
                			    'label'         => __( 'Color 3', 'fl-builder' ),
                			    'default'       => '000000',
                			    'show_reset'    => true,
                			),
                			'color3_opacity' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Color 3 Opacity', 'bb-rowstyles-lite' ),
                			    'default'       => '100',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'description'   => '&#37;',
                			),
                			'center' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Center', 'bb-rowstyles-lite' ),
                			    'default'       => '50',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'placeholder'   => '0-100',
                			    'description'   => '&#37;',
                			),
                			'overlay_opacity' => array(
                			    'type'          => 'text',
                			    'label'         => __( 'Overall Opacity', 'bb-rowstyles-lite' ),
                			    'default'       => '80',
                			    'maxlength'     => '3',
                			    'size'          => '10',
                			    'placeholder'   => '0-100',
                			    'description'   => '&#37;',
                			),
                		),

                	),

                );

// insert the tab to the set position
\BadabingBreda\array_insert( $row_settings['tabs'] , $new_tab, 1 );

// get the current number of options and sections
$current_num_options = count($row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options']);
$current_num_sections = count($row_settings['tabs']['style']['sections']);

// insert the option to the selectbox as the last item
\BadabingBreda\array_insert( $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['options'], $new_bg_option, 'unsplashit', $current_num_options   );

// insert the toggle settings to the option bg_type
\BadabingBreda\array_insert( $row_settings['tabs']['style']['sections']['background']['fields']['bg_type']['toggle'], $new_bg_toggle_option, 'unsplashit'   );

// insert the section at the correct location (last)
\BadabingBreda\array_insert( $row_settings['tabs']['style']['sections'], $new_bg_section, 'bg_unsplashit', $current_num_sections - 1 );

// re-register the row form
\FLBuilder::register_settings_form( 'row' , $row_settings );


/**
 * Enqueue scripts
 * @since 0.1
 */
function bb_rowstyles_scripts_styles() {
	wp_enqueue_style( 'rowstylescss', BBROWSTYLESLITE_URL . 'includes/bb-rowstyles.css', null , BBROWSTYLESLITE_VERSION, 'screen' );
	wp_enqueue_script( 'youtubebg' , BBROWSTYLESLITE_URL . 'includes/jquery.youtubebackground.js' , array('jquery'), BBROWSTYLESLITE_VERSION , false );
}

/**
 * Find out if settings are made to change the template for this row
 * @param  object $row
 * @param  object $groups
 * @since 0.1
 * @return void
 */
function do_before_render_row( $row, $groups ) {

	// only run when row style top OR bottom is set
	if( isset( $row->settings->row_style_top )  || isset( $row->settings->row_style_bottom ) ) {
		// add rowstyle before adding the bg
		add_action( 'fl_builder_before_render_row_bg', __NAMESPACE__ . '\add_row_style' );
	}
}

/**
 * Add Styles to the current row
 * @param object $row
 * @since 0.1
 * @param return void
 */
function add_row_style( $row ) {

	$the_styles = array(
		'bezier_bottom_left' 	=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 0 0 V 100 H 100 Q 50 100 0 0"></path></svg>',
		'bezier_bottom_right'	=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 100 100 H 100 V 0 Q 50 100 0 100"></path></svg>',
		'slanted_top_right'		=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="top"><path xmlns="http://www.w3.org/2000/svg" d="M 0 0 L 100 100 V 0 H 0"></path></svg>',
		'slanted_top_left'		=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="top"><path xmlns="http://www.w3.org/2000/svg" d="M 0 0 V 100 L 100 0 H 0"></path></svg>',
		'slanted_bottom_left'	=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 100 100 H 0 L 100 0 V 100"></path></svg>',
		'slanted_bottom_right'	=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 100 100 H 0 V 0 L 100 100"></path></svg>',
		'round_bottom'			=>	'<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 0 0 L0 100 L100 100 L100 0 Q50 100 00 0 Z"></path></svg>',
		'arch_bottom'			=>  '<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" class="bottom"><path xmlns="http://www.w3.org/2000/svg" d="M 0 0 V 20 Q 50 50 100 20 V 40 Q 50 70 0 40 V 60 Q 50 90 100 60 V 100 H 0 Z"></path></svg>',
	);

	$top_height = ( is_numeric( $row->settings->row_top_height ) )? $row->settings->row_top_height . 'px' : $row->settings->row_top_height;
	$bottom_height = ( is_numeric( $row->settings->row_bottom_height ) ) ? $row->settings->row_bottom_height . 'px' : $row->settings->row_bottom_height;

	if ( isset( $row->settings->row_style_top ) && $row->settings->row_style_top !== 'none' ) {

		echo '<div class="bb-rowstyles row-top">'. $the_styles[$row->settings->row_style_top] .'</div>';
		//print_r($row);
	}

	if ( isset( $row->settings->row_style_bottom ) && $row->settings->row_style_bottom !== 'none' ) {

		echo '<div class="bb-rowstyles row-bottom">'. $the_styles[$row->settings->row_style_bottom] .'</div>';

	}
	if ( $row->settings->image_top !==''  && isset( $row->settings->image_top_src ) && $row->settings->image_top_src !== '' ) {
		echo '<div class="bb-rowstyles sep-image-top"><div class="wrap"><img src="'.$row->settings->image_top_src.'"></div></div>';
	}
	if ( $row->settings->image_bottom !==''  && isset( $row->settings->image_bottom_src ) && $row->settings->image_bottom_src !== '' ) {
		echo '<div class="bb-rowstyles sep-image-bottom"><div class="wrap"><img src="'.$row->settings->image_bottom_src.'"></div></div>';
	}

	if( $row->settings->gradient_overlay !== 'no' ) {
		echo '<div class="bb-rowstyles gradient_overlay"></div>';
	}

	if ($row->settings->bg_type == 'youtube' ) {
		echo '<div class="bb-rowstyles bg-youtube" id="bbytv' . $row->node . '"></div>';
	}

	// remove the action or it will run on all subsequent rows
	remove_action( 'fl_builder_before_render_row_bg' , __NAMESPACE__. '\add_row_style' );

}


/**
 * Get the row gradient style
 * @param  object $row     use the row settings
 * @param  float  $opacity
 * @since  0.1
 * @return string $css
 */
function row_gradient_style ( $row , $opacity = 80 ) {


	$color1_opacity = $color2_opacity = $color3_opacity = ceil($opacity);

	$rgbacol1 = \BadabingBreda\hex2rgba( $row->settings->color1 , $color1_opacity/100 );
	$rgbacol2 = \BadabingBreda\hex2rgba( $row->settings->color2 , $color2_opacity/100 );
	$rgbacol3 = \BadabingBreda\hex2rgba( $row->settings->color3 , $color3_opacity/100 );

	$center = $row->settings->center;

	switch ( $row->settings->gradient_type ) {
		case "diagonal_down":
			$css = "background: -moz-linear-gradient(-45deg, $rgbacol1 0%, $rgbacol2 $center%, $rgbacol3 100%); /* FF3.6-15 */
background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,$rgbacol1), color-stop($center%,$rgbacol2), color-stop(100%,$rgbacol3)); /* Chrome4-9,Safari4-5 */
background: -webkit-linear-gradient(-45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* Chrome10-25,Safari5.1-6 */
background: -o-linear-gradient(-45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* Opera 11.10-11.50 */
background: -ms-linear-gradient(-45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* IE10 preview */
background: linear-gradient(135deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc000000', endColorstr='#00000000',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */";
		break;
		case "diagonal_up":
			$css = "background: -moz-linear-gradient(45deg, $rgbacol1 0%, $rgbacol2 $center%, $rgbacol3 100%); /* FF3.6-15 */
background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,$rgbacol1), color-stop($center%,$rgbacol2), color-stop(100%,$rgbacol3)); /* Chrome4-9,Safari4-5 */
background: -webkit-linear-gradient(45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* Chrome10-25,Safari5.1-6 */
background: -o-linear-gradient(45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* Opera 11.10-11.50 */
background: -ms-linear-gradient(45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* IE10 preview */
background: linear-gradient(45deg, $rgbacol1 0%,$rgbacol2 $center%,$rgbacol3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc000000', endColorstr='#00000000',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */";
		break;
		case "horizontal":
			$css = "background: -moz-linear-gradient(left, $rgbacol1, $rgbacol2 $center%, $rgbacol3); /* FF3.6-15 */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,$rgbacol2), color-stop($center%,$rgbacol2), color-stop(100%,rgba(0,0,0,0))); /* Chrome4-9,Safari4-5 */
background: -webkit-linear-gradient(left, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* Chrome10-25,Safari5.1-6 */
background: -o-linear-gradient(left, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* Opera 11.10-11.50 */
background: -ms-linear-gradient(left, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* IE10 preview */
background: linear-gradient(to right, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc000000', endColorstr='#00000000',GradientType=1 ); /* IE6-9 */";
		break;
		case "vertical":
			$css = "background: -moz-linear-gradient(top, $rgbacol1, $rgbacol2 $center%, $rgbacol3); /* FF3.6-15 */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$rgbacol2), color-stop($center%,$rgbacol2), color-stop(100%,rgba(0,0,0,0))); /* Chrome4-9,Safari4-5 */
background: -webkit-linear-gradient(top, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* Chrome10-25,Safari5.1-6 */
background: -o-linear-gradient(top, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* Opera 11.10-11.50 */
background: -ms-linear-gradient(top, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* IE10 preview */
background: linear-gradient(to bottom, $rgbacol1,$rgbacol2 $center%,$rgbacol3); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc000000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */";
		break;

	}

	return $css;
}

/**
 * Filter callback that loops through $nodes[rows] and returns css needed for the inline css
 * @param string $css
 * @param object $nodes
 * @param array $global_settings
 * @todo tidy up some more, move fixed css to css-file
 * @since 0.1
 * @return string $css
 */
function add_row_style_css ( $css , $nodes , $global_settings ) {

	// Loop through rows
	foreach( $nodes['rows'] as $row ) {

	$top_height = ( is_numeric( $row->settings->row_top_height ) ) ? $row->settings->row_top_height . 'px' : $row->settings->row_top_height;
	$bottom_height = ( is_numeric( $row->settings->row_bottom_height ) ) ? $row->settings->row_bottom_height . 'px' : $row->settings->row_bottom_height;

		// set the padding for the nodes
		$css .= '.fl-node-'. $row->node .' .fl-row-content-wrap { ';
		$css .= ( $row->settings->row_style_top !== 'none' )?'padding-top:' . $top_height . ';': '';
		$css .= ( $row->settings->row_style_bottom !== 'none' )?'padding-bottom:' . $bottom_height . ';':'';
		$css .= '}';

		$css .= '.fl-node-'. $row->node .' .fl-row-content-wrap .sep-image-top {';
		$css .= ( $row->settings->row_style_top !== 'none' )?'padding-top:' . $top_height . ';':'';
		$css .= 'z-index:60;';
		$css .= '}';

		$css .= '.fl-node-'. $row->node .' .fl-row-content-wrap .sep-image-bottom {';
		$css .= ( $row->settings->row_style_bottom !== 'none' )?'padding-bottom:' . $bottom_height . ';':'';
		$css .= 'z-index:60;';
		$css .= '}';

		// set this nodes svg top css
		$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap .bb-rowstyles.row-top {';
		$css .= 'height: '. $top_height .';';
		$css .= '}';
		$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap svg.top {';
		$css .= 'fill:#'.$row->settings->fill_top.';';
		$css .= '}';

		// set this nodes svg bottom css
		$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap .bb-rowstyles.row-bottom {';
		$css .= 'height: '. $bottom_height .';';
		$css .= '}';
		$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap svg.bottom {';
		$css .= 'fill:#'.$row->settings->fill_bottom.';';
		$css .= '}';

		if ($row->settings->gradient_overlay !== 'no' ) {

			// convert any number to something between 0 and 100
			$opacity = ( abs( ( integer ) $row->settings->overlay_opacity ) % 100 );

			$css .= '.fl-node-' . $row->node . ' .gradient_overlay {';
			$css .= \BadabingBreda\row_gradient_style( $row, $opacity );
			$css .= '}';
			$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap .fl-row-content {';
			$css .= 'z-index:100;position:relative;';
			$css .= '}';
		}

		// do we need to set the bg_image
		if ( $row->settings->bg_type == 'unsplashit' ) {
			$css .= '.fl-node-' . $row->node . '.fl-row-bg-unsplashit .fl-row-content-wrap {';
			//$css .= sprintf('background-image: url(https://unsplash.it/%s/%s/);', $row->settings->sizex , $row->settings->sizey );
			$css .=		'background-image:url("https://unsplash.it/' . ( $row->settings->grayscale === 'true' ?'g/':'') .
						 $row->settings->sizex . '/' . $row->settings->sizey . '/?' .
						(( $row->settings->unsplashid=='' && $row->settings->random === 'true' ) ? 'random&':'') .
						( $row->settings->unsplashid ? 'image=' . $row->settings->unsplashid . '&' : '' ) .
						( $row->settings->blurred === 'true' ? 'blur&' : '' ) . '");';
			$css .= 'background-position: '.$row->settings->halign.' '.$row->settings->valign.';';
			$css .= 'background-size: cover;';
			$css .= '}';
		}

		if ( $row->settings->bg_type == 'youtube' ) {
			$css .= '.fl-node-' . $row->node . '.fl-row-bg-youtube .bg-youtube {' ;
			$css .= '	position:absolute;left:0;top:0;width:100%;height:100%;z-index:10;overflow:hidden;';
			$css .= '}';
			$css .= '.fl-node-' . $row->node . ' .bbytcontainer { position: absolute; z-index: -1; }';
			if ( isset( $row->settings->youtube_placeholder ) && $row->settings->youtube_placeholder_src !== null ) {
				$css .= '.fl-node-' . $row->node . ' .ytphimage {display: block;background:url(' . $row->settings->youtube_placeholder_src .') no-repeat center center; background-size:cover;width:100%;height:100%;position:absolute;top:0;left:0;z-index:20;}';
				$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap .fl-row-content {';
				$css .= 'z-index:100;';
				$css .= '}';
			}
		}

	}

	return $css;
}

/**
 * Callback for the fl_builder_render_js filter, adds js to the layout-js cache
 * @param string $js              [description]
 * @param object $nodes           [description]
 * @param object $global_settings [description]
 * @since  0.2
 * @return  string $js
 */
function add_row_style_js ( $js , $nodes , $global_settings ) {
	// Loop through rows
	foreach( $nodes['rows'] as $row ) {

		if ( $row->settings->bg_type == 'youtube' ) {
			$js .= "
				(function ($) {	$( document ).ready( function() {
							$('#bbytv" . $row->node . "').YTPlayer({ fitToBackground: false, videoId: '" . $row->settings->youtubeid . "', start: " . $row->settings->youtube_start . ", playfor: " . $row->settings->youtube_playfor . " });
						} ); })(jQuery);";
		}
	}
	return $js;
}
