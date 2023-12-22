<?php

use Platonic\API\Settings;
use Platonic\API\Settings_Page_Rules;

/**
 * INTRODUCTION
 *
 * This is an example of how to create your own settings page
 * in a simplified way using the Platonic API.
 *
 * The Platonic API is a wrapper for the WordPress Settings API,
 * based on an Object-Oriented Programming approach.
 *
 * You would replace the name of this class with your own,
 * extend the Platonic\API\Settings class, and
 * implement the Settings_Page_Rules interface.
 *
 * This example class contains some methods that are 100% optional.
 * These methods are advanced usage examples, and they are not required
 * at all, so feel free to skip them. Don't let them overwhelm you,
 * it is really easy to create your settings page with the Platonic API.
 *
 * There are only 2 required methods: add_admin_menu() and register_settings()
 *
 */
class Settings_Page_Example extends Settings implements Settings_Page_Rules
{
	protected $option_group = 'your_option_group';
	protected $option_name = 'your_option_name';

	/**
	 * OPTIONAL - Skip this method if this is your first time.
	 *
	 * The constructor is not necessary, however, you can create it to add some actions to manage options
	 * when your plugin is activated/deactivated/uninstalled or when your theme is switched.
	 *
	 * If you do create it, don't forget to call the parent's __construct() inside it.
	 */
	public function __construct()
	{
		// This is a MUST inside the constructor!
		parent::__construct();

		// This actions are entirely optional.
		// They could be useful if you are creating the settings for a theme.
		add_action( 'switch_theme', array( $this, 'on_theme_deactivation' ) );
		add_action( 'after_switch_theme', array( $this, 'on_theme_activation' ) );

		// For plugins, you could register your activation, deactivation, and uninstall hooks.
		// https://developer.wordpress.org/plugins/plugin-basics/activation-deactivation-hooks/
		//https://developer.wordpress.org/reference/functions/register_uninstall_hook/
		register_activation_hook( __FILE__, array( $this, 'on_plugin_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'on_plugin_deactivation' ) );
		register_uninstall_hook( __FILE__, array( $this, 'on_plugin_uninstall' ) );
	}

	/**
	 * Add admin menu
	 */
	public function add_admin_menu()
	{
		$this->add_options_page(
			__( 'Page Title', 'your-text-domain' ),
			__( 'Menu Title', 'your-text-domain' ),
			'menu_slug'
		);
	}

	public function register_settings()
	{
		// The parent class will register the settings in the database.
		parent::register_settings();

		// Register your sections and fields
		$this->add_settings_section(
			'first_section',
			__( 'First Section Title', 'your-text-domain' ),
			__( 'This is the description for this section', 'your-text-domain' )
		);

		$this->add_settings_field(
			'text_field_example',
			'first_section',
			__( 'Text Field Title', 'your-text-domain' ),
			__( 'Description for your text field.', 'your-text-domain' ),
			'text'
		);

		$this->add_settings_field(
			'email_field_example',
			'first_section',
			__( 'Email Field Title', 'your-text-domain' ),
			__( 'Description for your email field.', 'your-text-domain' ),
			'email'
		);

		$this->add_settings_field(
			'color_field_example',
			'first_section',
			__( 'Color Field Title', 'your-text-domain' ),
			__( 'Description for your color field.', 'your-text-domain' ),
			'color'
		);

		$this->add_settings_field(
			'checkbox_field_example',
			'first_section',
			__( 'Checkbox Field Title', 'your-text-domain' ),
			__( 'Description for your checkbox field.', 'your-text-domain' ),
			'checkbox'
		);

		$this->add_settings_section(
			'second_section',
			__( 'Second Section Title', 'your-text-domain' ),
			__( 'This is the description for this section', 'your-text-domain' )
		);

		$this->add_settings_field(
			'file_example',
			'second_section',
			__( 'File Field Title', 'your-text-domain' ),
			__( 'Description for your file selector.', 'your-text-domain' ),
			'file'
		);

		$this->add_settings_field(
			'radio_example',
			'second_section',
			__( 'Radio Buttons Title', 'your-text-domain' ),
			__( 'Description for your radio buttons.', 'your-text-domain' ),
			'radio',
			array(
				'options' => array(
					'first_value'  => __( 'Label for your first radio button', 'your-text-domain' ),
					'second_value' => __( 'Label for your second radio button', 'your-text-domain' ),
					'third_value'  => __( 'Label for your third radio button', 'your-text-domain' )
				)
			)
		);

		$this->add_settings_field(
			'select_example',
			'second_section',
			__( 'Select Title', 'your-text-domain' ),
			__( 'Description for your select dropdown.', 'your-text-domain' ),
			'select',
			array(
				'options' => array(
					'first_value'  => __( 'Label for your first option', 'your-text-domain' ),
					'second_value' => __( 'Label for your second option', 'your-text-domain' ),
					'third_value'  => __( 'Label for your third option', 'your-text-domain' )
				)
			)
		);
	}

	/**
	 * OPTIONAL - This is not required
	 *
	 * Add this function only if you have created the constructor
	 * and added the action that calls this method.
	 *
	 *
	 */
	function on_theme_activation()
	{
		$updated_options = array(
			'text_field_example' => $this->get_option( 'text_field_example', 'Default value if option not previously set' ),
		);
		//update_option( $this->option_name, $updated_options );
	}

	/**
	 * Add this function only if you have created the constructor
	 */
	function on_theme_deactivation()
	{
		//delete_option( $this->option_name );
	}
}