<html lang="en">

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
    
    <div class="content-wrapper container">
        <h1><?= esc($title) ?></h1>
        <section class="content">
            <div class="container-fluid">
                <h4 class="mt-5 mb-3">Create Account Example</h4>
                <?= $form1 ?>
                <h4 class="mt-5 mb-3">Login Example</h4>
                <?= $form2 ?>
                <h4 class="mt-5 mb-3">Contact Us Example</h4>
                <?= $form3 ?>
                <h4 class="mt-5 mb-3">Edit Profile Example</h4>
                <?= $form4 ?>
                <h4 class="mt-5 mb-3">Schedule Meeting Example</h4>
                <?= $form5 ?>
            </div><!-- /.container-fluid -->
        </section>
    </div>
</body>

</html>