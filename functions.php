<?php
/**
 * Theme bootstrap for the Archis website.
 *
 * Timber is loaded via Composer from this theme's vendor/autoload.php and is
 * initialized using the current Timber 2.x API. Twig templates are rendered from
 * the theme's templates/ directory.
 *
 * @package  ArchisWordpressTheme
 * @subpackage  Timber
 * @since   2026-09-02
 */

/**
 * Load the Composer dependency autoloader and initialize Timber.
 *
 * This theme intentionally uses the Composer-managed dependency chain instead of
 * the legacy Timber plugin approach.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	Timber\Timber::init();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action('init', array($this, 'add_acf_options_pages'));



		// Link only toolbar
		add_filter('acf/fields/wysiwyg/toolbars', array($this, 'my_acf_toolbars'));




		add_action('acf/init', array($this, 'add_acf_gutenberg_blocks'));
		add_filter('block_categories', array($this, 'add_gutenberg_categories'), 10, 2);
		

		// Functions for removing comments functionality
		// Close comments on the front-end
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);

		// Hide existing comments
		add_filter('comments_array', '__return_empty_array', 10, 2);

		// Remove comments page in menu
		add_action('admin_menu', function () {
			remove_menu_page('edit-comments.php');
		});

		add_action( 'init', array( $this, 'remove_comments') );
		add_action( 'admin_init', array($this, 'remove_comments_admin' ) );


		// Disable gutenberg for homepage
		add_filter( 'gutenberg_can_edit_post_type', array($this, 'disable_gutenberg_for_homepage'), 10, 2 );
		add_filter( 'use_block_editor_for_post_type', array($this, 'disable_gutenberg_for_homepage'), 10, 2 );
		
		
		// // Add acf publication to admin
		// add_action("manage_article_posts_custom_column", array($this, "custom_columns"));
		// add_filter("manage_article_posts_columns", array($this, "page_columns"));

		// Add acf json files handling
		add_filter('acf/settings/load_json', array($this, 'my_acf_json_load_point'));
		add_filter('acf/settings/save_json', array($this, 'my_acf_json_save_point'));
		

		// Increase pagination for topics and dossiers

		add_filter('query_vars', array($this, 'parameter_queryvars') );

		parent::__construct();
	}
	public function parameter_queryvars( $qvars ) {
		$qvars[] = 'category';
		// $qvars[] = 'yourvarname';
		return $qvars;
	}

	public function add_acf_options_pages()
	{
		if (function_exists('acf_add_options_page')) {



			// Add parent.
			$parent = acf_add_options_page(array(
				'page_title'  => __('General Content'),
				'menu_title'  => __('General Content'),
				'redirect'    => true,
			));
			
			// Add sub page.
			$child1 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Dictionary'),
				'menu_title'  => __('Dictionary'),
				'parent_slug' => $parent['menu_slug'],
			));
			// Add sub page.
			$child1 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Footer'),
				'menu_title'  => __('Footer'),
				'parent_slug' => $parent['menu_slug'],
			));

			$child2 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Homepage'),
				'menu_title'  => __('Homepage'),
				'parent_slug' => $parent['menu_slug'],
			));
			$child2 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Links'),
				'menu_title'  => __('Links'),
				'parent_slug' => $parent['menu_slug'],
			));
			$child2 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Breadcrumbs'),
				'menu_title'  => __('Breadcrumbs'),
				'parent_slug' => $parent['menu_slug'],
			));
			
			$child2 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - Stickers'),
				'menu_title'  => __('Stickers'),
				'parent_slug' => $parent['menu_slug'],
			));

			$child3 = acf_add_options_sub_page(array(
				'page_title'  => __('General Content - 404 page'),
				'menu_title'  => __('404 page'),
				'parent_slug' => $parent['menu_slug'],
			));

			

		}
	}

	public function my_acf_toolbars($toolbars)
	{
		// Uncomment to view format of $toolbars
		/*
		echo '< pre >';
			print_r($toolbars);
		echo '< /pre >';
		die;
		*/

		// Add a new toolbar called "Very Simple"
		// - this toolbar has only 1 row of buttons
		$toolbars['Only link'] = array();
		$toolbars['Only link'][1] = array('link');


		// $toolbars['Very Simple'][1] = array('bold', 'italic', 'underline', 'link');

		// // Edit the "Full" toolbar and remove 'code'
		// // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
		// if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
		// 	unset($toolbars['Full'][2][$key]);
		// }

		// // remove the 'Basic' toolbar completely
		// unset($toolbars['Basic']);

		// return $toolbars - IMPORTANT!
		return $toolbars;
	}

	public function add_gutenberg_categories($categories)
	{
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'volume_category',
					'title' => __('Archis.org', 'mydomain'),
					// 'icon'  => 'wordpress',
				),
			)
		);
	}

	public function add_acf_gutenberg_blocks()
	{
		// Bail out if function doesn’t exist.
		if (!function_exists('acf_register_block')) {
			return;
		}

		// Register a new block.
		acf_register_block(array(
			'name'            => 'Quote',
			'title'           => __('Quote', 'your-text-domain'),
			'description'     => __('', 'your-text-domain'),
			'render_callback' => array($this, 'gutenberg_quoteblock_callback'),
			'category'        => 'volume_category',
			'icon'            => 'admin-comments',
			'keywords'        => array('Archis.org', "Volume", 'Quote', 'Quotebox')
		));

		// Register a new block.
		acf_register_block(array(
			'name'            => 'Interview',
			'title'           => __('Interview', 'your-text-domain'),
			'description'     => __('', 'your-text-domain'),
			'render_callback' => array($this, 'gutenberg_interview_callback'),
			'category'        => 'volume_category',
			'icon'            => 'admin-comments',
			'keywords'        => array('Archis.org', "Volume", 'Interview', )
		));

	}

	public function gutenberg_quoteblock_callback($block, $content = '', $is_preview = false)
	{
		$context = Timber::context();
		// Store block values.
		$context['block'] = $block;

		// Store field values.
		$context['fields'] = get_fields();

		// Store $is_preview value.
		$context['is_preview'] = $is_preview;

		// Render the block.
		Timber::render('templates/gutenberg/block_quote.twig', $context);
	}


	public function gutenberg_interview_callback($block, $content = '', $is_preview = false)
	{
		$context = Timber::context();
		// Store block values.
		$context['block'] = $block;

		// Store field values.
		$context['fields'] = get_fields();

		// Store $is_preview value.
		$context['is_preview'] = $is_preview;

		// Render the block.
		Timber::render('templates/gutenberg/block_interview.twig', $context);
	}




	public function my_acf_json_load_point($paths)
	{

		// remove original path (optional)
		unset($paths[0]);


		// append path
		$paths[] = get_stylesheet_directory() . '/acf-json-conf-CfyCM';


		// return
		return $paths;
	}


	public function my_acf_json_save_point($path)
	{

		// update path
		$path = get_stylesheet_directory() . '/acf-json-conf-CfyCM';


		// return
		return $path;
	}




	/** Function to disable gutenberg for homepage */
	public function disable_gutenberg_for_homepage( $can_edit, $post_type ) {
		// error_log("Post template: "  . get_page_template_slug( $_GET['post']));
		if ( isset($_GET['post']) && in_array( get_page_template_slug( $_GET['post']), array("page-homepage.php", 'page-about.php') ) ) {
			$can_edit = false;
		}
		return $can_edit;
	}

	/** Remove comments links from admin bar  */
	public function remove_comments() {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}

	/** This function redirects comments pages and removes trackbacks for comments */
	public function remove_comments_admin() {
		// Redirect any user trying to access comments page
		global $pagenow;
    
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url());
			exit;
		}
	
		// Remove comments metabox from dashboard
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	
		// Disable support for comments and trackbacks in post types
		foreach (get_post_types() as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {
		require_once("taxonomies/tax-volume_article.php");
		require_once("taxonomies/tax-volume_edition.php");
		require_once("taxonomies/tax-books.php");
		// require_once("taxonomies/tax-about_pages.php");
		require_once("taxonomies/tax-events.php");
		require_once("taxonomies/tax-adverts.php");
		require_once("taxonomies/tax-project.php");
		require_once("taxonomies/tax-shop.php");
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}
	
	/** Sorting taxonomies by name */
	public function compareByName($a, $b) {
		return strcmp($a->name, $b->name);
	}


	public function get_terms_by_post_type( $taxonomies, $post_types ) {

    global $wpdb;

    $query = $wpdb->prepare(
        "SELECT t.*, COUNT(*) from $wpdb->terms AS t
        INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
        INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
        WHERE p.post_type IN('%s') AND tt.taxonomy IN('%s')
		AND p.post_status = 'publish'
        GROUP BY t.term_id",
        join( "', '", $post_types ),
        join( "', '", $taxonomies )
    );

    $results = $wpdb->get_results( $query );

    return $results;

	}


	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		// Adding global content related to Volume filter as it is used across multiple templates
		$nav_pub_query = array(
 			'posts_per_page'   => -1, 
 			'post_type'     => 'publication',
		);


		$context["nav_pub"] = Timber::get_posts($nav_pub_query);

		$nav_books_query = array(
			'posts_per_page'   => -1, 
			'post_type'     => 'book',
	   );


	   $context["nav_books"] = Timber::get_posts($nav_books_query);

		$topics = $this->get_terms_by_post_type(array("topic"), array("article"));
		$context["nav_topic"] = [];
		foreach ($topics as $key => $term) {
			$context["nav_topic"][] = Timber::get_term($term->term_id);
		}
		usort($context["nav_topic"], array($this, 'compareByName'));


		$dossiers = $this->get_terms_by_post_type(array("dossier"), array("article"));
		$context["nav_dossier"] = [];
		foreach ($dossiers as $key => $term) {
			$context["nav_dossier"][] = Timber::get_term($term->term_id);
		}
		usort($context["nav_dossier"], array($this, 'compareByName'));


		$context["enable_layers"] = true;




		// General setup
		$context["pagination"] = Timber::get_pagination();
		global $wp;
		$context["current_url"] = $wp->request;
		$context["full_url"] = home_url( $wp->request ) . "/";
		$context['menu']  = Timber::get_menu("Menu");
		$context['menu_secondary']  = Timber::get_menu("menu_secondary");
		$context['footer_secondary_1']  = Timber::get_menu("footer_secondary_1");
		$context['footer_secondary_2']  = Timber::get_menu("footer_secondary_2");
		$context['footer_social']  = Timber::get_menu("footer_social");
		$context['footer_tertiary']  = Timber::get_menu("footer_tertiary");
		$context['generalcontent'] = get_fields('option');

		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return an array of coAuthors Plus authors.
	 *
	 * @param int $id should be the post id
	 */
	

	public function getAuthors( $id ) {
		$authors = get_coauthors($id);
		return $authors;
	}


	/** This returns the conditional title of an issue
	 *
	 * @param int $id should be the post id
	 */
	

	public function issueTitle( $post ) {
		$id = $post->ID;
		$title = get_field("pub_info", $id);
		// error_log(print_r($title, true));

		if(!empty($title["name"]) && !empty($title["number"]) && !empty($title["subject"])) {
			return array(
				"title" => $title["name"] . " " . $title["number"] . ": " . $title["subject"], 
				"shortTitle" => $title["number"] . ": " . $title["subject"]
			);
		}
		
		return array("title" => $post->post_title, "shortTitle" => $post->post_title);
	}

 	/** This returns a Timber\Post with your ad and increases view of item
	 *
	 * @param int $index is the display index of the ad
	 */
	public function getAd($index) {
		$index = intval($index) - 1;
		$date_now = intval(date('Ymd'));

		$q = array(
		  'posts_per_page'  => -1,
		  'post_type'     => 'ads',
		  'meta_query'     => array(
		   'relation'      => 'AND',
		   array(
		          'key'      => 'visible_until',
		          'compare'    => '>=',
		          'value'      => $date_now,
		          'type'     => 'NUMBER'
		   )
		    ),
		  'order'        => 'ASC',
		  'orderby'      => 'meta_value',
		  'meta_key'     => 'priority',
		  'meta_type'      => 'DATETIME'
		);
		$ads = Timber::get_posts($q);
		$total = intval($ads->found_posts);
		


		foreach ($ads as $key => $ad) {
			if($key == $index%$total) {
				$views = intval(get_field("views", $ad->ID)) + 1;
				update_field("views", $views, $ad->ID);
				return $ad;
			}
		}
		
		

		return false;


	}




	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
 $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
    $twig->addFilter( new Twig\TwigFilter( 'issueTitle', array( $this, 'issueTitle' ) ) );
    $twig->addFilter( new Twig\TwigFilter( 'getAuthors', function($id) {
        return $this->getAuthors($id);
    }));

    $twig->addFilter( new Twig\TwigFilter( 'getAd', function($index) {
        return $this->getAd($index);
    }));

    
	// Add WebP filter - with GIF exclusion
	$twig->addFilter( new Twig\TwigFilter( 'webp', function($image, $width = null, $height = null) {
		if (!$image || !function_exists('imagewebp')) {
			return $image ? $image->src() : '';
		}
		
		// Check if image is a GIF - keep GIFs as GIFs to preserve animation
		$image_url = $image->src();
		if (preg_match('/\.gif$/i', $image_url)) {
			// For GIFs, just resize if needed but don't convert to WebP
			if ($width) {
				$resized = $image->resize($width, $height);
				return $resized ? $resized->src() : $image->src();
			}
			return $image->src();
		}
		
		// Resize first if dimensions provided
		if ($width) {
			$resized = $image->resize($width, $height);
			// Check if resize was successful
			if (!$resized) {
				return $image->src(); // Return original if resize fails
			}
		} else {
			$resized = $image;
		}
		
		// Make sure we have a valid image object
		if (!$resized || !method_exists($resized, 'src')) {
			return $image->src(); // Return original if something went wrong
		}
		
		$upload_dir = wp_upload_dir();
		$image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $resized->src());
		
		if (file_exists($image_path)) {
			$webp_path = create_webp_version($image_path, 85);
			if ($webp_path) {
				return str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $webp_path);
			}
		}
		
		return $resized->src();
	}));


		return $twig;
	}
}


