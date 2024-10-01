<?php

/**
 * Update version.
 */
update_option('idonate_version', '2.1.0');
update_option('idonate_db_version', '2.1.0');

/**
 * Remove the page if it exists.
 */
function idonate_remove_pages()
{
	// Pages to Delete
	$pages = array(
		'Donor Login',
		'Donor Info',
		'Donor Profile',
		'Donor Edit',
	);

	foreach ($pages as $page) {
		$args = array(
			'post_type'   => 'page',
			'title'       => $page,
			'post_status' => 'any',
			'numberposts' => 1,
		);

		$existing_page = get_posts($args);

		if (!empty($existing_page)) {
			wp_delete_post($existing_page[0]->ID, true);
		}
	}
}

idonate_remove_pages();

// Create page when plugin loaded
function idonate_create_page_plugin_loaded()
{
	// Default Pages to Create
	$pages = array(
		'Dashboard',
	);

	foreach ($pages as $page) {
		$args = array(
			'post_type'   => 'page',
			'title'       => $page,
			'post_status' => 'any',
			'numberposts' => 1,
		);

		$existing_page = get_posts($args);

		if (empty($existing_page)) {
			$Requestargs = array(
				'post_type'   => 'page',
				'post_title'  => wp_strip_all_tags($page),
				'post_status' => 'publish',
			);
			wp_insert_post($Requestargs);
		}
	}
}

add_action('init', 'idonate_create_page_plugin_loaded');

function idonate_flush_rewrite_rules_on_update()
{
	idonate_create_page_plugin_loaded();
	flush_rewrite_rules();
}

add_action('init', 'idonate_flush_rewrite_rules_on_update');
