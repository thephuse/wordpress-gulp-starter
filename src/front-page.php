<?php

  /* Timber Instance */
  $timber = new Timber();

  /* Context */
  $context = $timber->get_context();
  $context['page'] = $timber->get_post();

  /* Renderer */
  return $timber->render('templates/front-page.twig', $context);

?>
