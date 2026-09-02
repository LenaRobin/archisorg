<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context          = Timber::context();
$context["body_class"] = "about";
$context["page_class"] = "page--about";
$context["enable_layers"] = false;

$context['title'] = 'Search results for ' . get_search_query();


$categories = array("project_cat");
$search_keys = array('name__like', 'description__like');
$search_query = sanitize_text_field($_GET["s"]);
$exclude = [];
$context["found_terms"] = [];
foreach ($categories as $key => $cat) {
  foreach ($search_keys as $key => $s_key) {
    $args = array(
      'taxonomy'   => $cat,
      'hide_empty' => false,
      'exclude' => $exclude,
      $s_key => $search_query
    );  
    $terms = Timber::get_terms($args);

    foreach ($terms as $key => $term) {
      $exclude[] = $term->term_id;
      $context["found_terms"][] = $term;

    }

  }
    
}

$context['search_query'] =  get_search_query();
// $context['posts'] = new Timber\PostQuery();
$context['posts'] = Timber::get_posts();

Timber::render( $templates, $context );
