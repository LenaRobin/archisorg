# Archis_org_Wordpress_Theme

This folder contains the Archis website theme source for the WordPress site. It is intentionally kept as a theme-only repository and does not include the full WordPress core, database dumps, or uploaded media.

## Timber / Twig setup

This theme is configured to use the Composer-managed Timber dependency chain instead of the legacy Timber WordPress plugin approach.

- Timber package: `timber/timber` ^2.0
- Installed version: `v2.5.1`
- Twig dependency: `twig/twig` ^3.27
- Installed version: `v3.28.0`

The theme bootstraps Timber in `functions.php` by loading `vendor/autoload.php` and calling `Timber\Timber::init();`.

## Important maintenance note

The old `timber-library` plugin is legacy and should not be relied on for the theme runtime. If it remains installed and active, it can mask dependency issues and create confusion during debugging.

## Local development guidance

From the theme directory:

```bash
composer install
```

After composer install, ensure the theme loads without the plugin-based Timber path and that Twig templates render from the `templates/` directory.

## Security note

This theme migration to Timber 2.x and Twig 3.x is part of the long-term maintenance and security upgrade path. It improves compatibility with the currently maintained package chain, but it is not a substitute for full site hardening, malware cleanup, or plugin/theme review after a compromise.

See the project root README for instructions to rebuild the full local site environment.
