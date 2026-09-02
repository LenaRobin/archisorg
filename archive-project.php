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

$templates = array( 'archive-project.twig');

$context = Timber::context();
$context["body_class"] = "volume";

$terms = get_terms( 'project_cat', array(
    'hide_empty' => false,
) );
$context['categories'] = [];



foreach ($terms as $key => $term) {
  
//   $context["categories"][] = new Timber\Term($term->term_id, "project_cat");  
  $context["categories"][] = Timber::get_term($term->term_id, "project_cat");
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

usort($context["categories"], 'project_sort');


$args = array(
	'post_type' => 'project',
	'posts_per_page' => 4,
	'order_by' => 'publish_date'
);
// $context['posts'] = new Timber\PostQuery($args);
$context['posts'] = Timber::get_posts($args);
Timber::render( $templates, $context );
