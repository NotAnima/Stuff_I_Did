
<div class="col-9 ms-sm-auto col-lg-10 px-md-4">
	<div class="dropdown">
		<label class="form-label subtitle-1">Select the form version of the results to view</label>
		<button class="btn btn-primary dropdown-toggle button-style ms-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
			Select a version
		</button>
		<ul class="dropdown-menu">
			<?php foreach ($form_versions as $version) : ?>
				<li><a class="dropdown-item" href="<?= base_url('forms/') . esc($current_form_id, 'url') . '/' . esc($version['form_history_id'], 'url') ?>"><?= esc($version['form_version']) ?></a></li>
			<?php endforeach ?>
		</ul>
	</div>
    <h2><?= esc($title) ?></h2>
    <?php if(isset($errors)): ?>
        <?= $errors ?>
    <?php endif ?>
    <?= $form ?>
  <?php if ($form_current_version !== $form_latest_version && isset($form_current_version)): ?>
    <a class="btn btn-primary button-style" href="<?= base_url('forms/revert/') . esc($current_form_id, 'url') . '/' . esc($form_history_id, 'url') ?>">Revert to This Version</a>
  <?php endif ?>
</div>
