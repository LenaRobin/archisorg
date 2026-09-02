<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
// $timber_post     = Timber::query_post();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;


$context["body_class"] = "bazar bazar-post";

$article_query = array(
  'posts_per_page'   => -1, 
  'post_type'     => 'article',
  'meta_query'     => array(
    'relation'      => 'AND',
    array( 
      'key'      => 'shop',
      'compare'    => '=',
      'value'      => $context["post"]->ID,
      'type'     => 'INT'
    ),
    array(
      "relation" => "OR",
      array(
        'key' => 'featured', 
        'compare' => 'EXISTS'
      ),
      array(
        'key' => 'featured', 
        'compare' => 'NOT EXISTS'
      )
    )
  ),
  'order'        => 'ASC',
  'orderby'      => 'featured menu_order',
  
);


// $context["articles"] = new Timber\PostQuery($article_query);
$context["articles"] = Timber::get_posts($article_query);
// echo  $timber_post->ID;

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}


