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

$templates = array( 'archive-events.twig');

$context = Timber::context();
$context["body_class"] = "events";
$date_now = date('Y-m-d H:i:s');

$future = array(
  'posts_per_page'  => -1,
  'post_type'     => 'event',
  'meta_query'     => array(
   'relation'      => 'AND',
   array(
          'key'      => 'to',
          'compare'    => '>=',
          'value'      => $date_now,
          'type'     => 'DATETIME'
   )
    ),
  'order'        => 'ASC',
  'orderby'      => 'meta_value',
  'meta_key'     => 'from',
  'meta_type'      => 'DATETIME'
);
$past = array(
  'posts_per_page'  => -1,
  'post_type'     => 'event',
  'meta_query'     => array(
   'relation'      => 'AND',
   array(
          'key'      => 'to',
          'compare'    => '<',
          'value'      => $date_now,
          'type'     => 'DATETIME'
   )
    ),
  'order'        => 'DESC',
  'orderby'      => 'meta_value',
  'meta_key'     => 'from',
  'meta_type'      => 'DATETIME'
);
$context['future'] = Timber::get_posts($future);
$context['past'] = Timber::get_posts($past);

Timber::render( $templates, $context );
