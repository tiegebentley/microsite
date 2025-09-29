<section class="leader">

	<figure>

	    <?php if($image = $template->coverimage()->toFile()):
	    $thumb = $image->thumb('cover') ?>

	    <img src="<?= $thumb->url() ?>" alt="<?= $thumb->alt() ?>" />

	    <?php elseif($image = $site->coverimage()->toFile()):
	    $thumb = $image->thumb('cover') ?>

	    <img src="<?= $thumb->url() ?>" alt="<?= $thumb->alt() ?>" />
		
		<?php endif ?>

	</figure>

	<div class="leader-text-container">
		<div class="leader-text">

			<?= Str::template($template->leader()->kt(), [
              'location' => $page->title() ]) ?>
			<?php snippet('layouts/cta/leader', ['template' => $template]) ?>

          </div>
	</div>

</section>