<?php

/*  Menu Support
/* ------------------------------------ */ 

	add_action( 'init', 'my_custom_menus' );
	  function my_custom_menus() {
	     register_nav_menus(
	        array(
	  		'primary-menu' => __( 'Primary Menu' ),
	  		'secondary-menu' => __( 'Secondary Menu' )
	                )
	         );
	  }

/*  Register sidebars and widgetized areas.
/* ------------------------------------ */ 

function instabar_widgets_init() {

  register_sidebar( array(
    'name'          => 'Instagram right sidebar',
    'id'            => 'instagram_right_1',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="sidebar_title">',
    'after_title'   => '</h2>',
  ) );

}
add_action( 'widgets_init', 'instabar_widgets_init' );

function instafooter_widgets_init() {

  register_sidebar( array(
    'name'          => 'Instagram Footer',
    'id'            => 'instagram_footer_1',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="sidebar_title">',
    'after_title'   => '</h2>',
  ) );

}
add_action( 'widgets_init', 'instafooter_widgets_init' );

function cat_widgets_init() {

  register_sidebar( array(
    'name'          => 'Category right sidebar',
    'id'            => 'cat_right_1',
    'before_widget' => '<div class="category_container">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="sidebar_title">',
    'after_title'   => '</h2>',
  ) );

}
add_action( 'widgets_init', 'cat_widgets_init' );


/*  Post Thumbnail Support
/* ------------------------------------ */ 
  add_theme_support( 'post-thumbnails' ); 

/*  Remove Admin Bar
/* ------------------------------------ */ 
	add_filter('show_admin_bar', '__return_false');

/*  Custom Excerpt
/* ------------------------------------ */ 
function new_excerpt_more( $more ) {
  return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*  Enqueue scripts
/* ------------------------------------ */ 

  function jquery_enqueue() {
      wp_deregister_script('jquery');
      wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, null);
      wp_enqueue_script('jquery');
  }
  if (!is_admin()) add_action('wp_enqueue_scripts', 'jquery_enqueue', 11);


	function wpb_adding_scripts() {

		$vars = "value";
	  wp_register_script('what', get_stylesheet_directory_uri() . '/bower_components/what-input/what-input.js');
    wp_register_script('foundation', get_stylesheet_directory_uri() . '/bower_components/foundation-sites/dist/foundation.js');
    wp_register_script('rss', get_stylesheet_directory_uri() . '/js/jquery.rss.js');
	  wp_register_script('app', get_stylesheet_directory_uri() . '/js/app.js');
    wp_register_script('moment', get_stylesheet_directory_uri() . '/js/moment.min.js');
	  wp_register_script('mapbox', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.js');

	  wp_enqueue_script('what');
	  wp_enqueue_script('foundation');
	  wp_enqueue_script('app');
	  wp_enqueue_script('mapbox');
    wp_enqueue_script('moment');
    wp_enqueue_script('rss');
	}
	add_action( 'wp_footer', 'wpb_adding_scripts' ); 


include(locate_template('inc/walker.php'));

/*  Theme Options Page
/* ------------------------------------ */ 


  function add_theme_menu_item()
  {
    add_menu_page("Shop Options", "Shop Options", "manage_options", "theme-panel", "theme_settings_page", null, 99);
  }

  add_action("admin_menu", "add_theme_menu_item");



  function theme_settings_page()
  {
      ?>
        <div class="wrap">
        <h1>Shop Options</h1>
        <form method="post" action="options.php" class="theme_options">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
      </div>
    <?php
  }

  function hours_line_1()
  {
    ?>  
        <input type="text" name="hours_line_1" id="hours_line_1" value="<?php echo get_option('hours_line_1'); ?>" />      
      <?php
  }

  function hours_line_2()
  {
    ?>
        <input type="text" name="hours_line_2" id="hours_line_2" value="<?php echo get_option('hours_line_2'); ?>" />
      <?php
  }

  function hours_line_3()
  {
    ?>
        <input type="text" name="hours_line_3" id="hours_line_3" value="<?php echo get_option('hours_line_3'); ?>" />
      <?php
  }

  function phone_number()
  {
    ?>
        <input type="text" name="phone_number" id="phone_number" value="<?php echo get_option('phone_number'); ?>" />
      <?php
  }

  function display_theme_panel_fields()
  {
    add_settings_section("section", "Confluence Shop Settings", null, "theme-options");

    add_settings_field("phone_number", "Phone Number", "phone_number", "theme-options", "section");
    add_settings_field("hours_line_1", "Hours Line 1", "hours_line_1", "theme-options", "section");
    add_settings_field("hours_line_2", "Hours Line 2", "hours_line_2", "theme-options", "section");
    add_settings_field("hours_line_3", "Hours Line 3", "hours_line_3", "theme-options", "section");


    register_setting("section", "phone_number");
    register_setting("section", "hours_line_1");
    register_setting("section", "hours_line_2"); 
    register_setting("section", "hours_line_3");   
  }

  add_action("admin_init", "display_theme_panel_fields");

  add_action('admin_head', 'my_custom_admin_css');

  function my_custom_admin_css() {
    echo '<style>
      form input[type=text]{width:50%;}
    </style>';
  }


/* Custom Post Types ------------------------------------ */ 

// ----------------- Creates Testimonial Post Type
add_action('init', 'post_type_testi');
function post_type_testi() 
{
  $labels = array(
    'name' => _x('Testimonials', 'post type general name'),
    'singular_name' => _x('Testimonial', 'post type singular name'),
    'add_new' => _x('Add New Testimonial', 'testi'),
    'add_new_item' => __('Add New Testimonial')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'testi' ),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title')
    ); 
  register_post_type('testi',$args);
  flush_rewrite_rules();
}; 

