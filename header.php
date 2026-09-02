<?php
/**
 * Theme header for the Composer-managed Timber theme.
 *
 * Third-party plugins may call wp_head() and render through the Timber pipeline.
 * The output buffer is started here so the final content can be assembled in the
 * Twig templates used by the theme.
 *
 * @package  ArchisWordpressTheme
 * @subpackage  Timber
 * @since   2026-09-02
 */

$GLOBALS['timberContext'] = Timber::context();
ob_start();