new StarterSite();


// SHOP IMAGE OPTIMIZATIONS


// Optimize Timber image resizing
add_filter('timber/image/quality', function($quality) {
    return 85; // Good quality for WebP
});

// Enable WebP support for uploads
add_filter('mime_types', function($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
});

// Add WebP support to Timber
add_filter('timber/image/formats', function($formats) {
    $formats[] = 'webp';
    return $formats;
});

// Custom function to create WebP versions - excluding GIFs
function create_webp_version($image_path, $quality = 85) {
    if (!function_exists('imagewebp')) {
        return false;
    }
    
    $info = pathinfo($image_path);
    
    // Skip GIF files to preserve animation
    if (strtolower($info['extension']) === 'gif') {
        return false;
    }
    
    $webp_path = $info['dirname'] . '/' . $info['filename'] . '.webp';
    
    // Check if WebP version already exists and is newer
    if (file_exists($webp_path) && filemtime($webp_path) >= filemtime($image_path)) {
        return $webp_path;
    }
    
    $image = null;
    
    switch (strtolower($info['extension'])) {
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($image_path);
            break;
        case 'png':
            $image = imagecreatefrompng($image_path);
            break;
        default:
            return false; // GIF is already excluded above
    }
    
    if ($image) {
        // Enable alpha channel for PNG
        if (strtolower($info['extension']) === 'png') {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        
        $result = imagewebp($image, $webp_path, $quality);
        imagedestroy($image);
        
        return $result ? $webp_path : false;
    }
    
    return false;
}

// Hook into Timber's image processing
add_filter('timber/image/src', function($src, $attachment) {
    if (is_post_type_archive('shop') && function_exists('imagewebp')) {
        $upload_dir = wp_upload_dir();
        $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $src);
        
        if (file_exists($image_path)) {
            $webp_path = create_webp_version($image_path);
            if ($webp_path) {
                return str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $webp_path);
            }
        }
    }
    return $src;
}, 10, 2);

