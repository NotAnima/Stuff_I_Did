<!doctype html>
<html>

<head>
	<title>Form Generator</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datetimepicker/jquery.datetimepicker.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/mode/htmlmixed/htmlmixed.min.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('styles/index.css') ?>">
</head>

<body>

	<nav class="navbar navbar-expand primary" id="print-button">
		<div class="container-fluid">
			<a class="navbar-brand on-primary h6-style" href="<?= base_url('dashboard') ?>">Dashboard</a>
			<div>
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="btn btn-primary button-style" href="<?= base_url('logout') ?>">Logout</a>
					</li>
				</ul>
			</div>
		</div>

	</nav>

	<div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
						<div class="position-sticky pt-3">
							<ul class="nav flex-column">
								<li class="nav-item">
									<span class="h6-style">Form Submissions</span>
								</li>
								<?php if (!empty($forms) && is_array($forms)) : ?>
									<?php foreach ($forms as $form) : ?>
										<li class="nav-item">
											<a class="nav-link subtitle-1" aria-current="page" href="<?= base_url('form-submissions/') . esc($form['form_id'], 'url') ?>"><?= esc($form['form_name']) ?></a>
										</li>
									<?php endforeach ?>
								<?php else : ?>
									<li class="nav-item">
										<p class="ms-3 mt-4 body-1">No Forms</p>
									</li>
								<?php endif ?>
							</ul>
						</div>
					</nav>

					<?= $this->renderSection('content') ?>