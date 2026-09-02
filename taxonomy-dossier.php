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

$templates = array( 'archive.twig');

$context = Timber::context();
$context["body_class"] = "volume volume-category";
global $wp_query;

$context["term"] = Timber::get_term(get_queried_object_id());

global $paged;
if (!isset($paged) || !$paged){
  $paged = 1;
}
$query = array(
  'posts_per_page'  => 18,
  'post_type'     => 'article',
  'paged' => $paged,
  'tax_query' => array(
    array(
        'taxonomy' => 'dossier',
        'field' => 'term_id',
        'terms' => get_queried_object_id()
    )
  )
  // 'meta_query'     => array(
  //  'relation'      => 'AND',
  //  array(
  //         'key'      => 'to_date',
  //         'compare'    => '>=',
  //         'value'      => $date_now,
  //         'type'     => 'DATETIME'
  //  )
    // ),
  // 'order'        => 'ASC',
  // 'orderby'      => 'meta_value',
  // 'meta_key'     => 'from_date',
  // 'meta_type'      => 'DATETIME'
);
$context['posts'] = Timber::get_posts($query);

Timber::render( $templates, $context );
