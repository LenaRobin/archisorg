<?php
function create_events() {
	register_post_type( 'event',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Events' ),
			'singular_name' => __( 'Event' ),
			'search_items' =>  __( 'Search Event pages' ),
			'all_items' => __( 'All Events' ),
			'parent_item' => __( 'Parent Event' ),
			'parent_item_colon' => __( 'Parent Event:' ),
			'edit_item' => __( 'Edit Event' ), 
			'update_item' => __( 'Update Event' ),
			'add_new_item' => __( 'Add New Event' ),
			'new_item_name' => __( 'New Event' ),
			'menu_name' => __( 'Event' ),
		),
		// 'taxonomies'  => array('about_type', 'industry'),
		'public' => true,
		'has_archive' => "events",
		'show_in_nav_menus' => true,
		//'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 3, 
		'menu_icon' => "dashicons-calendar-alt",
		'rewrite' => array('slug' => 'event'),
		'supports' => array('title', 'editor', 'author','excerpt', 'tags', 'thumbnail')

		)
	);
};
create_events();




?>