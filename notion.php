<?php
/**
 * Plugin Name: Notion Frontend
 * Description: Simple hello world widgets for Elementor.
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-addon
 */

function register_hello_world_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/hello-world-widget-1.php' );
	require_once( __DIR__ . '/widgets/hello-world-widget-2.php' );

	$widgets_manager->register( new \Elementor_Hello_World_Widget_1() );
	$widgets_manager->register( new \Elementor_Hello_World_Widget_2() );

}
add_action( 'elementor/widgets/register', 'register_hello_world_widget' );


function notion_settings_init() {

	register_setting( 'notion', 'notion_options' );

	add_settings_section(
		'notion_section_developers',
		__( 'Put the Notion Secret Key.', 'notion' ), 'notion_section_developers_callback',
		'notion'
	);

	
	add_settings_field(
		'notion_field_secretkey',
			__( 'Secret Key', 'notion' ),
		'notion_field_secretkey_cb',
		'notion',
		'notion_section_developers'
	);
}

add_action( 'admin_init', 'notion_settings_init' );

function notion_section_developers_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'notion' ); ?></p>
	<?php
}

function notion_field_secretkey_cb( $args ) {
	
	$options = get_option( 'notion_options' );
	?>
	<input type="text" name="notion_options" value="<?= esc_attr($options);?>">
	
	<p class="description">
		<?php esc_html_e( 'You take the blue secretkey and the story ends. You wake in your bed and you believe whatever you want to believe.', 'notion' ); ?>
	</p>
	<input type="text" name="database_id" value="8b7bb9a6068647e88cd5cb16ffc01848?v=be8f604f39184e3aaa989cc7c618724d">
	<?php
}

function notion_options_page() {
	add_menu_page(
		'Notion Integration',
		'Notion Options',
		'manage_options',
		'notion',
		'notion_options_page_html'
	);
}

add_action( 'admin_menu', 'notion_options_page' );



function notion_options_page_html() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	
	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'notion_messages', 'notion_message', __( 'Settings Saved', 'notion' ), 'updated' );
	}


	settings_errors( 'notion_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			
			settings_fields( 'notion' );
			
			do_settings_sections( 'notion' );
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<div class="wrap">
		<h2>Sync with Notion</h2>
		<button class="button button-primary">Sync</button>
	</div>
	<?php
}

function wpdocs_selectively_enqueue_admin_script($hook) {

	wp_register_script( 'some-js',  plugin_dir_url( __FILE__ ).'/assets/js/main.js', array('jquery-core'), false, true );
    wp_enqueue_script( 'some-js' );
}

add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );

add_filter('script_loader_tag', 'moduleTypeScripts', 10, 2);
function moduleTypeScripts($tag, $handle)
{
   
	$tag = str_replace('src', 'type="module" src', $tag);
    return $tag;
}