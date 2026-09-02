<?php

/*
Template Name: Homepage
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

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;



$newbit_query = array(
	'posts_per_page'	=> 3,
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

$context["newbits"] = Timber::get_posts($newbit_query);




$article_query = array(
	'posts_per_page'	=> 3,
	'post_type'			=> 'article',
	// 'meta_query' 		=> array(
	// 	'relation' 			=> 'AND',
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

$context["articles"] = Timber::get_posts($article_query);

$publication_query = array(
	'posts_per_page'	=> 1,
	'post_type'			=> 'publication',
	// 'meta_query' 		=> array(
	// 	'relation' 			=> 'AND',
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

$context["publication"] = Timber::get_posts($publication_query);



$event_query = array(
	'posts_per_page'	=> 3,
	'post_type'			=> 'event',
	// 'meta_query' 		=> array(
	// 	'relation' 			=> 'AND',
	// 	array(
	//         'key'			=> 'to',
	//         'compare'		=> '>=',
	//         'value'			=> $date_now,
	//         'type'			=> 'DATETIME'
	// 	)
    // ),
	'order'				=> 'DESC',
	'orderby'			=> 'meta_value',
	'meta_key'			=> 'from',
	'meta_type'			=> 'DATETIME'
);
$context["events"] = Timber::get_posts($event_query);

$terms = get_terms( 'project_cat', array(
    'hide_empty' => false,
) );




$context['projects'] = [];
foreach ($terms as $key => $term) {
  $context["projects"][] = Timber::get_term($term->term_id);
}

function project_sort($a, $b) {
	$ats = [new DateTime('@0')];
	$bts = [new DateTime('@0')];
	
	foreach ($a->posts(100) as $key => $p) {
		$ats[] = new DateTime($p->post_date);
	}
	foreach ($b->posts(100) as $key => $p) {
		$bts[] = new DateTime($p->post_date);
	}

	$at = max($ats);
	$bt = max($bts);
	
  	// $bd = new DateTime($b['post_date']);
	return $at > $bt ? -1 : 1;return ;
}

usort($context["projects"], 'project_sort');



$context["layers_class"] = "home__layers";
// $context["archis_class"] = " ";
Timber::render( array( 'page-homepage.twig', 'page.twig' ), $context );