// Reduce image processing time
add_filter('timber/image/upscale', '__return_false');

// Optimize queries for shop pages
// add_action('pre_get_posts', function($query) {
//     if (!is_admin() && $query->is_main_query() && is_post_type_archive('shop')) {
//         $query->set('posts_per_page', 12);
//         $query->set('no_found_rows', false);
//         $query->set('update_post_meta_cache', false);
//         $query->set('update_post_term_cache', false);
//     }
// });



// Disable unnecessary features for shop pages
// add_action('wp', function() {
//     if (is_post_type_archive('shop')) {
//         // Disable emojis
//         remove_action('wp_head', 'print_emoji_detection_script', 7);
//         remove_action('wp_print_styles', 'print_emoji_styles');
        
//         // Disable embeds
//         remove_action('wp_head', 'wp_oembed_add_discovery_links');
//         remove_action('wp_head', 'wp_oembed_add_host_js');
        
//         // Disable REST API links
//         remove_action('wp_head', 'rest_output_link_wp_head');
//         remove_action('wp_head', 'wp_oembed_add_discovery_links');
//     }
// });

// Clear any existing image cache to force regeneration with new settings
// add_action('init', function() {
//     if (isset($_GET['clear_image_cache']) && current_user_can('manage_options')) {
//         // Clear Timber's image cache
//         $cache_dir = wp_upload_dir()['basedir'] . '/cache/timber';
//         if (is_dir($cache_dir)) {
//             array_map('unlink', glob("$cache_dir/*"));
//         }
//         wp_redirect(remove_query_arg('clear_image_cache'));
//         exit;
//     }
// });


