<?php

function array_flatten($array) {
  return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), FALSE);
}

$get_terms_with_custom_fields = function($taxonomy) {
  $terms = get_terms($taxonomy);
  $terms_with_fields = array_map(function($term) {
    $fields = get_fields("{$term->taxonomy}_{$term->term_id}");
    foreach ($fields as $key => $value) {
      if (empty($term->$key)) {
        $term->$key = $value;
      }
    }
    return $term;
  }, $terms);
  $order = [];
  foreach ($terms_with_fields as $key => $value) {
    $order[$key] = (!empty($value->order)) ? $value->order : 9999;
  }
  array_multisort($order, SORT_ASC, $terms_with_fields);
  return $terms_with_fields;
};

$map_posts_to_topics = function($posts) {
  return function($topic) use ($posts) {
    $posts = array_filter($posts, function($post) use ($topic) {
      return (in_array($post->id, $topic->post_ids));
    });
    $topic->posts = $posts;
    return $topic;
  };
};

$get_posts_for_topic = function($topic) {
  global $wpdb;
  $sql = "SELECT `object_id` FROM $wpdb->term_relationships WHERE `term_taxonomy_id` = $topic->term_id";
  $topic->post_ids = array_flatten($wpdb->get_results($sql, ARRAY_N));
  return $topic;
};

?>
