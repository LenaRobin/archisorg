<?php
function create_volume_articles() {
	register_post_type( 'article',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Read' ),
			'singular_name' => __( 'Article' ),
			'search_items' =>  __( 'Search Articles' ),
			'all_items' => __( 'All Articles' ),
			'parent_item' => __( 'Parent Article' ),
			'parent_item_colon' => __( 'Parent Article:' ),
			'edit_item' => __( 'Edit Article' ), 
			'update_item' => __( 'Update Article' ),
			'add_new_item' => __( 'Add New Article' ),
			'new_item_name' => __( 'New Article' ),
			'menu_name' => __( 'Articles' ),
		),
		'taxonomies'  => array('post_tag', 'category', 'dossier', 'topic'),
		'public' => true,
		'has_archive' => "volume",
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 2, 
		'menu_icon' => "dashicons-format-aside",
		'rewrite' => array('slug' => 'volume'),
		'supports' => array('title', 'editor', 'author', 'excerpt', 'tags', 'thumbnail')

		)
	);
};
create_volume_articles();

function create_article_dossier() {
	$labels = array(
			'name'                       => _x( 'Dossiers', 'taxonomy general name', 'textdomain' ),
			'search_items'               => __( 'Search Dossiers', 'textdomain' ),
			'singular_name'              => _x( 'Dossier', 'taxonomy singular name', 'textdomain' ),
			'popular_items'              => __( 'Popular Dossiers', 'textdomain' ),
			'all_items'                  => __( 'All Dossiers', 'textdomain' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Dossier', 'textdomain' ),
			'update_item'                => __( 'Update Dossier', 'textdomain' ),
			'add_new_item'               => __( 'Add New Dossier', 'textdomain' ),
			'new_item_name'              => __( 'New Dossier', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or remove Dossier', 'textdomain' ),
			'separate_items_with_commas' => __( 'Separate Dossiers with commas', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used dossier', 'textdomain' ),
			'not_found'                  => __( 'No dossier found.', 'textdomain' ),
			'menu_name'                  => __( 'Dossiers', 'textdomain' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			// 'rewrite'               => array( 'slug' => '/article/type' ),
			'show_in_rest'          => true,
			'rest_base'             => 'dossier',
			'rest_controller_class' => 'WP_REST_Terms_Controller',

		);

		register_taxonomy( "dossier", array('article'), $args );
}
create_article_dossier();


function create_article_topic() {
  $labels = array(
      'name'                       => _x( 'Topics', 'taxonomy general name', 'textdomain' ),
      'search_items'               => __( 'Search Topics', 'textdomain' ),
      'singular_name'              => _x( 'Topic', 'taxonomy singular name', 'textdomain' ),
      'popular_items'              => __( 'Popular Topics', 'textdomain' ),
      'all_items'                  => __( 'All Topics', 'textdomain' ),
      'parent_item'                => null,
      'parent_item_colon'          => null,
      'edit_item'                  => __( 'Edit Topic', 'textdomain' ),
      'update_item'                => __( 'Update Topic', 'textdomain' ),
      'add_new_item'               => __( 'Add New Topic', 'textdomain' ),
      'new_item_name'              => __( 'New Topic', 'textdomain' ),
      'add_or_remove_items'        => __( 'Add or remove Topic', 'textdomain' ),
      'separate_items_with_commas' => __( 'Separate Topics with commas', 'textdomain' ),
      'choose_from_most_used'      => __( 'Choose from the most used topic', 'textdomain' ),
      'not_found'                  => __( 'No topic found.', 'textdomain' ),
      'menu_name'                  => __( 'Topics', 'textdomain' ),
    );

    $args = array(
      'hierarchical'          => true,
      'labels'                => $labels,
      'show_ui'               => true,
      'show_admin_column'     => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'             => true,
      // 'rewrite'               => array( 'slug' => '/article/type' ),
      'show_in_rest'          => true,
      'rest_base'             => 'topic',
      'rest_controller_class' => 'WP_REST_Terms_Controller',

    );

    register_taxonomy( "topic", array('article'), $args );
}

create_article_topic();



?>