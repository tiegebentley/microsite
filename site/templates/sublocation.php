<!DOCTYPE html>
<html lang="<?= $site->lang() ?>">
<head>
  <?php snippet('layouts/head') ?>
  <link rel="stylesheet" href="<?= url('assets/css/layouts/location.css') ?>">
</head>
<body>

  <?php snippet('layouts/header') ?>

  <?php
  if ($template->showTemplateLeader()->toBool() === true): ?>

  <?php snippet('templates/location/leader') ?>
  <?php snippet('templates/location/text-leader') ?>
  <?php else : ?>
  <?php snippet('templates/location/text') ?>
  <?php endif ?>
  <?php snippet('templates/location/related-locations', ['sublocations' => $relatedLocations]) ?>
  <?php snippet('templates/home/contact') ?>
  <?php snippet('seo/schemas'); ?>

</body>

<?php snippet('layouts/footer') ?>

</html>