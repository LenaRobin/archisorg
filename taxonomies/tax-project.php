<?php
function create_project() {
	register_post_type( 'project',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Projects' ),
			'singular_name' => __( 'Project Article' ),
			'search_items' =>  __( 'Search Project Articles' ),
			'all_items' => __( 'All Project Articles' ),
			'parent_item' => __( 'Parent Project Article' ),
			'parent_item_colon' => __( 'Parent Project Article:' ),
			'edit_item' => __( 'Edit Project Article' ), 
			'update_item' => __( 'Update Project Article' ),
			'add_new_item' => __( 'Add New Project Article' ),
			'new_item_name' => __( 'New Project Article' ),
			'menu_name' => __( 'Project Articles' ),
		),
		'taxonomies'  => array('project_cat'),
		'public' => true,
		'has_archive' => "projects",
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 4, 
		'menu_icon' => "dashicons-open-folder",
		'rewrite' => array('slug' => 'projects/article'),
		'supports' => array('title', 'editor', 'author', 'excerpt', 'tags', 'thumbnail')

		)
	);
};
create_project();


function create_project_type() {
	$labels = array(
			'name'                       => _x( 'Project', 'taxonomy general name', 'textdomain' ),
			'search_items'               => __( 'Search Projects', 'textdomain' ),
			'singular_name'              => _x( 'Project', 'taxonomy singular name', 'textdomain' ),
			'popular_items'              => __( 'Popular Projects', 'textdomain' ),
			'all_items'                  => __( 'All Projects', 'textdomain' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Project', 'textdomain' ),
			'update_item'                => __( 'Update Project', 'textdomain' ),
			'add_new_item'               => __( 'Add New Project', 'textdomain' ),
			'new_item_name'              => __( 'New Project', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or remove project', 'textdomain' ),
			'separate_items_with_commas' => __( 'Separate projects with commas', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used project', 'textdomain' ),
			'not_found'                  => __( 'No project found.', 'textdomain' ),
			'menu_name'                  => __( 'Projects', 'textdomain' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'public'								=> true,
			'query_var'             => true,
			'has_archive' => "projects",
			'rewrite'               => array( 'slug' => 'projects', "with_front" => true ),
			'show_in_rest'          => true,
			'rest_base'             => 'project_cat',
			'rest_controller_class' => 'WP_REST_Terms_Controller',

		);

		register_taxonomy( "project_cat", array('project'), $args );
}




create_project_type();

function create_project_category() {
	$labels = array(
			'name'                       => _x( 'Category', 'taxonomy general name', 'textdomain' ),
			'search_items'               => __( 'Search categories', 'textdomain' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
			'popular_items'              => __( 'Popular categories', 'textdomain' ),
			'all_items'                  => __( 'All categories', 'textdomain' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Category', 'textdomain' ),
			'update_item'                => __( 'Update Category', 'textdomain' ),
			'add_new_item'               => __( 'Add New Category', 'textdomain' ),
			'new_item_name'              => __( 'New Category', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or remove category', 'textdomain' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'textdomain' ),
			'not_found'                  => __( 'No category found.', 'textdomain' ),
			'menu_name'                  => __( 'Categories', 'textdomain' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'public'								=> true,
			'query_var'             => true,
			'show_in_rest'          => true,
			'rest_base'             => 'project_art_cat',
			'rest_controller_class' => 'WP_REST_Terms_Controller',

		);

		register_taxonomy( "project_art_cat", array('project'), $args );
}




create_project_category();


?>