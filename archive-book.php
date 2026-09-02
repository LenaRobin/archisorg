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

$templates = array( 'archive-book.twig');

$context = Timber::context();
$context["body_class"] = "books books-archive";
// global $paged;
// if (!isset($paged) || !$paged){
//   $paged = 1;
// }

$query = array(
  'posts_per_page'  => -1,
  'post_type'     => 'book',
  'paged' => $paged
  
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
// $context['posts'] = new Timber\PostQuery($query);
$context['posts'] = Timber::get_posts($query);
Timber::render( $templates, $context );
