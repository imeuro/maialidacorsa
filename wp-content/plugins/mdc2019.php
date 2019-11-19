<?php
/**
 * @package MDC_2019
 * @version 1.0.0
 */
/*
Plugin Name: Maiali Da corsa 2019
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of me while doing for the 4th time the website for Maiali Da Corsa.
Author: Mauro Fioravanzi
Version: 1.0.0
Author URI: http://imeuro.io/
*/

/////////////////////////////////////////////////////////////
// enqueue custom css and js
function mdc2019_files() { 
    if (is_front_page()) {
    	// SWIPER css e js - https://swiperjs.com/get-started/
    	wp_enqueue_style('swiper', "https://unpkg.com/swiper/css/swiper.min.css");
		wp_enqueue_script( 'swiper', "https://unpkg.com/swiper/js/swiper.min.js", array(), '1.0.0', true );
    }
    wp_enqueue_script( 'fslightbox', get_template_directory_uri() . '/js/fslightbox.js', array(), '1.0.0', true );
    wp_enqueue_style('mdc2019_main', get_template_directory_uri() . "/css/mdc2019.css");
    wp_enqueue_script( 'mdc2019_main', get_template_directory_uri() . '/js/mdc2019.js', array('fslightbox'), '1.0.0', true );
} 

//add_action('wp_enqueue_scripts', 'mdc2019_files');
//--> per ultimi: https://wordpress.stackexchange.com/questions/57386/how-do-i-force-wp-enqueue-scripts-to-load-at-the-end-of-head
add_action('wp_print_styles', 'mdc2019_files'); 


// load ContactForm7 css&js conditionally
// https://techjourney.net/load-contact-form-7-cf7-js-css-conditionally-only-on-selected-pages/
// remove default:
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
// load only in selected pages:
add_action('wp_enqueue_scripts', 'load_wpcf7_scripts');
function load_wpcf7_scripts() {
    if ( is_page(array(4326,4330)) ) {
        if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
            wpcf7_enqueue_scripts();
        } 
        if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
            wpcf7_enqueue_styles();
        }
    }
}

/////////////////////////////////////////////////////////////




// Register Custom Post Type(s)
function mdc2019_CPT() {

	$labels = array(
		'name'                  => _x( 'Albums', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Album', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Albums', 'text_domain' ),
		'name_admin_bar'        => __( 'Albums', 'text_domain' ),
		'archives'              => __( 'Archivio Albums', 'text_domain' ),
		'attributes'            => __( 'Attributi Album', 'text_domain' ),
		'parent_album_colon'     => __( 'Parent Album:', 'text_domain' ),
		'all_albums'             => __( 'All Albums', 'text_domain' ),
		'add_new_album'          => __( 'Add New Album', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_album'              => __( 'New Album', 'text_domain' ),
		'edit_album'             => __( 'Edit Album', 'text_domain' ),
		'update_album'           => __( 'Update Album', 'text_domain' ),
		'view_album'             => __( 'View Album', 'text_domain' ),
		'view_albums'            => __( 'View Albums', 'text_domain' ),
		'search_albums'          => __( 'Search Album', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_album'      => __( 'Insert into album', 'text_domain' ),
		'uploaded_to_this_album' => __( 'Uploaded to this album', 'text_domain' ),
		'albums_list'            => __( 'Albums list', 'text_domain' ),
		'albums_list_navigation' => __( 'Albums list navigation', 'text_domain' ),
		'filter_albums_list'     => __( 'Filter albums list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'albums', 'text_domain' ),
		'description'           => __( 'Calendario Albums', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'category' ),
		// 'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_rest'          => true, // To use Gutenberg editor.
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'rewrite'               => array(
            'slug'                  => 'albums',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        ),
	);
	register_post_type( 'albums', $args );

}
add_action( 'init', 'mdc2019_CPT', 0 );

/////////////////////////////////////////////////////////////

function rename_posts() {
    global $menu;
     
	$menu[5][0] = 'News'; // Change Posts to News
	$submenu['edit.php'][5][0] = 'Tutte le News';
    $submenu['edit.php'][10][0] = 'Aggiungi News';
}
add_action( 'admin_menu', 'rename_posts' );

/////////////////////////////////////////////////////////////


function my_gallery_default_type_set_link( $settings ) {
$settings['galleryDefaults']['link'] = 'file';
$settings['galleryDefaults']['size'] = 'medium';
$settings['galleryDefaults']['columns'] = '3';
return $settings;
}
add_filter( 'media_view_settings', 'my_gallery_default_type_set_link');


/////////////////////////////////////////////////////////////

// Disable support for comments and trackbacks in post types
function mdc2019_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'mdc2019_disable_comments_post_types_support');
// Close comments on the front-end
function mdc2019_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'mdc2019_disable_comments_status', 20, 2);
add_filter('pings_open', 'mdc2019_disable_comments_status', 20, 2);
// Hide existing comments
function mdc2019_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'mdc2019_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function mdc2019_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'mdc2019_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function mdc2019_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'mdc2019_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function mdc2019_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'mdc2019_disable_comments_dashboard');
// Remove comments links from admin bar
function mdc2019_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'mdc2019_disable_comments_admin_bar');


/////////////////////////////////////////////////////

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
