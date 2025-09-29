<!DOCTYPE html>
<html lang="<?= $site->lang() ?>">
<head>
  <?php snippet('layouts/head') ?>
  <?= Bnomei\Fingerprint::css('assets/css/layouts/default.css') ?>
</head>
<body>

  <?php snippet('layouts/header') ?>


	<?php
	if ($page->showLeader()->toBool() === true): ?>


	<?php snippet('layouts/leader') ?>
	<div class="container grid">
		<?php snippet('templates/default/text-leader') ?>
		<?php snippet('form/thank-you') ?>
	</div>

	<?php else : ?>

	<div class="container grid">
		<?php snippet('templates/default/text') ?>
		<?php snippet('form/thank-you') ?>
	</div>

	<?php endif ?>
	
	<?php snippet('seo/schemas'); ?>

</body>

<?php snippet('layouts/footer') ?>

</html>