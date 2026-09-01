<?php
function create_shop() {
	register_post_type( 'shop',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Shop' ),
			'singular_name' => __( 'Shop item' ),
			'search_items' =>  __( 'Search Shop items' ),
			'all_items' => __( 'All Shop items' ),
			'parent_item' => __( 'Parent Shop item' ),
			'parent_item_colon' => __( 'Parent Shop item:' ),
			'edit_item' => __( 'Edit Shop item' ), 
			'update_item' => __( 'Update Shop item' ),
			'add_new_item' => __( 'Add New Shop item' ),
			'new_item_name' => __( 'New Shop item' ),
			'menu_name' => __( 'Shop items' ),
		),
		'taxonomies'  => array('post_tag', 'category'),
		'public' => true,
		'has_archive' => "shop",
		'show_in_nav_menus' => true,
		// 'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 2, 
		'menu_icon' => "dashicons-book",
		'rewrite' => array('slug' => 'shop'),
		'supports' => array('title', 'editor', 'author','excerpt', 'tags', 'thumbnail')

		)
	);
};




create_shop();




?>