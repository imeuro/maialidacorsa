<?php
/**
 * @package MDC_2020
 * @version 1.0.1
 */
/*
Plugin Name: Maiali Da corsa 2020
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of me while doing for the 4th time the website for Maiali Da Corsa.
Author: Mauro Fioravanzi
Version: 1.0.1
Author URI: http://imeuro.io/
*/

/////////////////////////////////////////////////////////////
// enqueue custom css and js
function mdc2020_files() { 
    if (is_front_page()) {
    	// SWIPER css e js - https://swiperjs.com/get-started/
    	wp_enqueue_style('swiper', "https://unpkg.com/swiper@8/swiper-bundle.min.css");
		wp_enqueue_script( 'swiper', "https://unpkg.com/swiper@8/swiper-bundle.min.js", array(), '1.0.0', true );
    }
    wp_enqueue_script( 'fslightbox', get_template_directory_uri() . '/js/fslightbox.js', array(), '1.0.0', true );
    wp_enqueue_style('mdc2020_main', get_template_directory_uri() . "/css/mdc2020.css");
    wp_enqueue_script( 'mdc2020_main', get_template_directory_uri() . '/js/mdc2020.js', array('fslightbox'), '1.0.0', true );
} 

//add_action('wp_enqueue_scripts', 'mdc2020_files');
//--> per ultimi: https://wordpress.stackexchange.com/questions/57386/how-do-i-force-wp-enqueue-scripts-to-load-at-the-end-of-head
add_action('wp_print_styles', 'mdc2020_files'); 


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


// https://wpmayor.com/check-if-a-page-has-any-children-or-subpages/
function has_children($post_type="post",$post_id) {
    $children = get_pages("child_of=$post_id,post_type=$post_type");
    if( count( $children ) != 0 ) { echo 'si'; return true; } // Has Children
    else {  echo 'no'; return false; } // No children
}



/////////////////////////////////////////////////////////////




// Register Custom Post Type(s)
function mdc2020_CPT() {

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
        'capability_type'       => 'post',
        'rewrite'               => array(
            'slug'                  => 'albums',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        ),
	);
	register_post_type( 'albums', $args );

}
add_action( 'init', 'mdc2020_CPT', 0 );

add_post_type_support( 'page', 'excerpt' );

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
function mdc2020_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'mdc2020_disable_comments_post_types_support');
// Close comments on the front-end
function mdc2020_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'mdc2020_disable_comments_status', 20, 2);
add_filter('pings_open', 'mdc2020_disable_comments_status', 20, 2);
// Hide existing comments
function mdc2020_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'mdc2020_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function mdc2020_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'mdc2020_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function mdc2020_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'mdc2020_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function mdc2020_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'mdc2020_disable_comments_dashboard');
// Remove comments links from admin bar
function mdc2020_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'mdc2020_disable_comments_admin_bar');


/////////////////////////////////////////////////////

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );




/////////////////////////////////////////////////////

// PRINT ALBUMS LIST

function MDCAlbums_categories_and_posts( $parent_cat ) {
	$parent_cat = $parent_cat;
	$parent_cat_id	= get_category_by_slug($parent_cat)->term_id;
    $taxonomy   = 'category';
    $post_type  = 'albums';

    // Get the top categories that belong to the provided taxonomy (the ones without parent)
	$cat_args = array(
	    'parent'		=> $parent_cat_id, // single_level in depth
	    // 'child_of'	=> $parent_cat_id,  // multi_level in depth
	    'orderby'		=> 'term_id',
	    'order'			=> 'DESC',
    	'hide_empty'	=> true
	); 
    $categories = get_terms($taxonomy, $cat_args);

    // echo '-------';
    // print_r($categories);
    // die();

	// Iterate through all categories to display each individual category
	foreach ( $categories as $category ) {

	    $cat_name = $category->name;
	    $cat_id   = $category->term_id;
	    $cat_slug = $category->slug;

	    // Display the name of each individual category with ID and Slug
	    echo '<ul class="mdc-fotolist">';
	    echo '<li class="mdc-fotolist-title-year"><h3 class="mdc-fotolist-year">'.$cat_name.'</h3>';

	    // Get all posts that belong to this specific category
	    $posts = new WP_Query(
	        array(
	            'post_type'      => $post_type,
	            'posts_per_page' => -1, // <-- Show all posts
	            'hide_empty'     => true,
	            'order'          => 'DESC',
	            'tax_query'      => array(
	                array(
	                    'taxonomy' => $taxonomy,
	                    'terms'    => $cat_id,
	                    'field'    => 'id'
	                )
	            )
	        )
	    );

	    // If there are posts available within this subcategory
	    if ( $posts->have_posts() ):
	    ?>
	    <ul class="mdc-fotolist-thumbs">
	        <li>
	        	<ul>
	            <?php

	            // As long as there are posts to show
	            while ( $posts->have_posts() ): $posts->the_post();

	            //Show the thumb of each post with the Post Title
	            $fotolist_thumb_url = get_the_post_thumbnail_url($posts->ID,'medium_large');
	            ?>
				<li class="mdc-fotolist-item"><a style="background-image:url(<?php echo $fotolist_thumb_url ?>)" href="<?php echo get_permalink($posts->ID) ?>"><span><?php the_title(); ?></span></a></li>
	            <?php
	            endwhile;
	            ?>
	        	</ul>
	        </li>
	    </ul>
	    <?php
	    endif;
	    echo '</li></ul>';
	    wp_reset_query();
	}
}





function doctype_opengraph($output) {
    return $output . '
    xmlns:og="http://opengraphprotocol.org/schema/"
    xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'doctype_opengraph');

function fb_opengraph() {
    global $post;

    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = 'https://www.maialidacorsa.it/wp-content/uploads/2020/01/icon-mdc.png';
        }
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        }
        ?>
 
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $excerpt; ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src; ?>"/>
 
<?php
    } else {
        return;
    }
}
add_action('wp_head', 'fb_opengraph', 5);
