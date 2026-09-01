<?php
/*
Template Name: About
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
$context["body_class"] = "about";
$context["page_class"] = "page--about";
$context["enable_layers"] = false;
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-about.twig', 'page.twig' ), $context );