// ----------------- Creates Event Post Type
add_action('init', 'post_type_event');
function post_type_event() 
{
  $labels = array(
    'name' => _x('Classes', 'post type general name'),
    'singular_name' => _x('Class', 'post type singular name'),
    'add_new' => _x('Add New Class', 'event'),
    'add_new_item' => __('Add New Class')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'event' ),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title')
    ); 
  register_post_type('event',$args);
  flush_rewrite_rules();
}; 

// ----------------- Creates Staff Post Type
add_action('init', 'post_type_staff');
function post_type_staff() 
{
  $labels = array(
    'name' => _x('Staff', 'post type general name'),
    'singular_name' => _x('Staff', 'post type singular name'),
    'add_new' => _x('Add New Staff Member', 'staff'),
    'add_new_item' => __('Add New Staff Member')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'staff' ),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title')
    ); 
  register_post_type('staff',$args);
  flush_rewrite_rules();
}; 

// ----------------- Creates Report Post Type
add_action('init', 'post_type_report');
function post_type_report() 
{
  $labels = array(
    'name' => _x('Fishing Reports', 'post type general name'),
    'singular_name' => _x('Fishing Report', 'post type singular name'),
    'add_new' => _x('Add New Fishing Report', 'report'),
    'add_new_item' => __('Add New Fishing Report')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'report' ),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title','excerpt', 'thumbnail')
    ); 
  register_post_type('report',$args);
  flush_rewrite_rules();
};  

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category Confluence
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

require_once 'cmb/init.php';

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function cmb2_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

