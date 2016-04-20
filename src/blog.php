<?php

/* Timber Instance */
$timber = new Timber();

/* Context */
$context = $timber->get_context();

/* Page */
$context['page'] = $timber->get_post();

/* Categories */
$context['categories'] = $timber->get_terms('category');

/* Search field text */
$context['search_query'] = get_search_query();

/* Posts loop */
$context['posts'] = $timber->get_posts([
  'posts_per_page' => get_option('posts_per_page'),
  'post_type'=>'post',
  's' => get_search_query()
]);

/* Renderer */
return $timber->render('templates/blog.twig', $context);

?>
