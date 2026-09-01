<?php
function create_abouts() {
	register_post_type( 'about',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'About pages' ),
			'singular_name' => __( 'About' ),
			'search_items' =>  __( 'Search About pages' ),
			'all_items' => __( 'All About pages' ),
			'parent_item' => __( 'Parent About' ),
			'parent_item_colon' => __( 'Parent About:' ),
			'edit_item' => __( 'Edit About' ), 
			'update_item' => __( 'Update About' ),
			'add_new_item' => __( 'Add New About' ),
			'new_item_name' => __( 'New About' ),
			'menu_name' => __( 'About' ),
		),
		// 'taxonomies'  => array('about_type', 'industry'),
		'public' => true,
		'has_archive' => "about",
		'show_in_nav_menus' => true,
		// 'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 3, 
		'menu_icon' => "dashicons-building",
		'rewrite' => array('slug' => 'about'),
		'supports' => array('title', 'editor', 'author','excerpt', 'tags', 'thumbnail')

		)
	);
};
create_abouts();




?>