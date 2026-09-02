<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'archive-project_cat.twig');

$context = Timber::context();
$context["body_class"] = "volume volume-category";
global $wp_query;

$context["term"] = Timber::get_term(get_queried_object_id());

$posts = $context["term"]->posts(10000);


$context["categories"] = [];
$context["posts"] = [];
foreach ($posts as $key => $post) {
  $cats = $post->terms("project_art_cat");
  foreach ($cats as $key2 => $cat) {
    if(!in_array($cat, $context["categories"])) {
      $context["categories"][] = $cat;
    }
  }
  if(isset($_GET["category"])) {
    
    foreach ($cats as $key2 => $cat) {
      if($_GET["category"] == $cat->slug) {
        $context["posts"][] = $post;
        break;
      }
    }
  } else {
    $context["posts"][] = $post;  
  }
  
}



Timber::render( $templates, $context );
