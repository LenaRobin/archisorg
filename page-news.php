<?php

/*
Template Name: News
Template Post Type: page
*/


/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

// $timber_post     = new Timber\Post();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

$newbit_query = array(
	'posts_per_page'	=> 60,
	// 'post_type'			=> array('event', 'article', 'project', 'shop'), 
	'post_type'			=> array('event', 'article', 'project'), 

	// 'meta_query' 		=> array(
	// 'relation' 			=> 'AND',
	// 	array(
	//         'key'			=> 'to_date',
	//         'compare'		=> '>=',
	//         'value'			=> $date_now,
	//         'type'			=> 'DATETIME'
	// 	)
    // ),
	// 'order'				=> 'ASC',
	// 'orderby'			=> 'meta_value',
	// 'meta_key'			=> 'from_date',
	// 'meta_type'			=> 'DATETIME'
);

// $context["newbits"] = new Timber\PostQuery($newbit_query);
$context["newbits"] = Timber::get_posts($newbit_query);
$context["body_class"] = "news about";
$context["page_class"] = "page--news page--about";
$context["enable_layers"] = false;

Timber::render( array( 'page-news.twig', 'page.twig' ), $context );

