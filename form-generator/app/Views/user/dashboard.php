<div class="col-9 ms-sm-auto col-lg-10 px-md-4">
	<?php if (!empty($forms) && is_array($forms)) : ?>
		<h2>Forms</h2>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Form Name</th>
						<th scope="col">Description</th>
						<th scope="col">Created Date</th>
						<th scope="col">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($forms as $form) : ?>
						<tr>
							<td><?= esc($form['form_id']) ?></td>
							<td><?= esc($form['form_name']) ?></a></td>
							<td><?= esc($form['form_description']) ?></td>
							<td><?= esc($form['created_date']) ?></td>
							<td>
								<a href="<?= base_url('forms/') . esc($form['form_id'], 'url') ?>" class="btn btn-primary button-style">View</a>
								<a href="<?= base_url('forms/edit/') . esc($form['form_id'], 'url') ?>" class="btn btn-primary button-style">Edit</a>
								<a href="<?= base_url('forms/delete-confirmation/') . esc($form['form_id'], 'url') ?>" class="btn btn-primary button-style">Delete</a>
								<a href="<?= base_url('forms/print/') . esc($form['form_id'], 'url') ?>" class="btn btn-primary button-style">Print</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<h2 class="mt-4 h4-style">No Forms</h2>
		<p class="body-1">Unable to find any forms for you.</p>
	<?php endif ?>
</div>