add_filter( 'cmb2_meta_boxes', 'cmb2_lmc_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_lmc_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb2_';

  /**
   * Testimonial Metabox Layout
   */
  $meta_boxes['testi_metabox'] = array(
    'id'            => 'testi_metabox',
    'title'         => __( 'Testimonials', 'cmb2' ),
    'object_types'  => array( 'testi' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      
      array(
        'name'    => __( 'Client Quote', 'cmb2' ),
        'id'      => $prefix . 'client_quote',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 10, ),
      ),
      array(
        'name'    => __( 'Client Name', 'cmb2' ),
        'id'      => $prefix . 'client_name',
        'type' => 'text_medium',
      )
    )
  );

  /**
   * Events Metabox Layout
   */
  $meta_boxes['events_metabox'] = array(
    'id'            => 'events_metabox',
    'title'         => __( 'Events and Classes', 'cmb2' ),
    'object_types'  => array( 'event' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the leftd
    'fields'        => array(
      
      array(
        'name'    => __( 'Class Description', 'cmb2' ),
        'id'      => $prefix . 'description',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 10, ),
      ),
      array(
        'name'    => __( 'Location', 'cmb2' ),
        'id'      => $prefix . 'location',
        'type' => 'text_medium',
      ),     
      array(
        'name'    => __( 'Cost', 'cmb2' ),
        'id'      => $prefix . 'cost',
        'type' => 'text_medium',
      )
    )
  );

  /**
   * Staff Metabox Layout
   */
  $meta_boxes['staff_metabox'] = array(
    'id'            => 'staff_metabox',
    'title'         => __( 'Staff', 'cmb2' ),
    'object_types'  => array( 'staff' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      
      array(
        'name'    => __( 'Title', 'cmb2' ),
        'id'      => $prefix . 'title',
        'type' => 'text_medium',
      ),
      
      array(
        'name'    => __( 'Bio', 'cmb2' ),
        'id'      => $prefix . 'bio',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 10, ),
      ),
      array(
        'name' => __( 'Profile Image', 'cmb2' ),
        'desc' => __( 'Upload a landscape oriented image or enter a URL.', 'cmb2' ),
        'id'   => $prefix . 'staff_image',
        'type' => 'file',
      ),
      array(
        'name' => __( 'Profile Thumbnail', 'cmb2' ),
        'desc' => __( 'Upload a square image or enter a URL.', 'cmb2' ),
        'id'   => $prefix . 'staff_thumb',
        'type' => 'file',
      )
    )
  );




	/**
	 * Fishing Report Metabox Layout
	 */
	$meta_boxes['report_metabox'] = array(
		'id'            => 'report_metabox',
		'title'         => __( 'Fishing Report', 'cmb2' ),
		'object_types'  => array( 'report' ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'fields'        => array(
			
      array(
        'name'    => __( 'Sub-title', 'cmb2' ),
        'id'      => $prefix . 'sub_title',
        'type' => 'text_medium',
      ),
      array(
        'name'    => __( 'Display Bonneville Steelhead Count', 'cmb2' ),
        'desc'  => __( 'Checking box adds Steelhead Count to sidebar ', 'cmb2' ),
        'id'   => $prefix . 'bonn_steelhead',
        'type' => 'checkbox',
      ),

			array(
	      'name' => __( 'Species', 'cmb2' ),
				'desc' => __( 'Currently Targeted Species ', 'cmb2' ),
	      'id'      => $prefix . 'species_multicheckbox',
	      'type'    => 'multicheck',
	      'options' => array(
            'bonefish' => __( 'Bonefish', 'cmb2' ),
            'brook_trout' => __( 'Brook Trout', 'cmb2' ),
            'brown_trout' => __( 'Brown Trout', 'cmb2' ),
            'bull_trout' => __( 'Bull Trout', 'cmb2' ),
            'coastal_cutthroat_trout' => __( 'Coastal Cutthroat Trout', 'cmb2' ),
            'dolphin' => __( 'Dolphin', 'cmb2' ),
            'golden_trout' => __( 'Golden Trout', 'cmb2' ),
            'largemouth_bass' => __( 'Largemouth Bass', 'cmb2' ),
            'permit' => __( 'Permit', 'cmb2' ),
            // 'rainbow_trout' => __( 'Rainbow Trout', 'cmb2' ),
            'rainbow_trout_redband' => __( 'Rainbow Trout', 'cmb2' ),
            'redfish' => __( 'Redfish', 'cmb2' ),
            'smallmouth_bass' => __( 'Smallmouth Bass', 'cmb2' ),
            'snakeriver_finespotted_cutthroat_trout' => __( 'Snakeriver Finespotted Cutthroat', 'cmb2' ),
            'steelhead' => __( 'Steelhead', 'cmb2' ),
            'tarpon' => __( 'Tarpon', 'cmb2' ),
        )
      ),
      array(
        'name' => __( 'Hatches', 'cmb2' ),
        'desc' => __( 'Current Hatches ', 'cmb2' ),
        'id'      => $prefix . 'hatches_multicheckbox',
        'type'    => 'multicheck',
        'options' => array(
            'Midge' => __( 'Midge', 'cmb2' ),
            'Western March Brown' => __( 'Western March Brown', 'cmb2' ),
            'Little Olive' => __( 'Little Olive', 'cmb2' ),
            'Brachycentrus Caddis' => __( 'Brachycentrus Caddis', 'cmb2' ),
            'Slate Gray Dun' => __( 'Slate Gray Dun', 'cmb2' ),
            'Pale Morning Dun' => __( 'Pale Morning Dun', 'cmb2' ),
            'Salmon Fly' => __( 'Salmon Fly', 'cmb2' ),
            'Rhyacophila Caddis' => __( 'Rhyacophila Caddis', 'cmb2' ),
            'Western Green Drake' => __( 'Western Green Drake', 'cmb2' ),
            'Brown Drake' => __( 'Brown Drake', 'cmb2' ),
            'Small Western Drake' => __( 'Small Western Drake', 'cmb2' ),
            'Spotted Sedge' => __( 'Spotted Sedge', 'cmb2' ),
            'Slate Cream Dun' => __( 'Slate Cream Dun', 'cmb2' ),
            'Western Red Quill' => __( 'Western Red Quill', 'cmb2' ),
            'Speckle Wing Quill' => __( 'Speckle Wing Quill', 'cmb2' ),
            'Western Gray Drake' => __( 'Western Gray Drake', 'cmb2' ),
            'Trico ' => __( 'Trico ', 'cmb2' ),
            'Blue Winged Olive' => __( 'Blue Winged Olive', 'cmb2' ),
            'Mahogany Dun' => __( 'Mahogany Dun', 'cmb2' ),
            'Tiny BWO' => __( 'Tiny BWO', 'cmb2' ),
        )
      ),
      array(
        'name'    => __( 'Hot Flies', 'cmb2' ),
        'id'      => $prefix . 'hot_flies',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 5, ),
      ),
			array(
				'name' => __( 'USGS Gauge Number', 'cmb2' ),
				'desc' => __( '<a href="http://waterdata.usgs.gov/or/nwis/current/?type=flow" target="_blank"> USGS Station List</a>', 'cmb2' ),
				'id'   => $prefix . 'siteNum',
				'type' => 'text_medium',
			),
      array(
        'name' => __( 'Latitude', 'cmb2' ),
        'desc' => __( '* Only set this if USGS Gauge Number is not set', 'cmb2' ),
        'id'   => $prefix . 'siteLat',
        'type' => 'text_medium',
      ),
      array(
        'name' => __( 'Longitude', 'cmb2' ),
        'desc' => __( '* Only set this if USGS Gauge Number is not set', 'cmb2' ),
        'id'   => $prefix . 'siteLong',
        'type' => 'text_medium',
      ),
			array(
        'name' => __( 'Map Zoom Level', 'cmb2' ),
        'desc' => __( '* Default is 18', 'cmb2' ),
        'id'   => $prefix . 'zoomLevel',
        'type' => 'text_small',
      ),
			array(
				'name'    => __( 'Guide Report', 'cmb2' ),
				'id'      => $prefix . 'guide_report',
				'type'    => 'wysiwyg',
				'options' => array( 'textarea_rows' => 5, ),
			),
      array(
        'name'    => __( 'River Description', 'cmb2' ),
        'id'      => $prefix . 'river_description',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 5, ),
      ),
			array(
				'name' => __( 'Profile Image', 'cmb2' ),
				'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'report_image',
				'type' => 'file',
			)
		)
	);
	return $meta_boxes;
}


/*  Breadcrumbs
/* ------------------------------------ */

function custom_breadcrumbs() {
       
    // Settings
    //$separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Blog Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . site_url( '/blog/') . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               

            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

// Image Uploader Plugin

    add_filter('images_cpt','my_image_cpt');
    function my_image_cpt(){
        $cpts = array('page','report');
        return $cpts;
    }

    add_filter('list_images','my_list_images',10,3);

function my_list_images($list_images, $cpt){
    global $typenow;
    if($typenow == "report" || $cpt == "report")
        $picts = array(
            'image1' => '_image1',
            'image2' => '_image2',
            'image3' => '_image3',
            'image4' => '_image4',
            'image5' => '_image5',
            'image6' => '_image6'
        );
    elseif ($typenow == 'page') 
        $picts = array(
            'image1' => '_image1'
        );
    else
        $picts = array(
            'image1' => '_image1',
            'image2' => '_image2',
            'image3' => '_image3',
            'image4' => '_image4',
            'image5' => '_image5'
        );
    return $picts;
}

?>