// Force shop archive to use custom query and prevent caching issues
// add_action('pre_get_posts', function($query) {
//     // Only modify the main query on shop archive
//     if (!is_admin() && $query->is_main_query() && is_post_type_archive('shop')) {
//         // Ensure we get the latest posts
//         $query->set('post_status', 'publish');
//         $query->set('posts_per_page', 32);
//         $query->set('orderby', 'date');
//         $query->set('order', 'DESC');
        
//         // Disable caching for fresh results
//         $query->set('no_found_rows', false);
//         $query->set('update_post_meta_cache', true);
//         $query->set('update_post_term_cache', true);
        
//         // Handle category filtering
//         $category_slug = get_query_var('category');
//         if (!empty($category_slug)) {
//             $category = get_category_by_slug($category_slug);
//             if ($category) {
//                 $query->set('category__and', $category->cat_ID);
//             }
//         }
//     }
// });

// // Clear any object caching for shop items
// add_action('save_post', function($post_id) {
//     $post = get_post($post_id);
//     if ($post && $post->post_type === 'shop') {
//         // Clear any cached queries
//         wp_cache_delete('shop_categories', 'theme_cache');
        
//         // Force refresh of shop archive
//         if (function_exists('wp_cache_flush')) {
//             wp_cache_flush();
//         }
//     }
// });

