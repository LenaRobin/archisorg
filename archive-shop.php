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

$context = Timber::context();
$context["body_class"] = "shop";
$context["page_class"] = "page--shop";
$context["enable_layers"] = true;

// // Get the page content from the shop page (not post)
$shop_page = get_page_by_path('shop');
if ($shop_page) {
    // $context['page'] = new Timber\Post($shop_page);
    $context['page'] = Timber::get_post($shop_page);
} else {
    // Fallback to current post
    // $timber_post = new Timber\Post();
    $timber_post = Timber::get_post();
    $context['post'] = $timber_post;
}

// Get current page for pagination
global $paged;
if (!isset($paged) || !$paged){
  $paged = 1;
}

// Get queryparameter from URL for category filtering
$context['query'] = get_query_var('category');
// Also check for direct URL parameter
if (empty($context['query']) && isset($_GET['category'])) {
    $context['query'] = sanitize_text_field($_GET['category']);
}

// Reset to page 1 if category filter is applied
if (!empty($context['query'])) {
    $paged = 1;
}

// ALWAYS use custom query - never rely on WordPress default query
$query_shop = array(
  'posts_per_page'  => 36,
  'post_type'       => 'shop',
  'paged'           => $paged,
  'post_status'     => 'publish',
  'orderby'         => 'date',
  'order'           => 'DESC',
);

// Get queryparameter from URL for category filtering
$context['query'] = get_query_var('category');
// Also check for direct URL parameter
if (empty($context['query']) && isset($_GET['category'])) {
    $context['query'] = sanitize_text_field($_GET['category']);
}

if ($context['query'] != '') {
  $category = get_category_by_slug($context['query']);
  if ($category) {
    $query_shop['category__and'] = $category->cat_ID;
  }
}

// ALWAYS use custom query - this ensures fresh data
// $context['shopitems'] = new Timber\PostQuery($query_shop);
$context['shopitems'] = Timber::get_posts($query_shop);

// Categories lookup - force refresh
$shop_category = get_category_by_slug('shop');
if ($shop_category) {
  $query_categories = array( 
    'parent' => $shop_category->cat_ID,
    'orderby' => 'count',
    'order' => 'DESC',
    'hide_empty' => true,
  );
  $context['categories'] = get_categories($query_categories);
} else {
  $context['categories'] = array();
}

// Force template to use our context
Timber::render(array('archive-shop.twig', 'page.twig'), $context);


