<?php
/**
 * Template Name: CI360: Case Studies / Work
 *
 * Pick this from Page Attributes on any Page you create yourself. Renders the CI360 "work" section recipe.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
ci_render_recipe_page( 'work' );
get_footer();
