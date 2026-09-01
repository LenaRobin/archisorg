<?php
function create_publications() {
	register_post_type( 'publication',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Publications' ),
			'singular_name' => __( 'Publication' ),
			'search_items' =>  __( 'Search Publications' ),
			'all_items' => __( 'All Publications' ),
			'parent_item' => __( 'Parent Publication' ),
			'parent_item_colon' => __( 'Parent Publication:' ),
			'edit_item' => __( 'Edit Publication' ), 
			'update_item' => __( 'Update Publication' ),
			'add_new_item' => __( 'Add New Publication' ),
			'new_item_name' => __( 'New Publication' ),
			'menu_name' => __( 'Publications' ),
		),
		'taxonomies'  => array('post_tag', 'category'),
		'public' => true,
		'has_archive' => "publications",
		'show_in_nav_menus' => true,
		// 'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 2, 
		'menu_icon' => "dashicons-book",
		'rewrite' => array('slug' => 'publications'),
		'supports' => array('title', 'editor', 'author','excerpt', 'tags', 'thumbnail')

		)
	);
};




create_publications();




?>