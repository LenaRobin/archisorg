<?php
/**
 * Theme footer for the Composer-managed Timber theme.
 *
 * wp_footer() is used here to flush the output buffer started in the header and
 * hand control to the Twig templates used by the site.
 *
 * @package  ArchisWordpressTheme
 * @subpackage  Timber
 * @since   2026-09-02
 */

$timberContext = $GLOBALS['timberContext']; // @codingStandardsIgnoreFile
if ( ! isset( $timberContext ) ) {
	throw new \Exception( 'Timber context not set in footer.' );
}
$timberContext['content'] = ob_get_contents();
ob_end_clean();
$templates = array( 'page-plugin.twig' );
Timber::render( $templates, $timberContext );
