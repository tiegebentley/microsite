<!DOCTYPE html>
<html lang="<?= $site->lang() ?>">
<head>
  <?php snippet('layouts/head') ?>
  <link rel="stylesheet" href="<?= url('assets/css/layouts/services.css') ?>">
</head>
<body>

  <?php snippet('layouts/header') ?>
  
  <?php snippet('templates/services/leader-toggle') ?>
  <?php snippet('templates/services/content') ?>
  <?php snippet('templates/services/services') ?>
  <?php snippet('templates/service/contact') ?>

  <?php snippet('seo/schemas'); ?>

</body>

<?php snippet('layouts/footer') ?>

</html>