// // Ensure fresh content on shop pages
// add_action('wp', function() {
//     if (is_post_type_archive('shop')) {
//         // Disable caching for shop archive
//         if (!defined('DONOTCACHEPAGE')) {
//             define('DONOTCACHEPAGE', true);
//         }
        
//         // Set headers to prevent caching
//         nocache_headers();
//     }
// });





// rest of code


if ( ! function_exists( 'your_theme_restrict_block_editor_patterns' ) ) {
	/**
	 * Restricts block editor patterns in the editor by removing support for all patterns from:
	 *   - Dotcom and plugins like Jetpack
	 *   - Dotorg pattern directory except for theme patterns
	 */
	function your_theme_restrict_block_editor_patterns( $dispatch_result, $request, $route ) {
		if ( strpos( $route, '/wp/v2/block-patterns/patterns' ) === 0 ) {
			$patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
 
 
			if ( ! empty( $patterns ) ) {
				// Remove theme support for all patterns from Dotcom, and plugins. See https://developer.wordpress.org/themes/features/block-patterns/#unregistering-block-patterns
				foreach ( $patterns as $pattern ) {
					unregister_block_pattern( $pattern['name'] );
				}
				// Remove theme support for core patterns from the Dotorg pattern directory. See https://developer.wordpress.org/themes/features/block-patterns/#removing-core-patterns
				remove_theme_support( 'core-block-patterns' );
			}
		}
 
 
		return $dispatch_result;
	}
 }
 
 
 // Remove and unregister patterns from core, Dotcom, and plugins. See https://github.com/Automattic/jetpack/blob/d032fbb807e9cd69891e4fcbc0904a05508a1c67/projects/packages/jetpack-mu-wpcom/src/features/block-patterns/block-patterns.php#L107
 add_filter( 'rest_dispatch_request', 'your_theme_restrict_block_editor_patterns', 12, 3 );
 
 
 // Disable the remote patterns coming from the Dotorg pattern directory. See https://developer.wordpress.org/themes/features/block-patterns/#disabling-remote-patterns
 add_filter( 'should_load_remote_block_patterns', '__return_false' );


function mytheme_enqueue_styles() {
    // Remove parent theme's default style enqueue (if it exists)
    wp_dequeue_style('theme-style');
    wp_deregister_style('theme-style');

    // Now enqueue our own style.css with timestamp version
    $style_path = get_stylesheet_directory() . '/style.css';
    $style_version = filemtime($style_path);

    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), $style_version);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles', 20);


add_action('wp_enqueue_scripts', function() {
    global $wp_styles;
    if ( is_user_logged_in() ) { // only show to logged-in users
        echo '<!-- Enqueued Styles: -->' . PHP_EOL;
        foreach( $wp_styles->queue as $handle ) {
            echo "<!-- $handle -->" . PHP_EOL;
        }
    }
}, 999);
