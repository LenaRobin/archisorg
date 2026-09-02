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
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;






$context["body_class"] = "projects volume-post projects-post";

$context["next"] = false;
$found = false;
foreach ($timber_post->terms("project_cat") as $key => $proj) {
  foreach ($proj->posts(1000) as $key => $p) {
    if($found) {
      $context["next"] = $p;
      break 2;
    }
    if($p == $timber_post) {
      $found = true;
    }
  }
}

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}


