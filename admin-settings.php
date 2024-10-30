<?php
namespace jhljs;

if ( ! defined( 'ABSPATH' ) ) { return; }

/* ADD ADMIN PAGE */
add_action('admin_menu', __NAMESPACE__ . '\\menu');
function menu() {
    add_submenu_page('options-general.php',
        'Lightweight JS snippet',
        'Lightweight JS snippet',
        'manage_options',
        'jhljs-settings',
        __NAMESPACE__ . '\\submenu_page_callback' );
    add_action( 'admin_init', __NAMESPACE__ . '\\plugin_settings' );
}

/* REGISTER SETTINGS */
function plugin_settings() {
    register_setting( 'jhljs-settings-group', 'jhljs-post' );
	register_setting( 'jhljs-settings-group', 'jhljs-script' );
}

/* SHOW ADMIN PAGE */
function submenu_page_callback() {
?>
<style>
    form {
        max-width: 600px;
    }
    section {
        margin-bottom: 60px;
    }
    h3 {
        margin-top: 20px;
        font-size: 13px;
    }
    input[type='text'],
    input[type='number'] {

        margin-bottom:10px;
    }
</style>
<div class="wrap">
<h1>Lightweight JS snippet</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'jhljs-settings-group' ); ?>
    <?php do_settings_sections( 'jhljs-settings-group' ); ?>
    <section>
        <h2><?php _e('General Settings'); ?></h2>
        <p><?php _e("Add a JavaScript to be appended to a specific page or post.", 'jhljs'); ?></p>
        
        <div>
            <h3>Posts/pages to add the script</h3>
            <i style='display:block'>Enter one post id or a comma separated list of ids.</i>
            <?php $post = get_option('jhljs-post'); ?>
            <input id="jhljs-post" type="text" size="36" name="jhljs-post" value="<?php echo esc_attr( $post ); ?>" />
        </div>
        
        <h3><?php _e('Add script here, without the wrapping script tags', 'jhljs'); ?></h3>
        <textarea id="jhljs-script" name="jhljs-script" style="width: 600px; max-width: 100%; height: 200px;"><?php echo wp_kses( get_option('jhljs-script'), 'data' ); ?></textarea>
    </section>

    <?php submit_button(); ?>

</form>
</div>
<?php } 




/* add settingslink in plugin-list */
add_filter( 'plugin_action_links_fabolous-login-screen/fabolous-login-screen.php', __NAMESPACE__ . '\\settings_link' );
function settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( add_query_arg(
		'page',
		'jhljs-submenu-page',
		get_admin_url() . 'options-general.php'
	) );
	// Create the link.
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	// Adds the link to the end of the array.
	array_push(
		$links,
		$settings_link
	);
    
	return $links;
}


// load script to admin
function admin_head() {
    // TODO: add ajax to fetch post id
}
add_action('admin_head', __NAMESPACE__ . '\\admin_head');


// add code editor
// from https://www.ibenic.com/wordpress-code-editor/
function add_page_scripts_enqueue_script( $hook ) {
 
    if( $_REQUEST['page'] == 'jhljs-settings' ) {
        wp_enqueue_code_editor( array( 'type' => 'text/javascript' ) );
        wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/js/code-editor.js', array( 'jquery' ), '', true );
    }
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\add_page_scripts_enqueue_script' );
