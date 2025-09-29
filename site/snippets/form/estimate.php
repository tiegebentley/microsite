<?php if($site->email()->isNotEmpty()) : ?>

    <form action="<?php echo $page->url() ?>" method="POST">

        <div>
            <label for="name" class="required">First Name</label>
            <input<?php if ($form->error('name')): ?> class="error"<?php endif; ?> name="name" type="text" value="<?php echo $form->old('name') ?>">
        </div>

        <div>
            <label for="lastname" class="required">Last Name</label>
            <input<?php if ($form->error('lastname')): ?> class="error"<?php endif; ?> name="lastname" type="text" value="<?php echo $form->old('lastname') ?>">
        </div>

        <div>
            <label for="email" class="required">Email</label>
            <input<?php if ($form->error('email')): ?> class="error"<?php endif; ?> name="email" type="email" value="<?php echo $form->old('email') ?>">
        </div>

        <div>
            <label for="phone" class="required">Phone Number</label>
            <input<?php if ($form->error('phone')): ?> class="error"<?php endif; ?> name="phone" type="tel" value="<?php echo $form->old('phone') ?>">
        </div>

        <div>
            <label for="service" class="required">Services</label>
            <select name="service">
            <?php $value = $form->old('service') ?>
                <!-- Set the first option as default -->

                <?php 
                $services = $site->index()->filterBy('template', 'in', ['service']);
                foreach($services as $service): ?>
                
                <option value="<?= $service->slug() ?>"><?= $service->title() ?></option>

                <?php endforeach ?>

            </select>
            <?php snippet('form/error', ['field' => 'service']) ?>
        </div>

        <div class="form-full">
            <label for="message" class="required">Comment or Message</label>
            <textarea<?php if ($form->error('message')): ?> class="error"<?php endif; ?> name="message" rows="8" cols="40"><?php echo $form->old('message') ?></textarea>
        </div>

        <?php echo csrf_field() ?>
        <?php echo honeypot_field() ?>
        <input type="submit" value="Submit" class="btn btn--cta">
    </form>
    <?php if ($form->success()): ?>
        <?php go('thank-you') ?>
    <?php else: ?>
        <?php snippet('uniform/errors', ['form' => $form]) ?>
    <?php endif; ?>

<?php endif ?>