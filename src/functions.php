<?php

function timber_check() {
  if (!class_exists('Timber')) {
    echo '<a href="/wp-admin/plugins.php#timber">Activate Timber</a>';
    return;
  }
}

function theme_register_types() {
  $post_types = json_decode(file_get_contents(get_template_directory()."/post-types.json"), true);
  foreach($post_types as $post_type)
    register_post_type($post_type['name'], $post_type['settings']);
}

function theme_register_taxonomies() {
  $taxonomies = json_decode(file_get_contents(get_template_directory()."/taxonomies.json"), true);
  foreach($taxonomies as $taxonomy)
    register_taxonomy($taxonomy['name'], $taxonomy['post_types'], $taxonomy['settings']);
}

function theme_register_menus() {
  register_nav_menus([
    'main' => __('Main')
  ]);
}

function theme_unregister_taxonomy() {
  global $wp_taxonomies;
  $taxonomies = [/*'category', 'post_tag'*/];
  foreach($taxonomies as $taxonomy) {
    if (taxonomy_exists($taxonomy)) unset($wp_taxonomies[$taxonomy]);
  }
}

function theme_add_to_context($context) {
  $context['main_menu'] = new TimberMenu('main');
  $context['logo'] = get_header_image();
  $context['is_front_page'] = is_front_page();
  $context['is_search'] = is_search();
  $context['is_taxonomy'] = is_tax();
  $context['site_public'] = (bool) get_option('blog_public');
  $context['posts_page_url'] = get_permalink(get_option('page_for_posts'));
  return $context;
}

function theme_after_setup_theme() {
  add_theme_support('post-thumbnails');
  add_theme_support('custom-header');
}

function theme_upload_mimes($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['gpx'] = 'application/gpx+xml';
  return $mimes;
}

function theme_acf_json_save_directory($path) {
  $src = dirname(get_home_path()).'/src/acf-json';
  if (is_writable($src . '/test.json')) {
    $path = dirname(get_home_path()).'/src/acf-json';
  } else {
    $path = get_stylesheet_directory().'/acf-json';
    return $path;
  }
}

timber_check();

add_action('init', 'theme_unregister_taxonomy');
add_action('init', 'theme_register_menus');
add_action('init', 'theme_register_types');
add_action('init', 'theme_register_taxonomies');
add_action('after_setup_theme', 'theme_after_setup_theme');

add_filter('get_twig', 'theme_add_to_twig');
add_filter('timber_context', 'theme_add_to_context');
add_filter('upload_mimes', 'theme_upload_mimes');
add_filter('acf/settings/save_json', 'theme_acf_json_save_directory');

?>
