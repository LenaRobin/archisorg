<?php
function create_books() {
	register_post_type( 'book',
		// CPT Options
		array(
			'labels' => array(
			'name' => __( 'Books' ),
			'singular_name' => __( 'Book' ),
			'search_items' =>  __( 'Search Books' ),
			'all_items' => __( 'All Books' ),
			'parent_item' => __( 'Parent Book' ),
			'parent_item_colon' => __( 'Parent Book:' ),
			'edit_item' => __( 'Edit Book' ), 
			'update_item' => __( 'Update Book' ),
			'add_new_item' => __( 'Add New Book' ),
			'new_item_name' => __( 'New Book' ),
			'menu_name' => __( 'Books' ),
		),
		'taxonomies'  => array('post_tag', 'category'),
		'public' => true,
		'has_archive' => "books",
		'show_in_nav_menus' => true,
		// 'show_in_rest' => true,
		// 'supports' => array('editor'),
		'menu_position' => 2, 
		'menu_icon' => "dashicons-book",
		'rewrite' => array('slug' => 'books'),
		'supports' => array('title', 'editor', 'author','excerpt', 'tags', 'thumbnail')

		)
	);
};




create_books();




?>