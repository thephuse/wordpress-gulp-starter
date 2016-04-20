<?php
  if (is_front_page()) require_once(__DIR__.'/front-page.php');
  if (is_search()) require_once(__DIR__.'/blog.php');
?>
