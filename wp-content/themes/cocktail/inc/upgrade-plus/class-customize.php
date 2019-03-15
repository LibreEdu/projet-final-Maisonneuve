<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0
 * @access public
 */
final class cocktail_Customize {

	/**
	 * Returns the instance.
	 *
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require get_template_directory() . '/inc/upgrade-plus/section-pro.php';

		// Register custom section types.
		$manager->register_section_type( 'Cocktail_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Cocktail_Customize_Section_Pro(
				$manager,
				'cocktail',
				array(
					'title'    => esc_html__( 'Cocktail', 'cocktail' ),
					'pro_text' => esc_html__( 'Upgrade To Plus',         'cocktail' ),
					'pro_url'  => 'https://themefreesia.com/plugins/cocktail-plus/',
					'priority' => 1
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'cocktail-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/js/customizer-custom-scripts.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'cocktail-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/js/cocktail-customizer.css' );
	}
}

// Doing this customizer thang!
cocktail_Customize::get_instance();
