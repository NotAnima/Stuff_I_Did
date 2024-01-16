<div class="col-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container">
        <div class="heading">
            <h5>Are you sure you want to delete this form ?</h5>
        </div>
        <div class="sub-heading">
            <p>If you delete this form, all form submissions will be deleted.</p>
        </div>
        <a class="btn btn-primary button-style" href="<?= base_url('forms/delete/') . esc($id) ?>">Confirm Delete</a>
        <a class="btn btn-primary button-style" href="<?= base_url('dashboard') ?>">Cancel</a>
    </div>
</div>