<div class="col-9 ms-sm-auto col-lg-10 px-md-4">
	<div class="dropdown">
		<label class="form-label subtitle-1">Select the form version of the results to view</label>
		<button class="btn btn-primary dropdown-toggle button-style ms-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
			Select a version
		</button>
		<ul class="dropdown-menu">
			<?php foreach ($form_versions as $version) : ?>
				<li><a class="dropdown-item" href="<?= base_url('form-submissions/') . esc($current_form_id, 'url') . '/' . esc($version['form_history_id'], 'url') ?>"><?= esc($version['form_version']) ?></a></li>
			<?php endforeach ?>
		</ul>
	</div>
	<?php if (!empty($submissions) && is_array($submissions)) : ?>
		<h2 class="mt-4 h4-style">Forms Submissions</h2>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<?php foreach ($headers as $header) : ?>
							<th scope="col"><?= esc($header) ?></th>
						<?php endforeach ?>
							<th>Submission Date</th>
							<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rows as $index => $row) : ?>
						<tr>
							<?php foreach ($row as $rowitem) : ?>
								<td><?= esc($rowitem) ?></td>
							<?php endforeach ?>
							<td><?= esc($form_submissions[$index]['submission_date']) ?></td>
							<td>
								<a class="btn btn-primary" href="<?= base_url('form-submissions/view/') . esc($form_submissions[$index]['form_submission_id']) ?>">View</a>
								<a class="btn btn-primary" href="<?= base_url('form-submissions/edit/') . esc($form_submissions[$index]['form_submission_id']) ?>">Edit</a>
								<a class="btn btn-primary" href="<?= base_url('form-submissions/delete/') . esc($form_submissions[$index]['form_submission_id']) ?>">Delete</a>
								<a class="btn btn-primary" href="<?= base_url('form-submissions/print/') . esc($form_submissions[$index]['form_submission_id']) ?>">Print</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	<?php elseif (empty($current_form_history_id)): ?>
		<h2 class="mt-4 h4-style">Form Submissions</h2>
		<p class="body-1">Please select a form version to view the submissions for this form</p>
	<?php else : ?>
		<h2 class="mt-4 h4-style">No Form Submissions</h2>
		<p class="body-1">Unable to find any submissons for this form for you.</p>
	<?php endif ?>
</div>