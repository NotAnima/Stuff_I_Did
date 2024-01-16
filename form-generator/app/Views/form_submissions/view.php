
<div class="col-9 ms-sm-auto col-lg-10 px-md-4">
    <h2><?= esc($title) ?></h2>
    <?= $form ?>
    <?php if(!empty($files)): ?>
        <?php foreach($files as $index => $file): ?>
            <a class="btn btn-primary button-style" target="_blank" href="<?= base_url($index) ?>">View Uploaded File</a>
        <?php endforeach ?>
    <?php endif ?>
</div>