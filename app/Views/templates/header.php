<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INF2003 Database Project</title>
    <script src="https://kit.fontawesome.com/ff4ebf2f5e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans:italic,bold,700, 400">
    <script defer src="https://use.fontawesome.com/releases/v5.11.2/js/all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>

<style>
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: 'PT Sans', 'Arial';
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
    }

    .nav-item {
        margin-left: 5px;
    }

    .nav-link {
        font-size: 16px;
        font-weight: 700;
    }
    
    .nav-link i {
        margin-right: 2px;
    }

    .nav-sub-link {
        font-size: 14px !important;
        color: black !important;
        font-weight: normal;
    }

    .active {
        border-bottom: 2px solid black;
        font-weight: 700;
    }

    .sign-in-container {
        background-color: rgb(0, 0, 0);
        border-radius: 20px;
        transition: color .1s linear,background-color .1s linear,border-color .1s linear
    }

    .sign-in-container a {
        color: white;
        padding: 10px 16px !important;
    }

    .sign-in-container a:hover {
        background-color: #eee;
        border-radius: 20px;
    }

    @media print {
        .noprint {
            display: none;
        }
    }

</style>
    <?php
    $directoryURI = $_SERVER['REQUEST_URI'];
    $path = parse_url($directoryURI, PHP_URL_PATH);
    $components = explode('/', $path);
    $first_part = $components[1];
    ?>
    <div class="navigation-bar content-container noprint">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid justify-content-between align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="<?= base_url('home') ?>">
                <img src="<?= base_url('images/tripadvisor-icon.png') ?>" alt="Logo" width="40" height="40" class="d-inline-block align-text-center">
                AdviceTrip
                </a>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <?php if(session()->get('isLoggedIn') !== null && !empty(session()->get('username')) && session()->get('type') == 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('reviews') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>    
                            Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('trips') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>    
                            Trips</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Log out</a>
                        </li>
                        <?php elseif(session()->get('isLoggedIn') !== null && !empty(session()->get('username')) && session()->get('type') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('hotels/dashboard') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>    
                            Manage Hotels</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('things-to-do/dashboard') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>    
                            Manage Attractions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('restaurants/dashboard') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>    
                            Manage Restaurants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('reviews') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>    
                            Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('trips') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>    
                            Trips</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Log out</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('signup') ?>">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Sign Up</a>
                        </li>

                        <li class="nav-item sign-in-container">
                            <a class="nav-link" href="<?= base_url('signin') ?>">
                            Sign In</a>
                        </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="sub-navigation-bar border-top border-bottom noprint">
        <nav class="navbar navbar-expand-lg content-container">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="hotels") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('hotels') ?>">Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="things-to-do") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('things-to-do') ?>">Things to Do</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="restaurants") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('restaurants') ?>">Restaurants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="flights") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('flights') ?>">Flights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="guides") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('guides') ?>">Travel Guides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-sub-link nav-link <?php if ($first_part=="chatbot") {echo "active"; } else { echo ""; } ?>" href="<?= base_url('chatbot') ?>">Chatbot</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
