<?php
function create_abouts() {
	register_post_type( 'ads',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Ads' ),
			'singular_name' => __( 'Ad' ),
			'search_items' =>  __( 'Search Ad pages' ),
			'all_items' => __( 'All Ad pages' ),
			'parent_item' => __( 'Parent Ad' ),
			'parent_item_colon' => __( 'Parent Ad:' ),
			'edit_item' => __( 'Edit Ad' ), 
			'update_item' => __( 'Update Ad' ),
			'add_new_item' => __( 'Add New Ad' ),
			'new_item_name' => __( 'New Ad' ),
			'menu_name' => __( 'Ads' ),
		),
		// 'taxonomies'  => array('about_type', 'industry'),
		'public' => true,
		// 'has_archive' => "about",
		'show_in_nav_menus' => true,
		// 'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 5, 
		'menu_icon' => "dashicons-money-alt",
		// 'rewrite' => array('slug' => 'about'),
		'supports' => array('title', 'author')

		)
	);
};
create_abouts();




?>