<style>

    .section-divider {
        margin-top: 64px;
    }

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    /* Navigation Bar CSS */
    .navbar {
        height: 60px;
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
    }

    .nav-link {
        font-size: 16px;
        font-weight: 700;
    }

    .nav-link svg {
        margin-right: 5px;
    }

    .col-2 button {
        width: 100%;
        height: 68px;
        justify-content: space-between;
        border: 1px solid black;
    }

    /* Main Menu CSS */
    .main-menu-container {
        padding-top: 32px;
        padding-bottom: 24px;
    }

    .main-menu-container .col-2 {
        padding: 0 4px 0 4px;
    }

    .main-menu-container .btn {
        background-color: transparent;
        padding: 11px 16px 11px 16px;
    }

    .main-menu-container .btn:hover {
        background-color: black;
        color: white;
    }

    .main-menu-container .btn:hover svg {
        fill: white !important;
    }

    .button-text {
        text-align: left;
        max-width: 111px;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
    }

    /* Best Hotels CSS */
    .best-hotels-background-container {
        height: 500px;
        position: relative;
    }

    .best-hotels-background {
        width: 100%;
        height: 100%;
        max-height: 100%;
        object-fit: cover !important;
        filter: brightness(85%);
    }

    .best-hotels-heading-container {
        width: 100%;
        position: absolute;
        color: white;
        top: 65%;
        padding: 0px 24px 0 24px;
    }

    .best-hotels-heading-container .btn {
        display: block;
        margin-top: 16px;
        padding: 14px 24px 14px 24px;
        color: black;
        background-color: white;
        border-radius: 24px;
        font-size: 16px;
    }

    .best-hotels-heading-container .btn:hover {
        background-color: lightgrey;
    }

    /* Best Hotels Category CSS */
    .best-hotels-category-heading-container {
        margin-bottom: 16px;
    }

    .category-header {
        font-size: 24px;
    }

    .category-subheader {
        font-size: 16px;
    }

    .best-hotels-category-container .row {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .best-hotels-category-container .row::-webkit-scrollbar {
        display: none;
    }

    .best-hotels-category-container .col-3 {
        display: inline-block;
        float: none;
        position: relative;
        padding-left: 6px;
        padding-right: 6px;
    }

    .best-hotels-category-container .col-3 img {
        width: 100%;
        height: 100%;
        object-fit: cover !important;
        filter: brightness(80%);
    }

    .best-hotels-category-container .col-3 span {
        display: block;
        position: absolute;
        top: 80%;
        left: 10%;
        color: white;
        font-size: 28px;
        font-weight: 800;
    }

    .best-hotels-category-container .row > .col-3:first-child {
        margin-left: -6px;
    }

    .best-hotels-category-container .row > .col-3:last-child {
        margin-right: -6px;
    }

    /* Top Experiences CSS */
    .top-experiences-heading-container {
        margin-bottom: 16px;
    }

    .top-experiences-content-container .col-3 {
        padding-left: 6px;
        padding-right: 6px;
    }

    .top-experiences-content-container .row > .col-3:first-child {
        margin-left: -6px;
    }

    .top-experiences-content-container .row > .col-3:last-child {
        margin-right: -6px;
    }

    .top-experiences-content-container .card {
        border: none;
    }

    .top-experiences-content-container .card-img-top {
        padding-bottom: 8px;
    }

    .top-experiences-content-container .card-body {
        padding: 0 !important;
    }

    .top-experiences-content-container .card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .card-review {
        display: inline-block;
    }

    .card-review i {
        vertical-align: middle;
    }

    .card-review .checked {
        color: rgb(0, 170, 108);
    }

    .top-experiences-content-container .card-review-amount {
        font-size: 12px;
        color: rgb(140, 140, 140);
        line-height: 16px;
        margin-left: 5px;
    }

    .top-experiences-content-container .card-text {
        color: rgb(140, 140, 140);
        font-size: 12px;
        line-height: 16px;
    }

    /* More To Explore CSS */
    .more-to-explore-container {
        background-color: #faf1ed;
    }
    
    .more-to-explore-background-container {
        padding-top: 32px;
        padding-bottom: 32px;
    }

    .more-to-explore-heading-container {
        margin-bottom: 16px;
    }

    .more-to-explore-content-container .row > .col-4:first-child {
        margin-left: -8px;
    }

    .more-to-explore-content-container .row > .col-4:last-child {
        margin-right: -8px;
    }

    .more-to-explore-content-container .col-4 {
        padding-left: 8px;
        padding-right: 8px;
    }

    .more-to-explore-content-container .card {
        border: none;
    }

    .more-to-explore-content-container img {
        object-fit: cover;
    }

    .more-to-explore-content-container .card-title {
        font-size: 18px;
        font-weight: 700;
        line-height: 22px;
    }

    .more-to-explore-content-container .card-body {
        padding: 24px 24px 32px 24px;
    }

    /* Top Destinations CSS */
    .top-destinations-heading-container {
        margin-bottom: 16px;
    }

    .top-destinations-container .row {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .top-destinations-container .row::-webkit-scrollbar {
        display: none;
    }

    .top-destinations-container .col-3 {
        display: inline-block;
        float: none;
        position: relative;
        padding-left: 6px;
        padding-right: 6px;
    }

    .top-destinations-container .col-3 img {
        width: 100%;
        height: 100%;
        object-fit: cover !important;
        filter: brightness(80%);
    }

    .top-destinations-container .col-3 .wrap-text-container {
        position: absolute;
        bottom: 0;
        padding: 32px 16px 16px 16px;
    }

    .top-destinations-container .col-3 .wrap-text {
        position: relative;
        text-align: left;
    }

    .top-destinations-container .col-3 span {
        color: white;
        font-size: 28px;
        font-weight: 800;
        white-space: normal;
        line-height: 28px;
        letter-spacing: 0.02em;
    }

    .top-destinations-container .row > .col-3:first-child {
        margin-left: -6px;
    }

    .top-destinations-container .row > .col-3:last-child {
        margin-right: -6px;
    }

    .col-3 img {
        padding-bottom: 8px;
        height: 190px;
        object-fit: cover;
    }

    .col-3 .card-title {
        font-size: 16px;
        line-height: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

</style>

<div class="main-content-container">
    <div class="navigation-bar content-container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid justify-content-between align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
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
        <div class="main-menu-container container text-center">
            <div class="row justify-content-start">
                <div class="col-2">
                  <a href=<?= base_url('hotels')?> style="text-decoration: none;" >
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Hotels</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
                <div class="col-2">
                  <a href=<?= base_url('things-to-do')?> style="text-decoration: none;">
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Things to Do</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
                <div class="col-2">
                  <a href=<?= base_url('flights') ?> style="text-decoration: none;">
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Flights</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
                <div class="col-2">
                  <a href=<?= base_url('restaurants') ?> style="text-decoration: none;">
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Restaurants</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
                <div class="col-2">
                  <a href=<?= base_url('guides') ?> style="text-decoration: none;">
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Travel Guides</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
                <div class="col-2">
                  <a href=<?= base_url('chatbot') ?> style="text-decoration: none;">
                    <button type="button" class="btn btn-light d-flex justify-content-between">
                        <span class="button-text">Chatbot</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg></button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="best-hotels-container content-container">
        <div class="best-hotels-background-container">
            <img src="<?= base_url('images/best-hotel-background.jpg') ?>" class="img-fluid best-hotels-background">
            <div class="best-hotels-heading-container">
                <h2>Check into the world's best hotels</h2>
                <span>See 2023's Travellers' Choice Best of the Best winners.</span>
                <a class="btn" href="<?= base_url('hotels') ?>" style="max-width:150px;">See the list</a>
            </div>
        </div>
    </div>

    <div class="best-hotels-category-container section-divider content-container">
        <div class="best-hotels-category-heading-container">
            <h2 class="category-header">Explore top hotels by category</h2>
            <span class="category-subheading">From fam-friendly to next-level luxe and more</span>
        </div>
        <div class="best-hotels-category-content-container">
            <div class="container">
                <div class="row flex-nowrap overflow-auto">
                    <div class="col-3">
                        <img src="<?= base_url('images/best-hotels-category-1.jpeg') ?>" class="img-fluid">
                        <span>Top World</span>
                        <a class="stretched-link" href="<?= base_url('hotels') ?>"></a>
                    </div>
                    <div class="col-3">
                        <img src="<?= base_url('images/best-hotels-category-2.jpeg') ?>" class="img-fluid">
                        <span>Hottest New</span>
                        <a class="stretched-link" href="<?= base_url('hotels') ?>"></a>
                    </div>
                    <div class="col-3">
                        <img src="<?= base_url('images/best-hotels-category-3.jpeg') ?>" class="img-fluid">
                        <span>Swimming Pool</span>
                        <a class="stretched-link" href="<?= base_url('hotels/search-name/united%20kingdom/pool') ?>"></a>
                    </div>
                    <div class="col-3">
                        <img src="<?= base_url('images/best-hotels-category-4.jpeg') ?>" class="img-fluid">
                        <span>Luxury</span>
                        <a class="stretched-link" href="<?= base_url('hotels/search-name/united%20kingdom/butler') ?>"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="top-experiences-container section-divider content-container">
        <div class="top-experiences-heading-container">
            <h2 class="category-header">Top experiences on Tripadvisor</h2>
            <span class="category-subheading">The best tours, activities and tickets</span>
        </div>
        <div class="top-experiences-content-container">
            <div class="container">
                <div class="row">
                    <?php if (! empty($trending_attractions) && is_array($trending_attractions)): ?>
                        <?php foreach($trending_attractions as $attraction): ?>
                            <div class="col-3">
                                <div class="card">
                                    <img src="<?php echo isset($attraction['images']) ? $attraction['images'] : base_url('images/top-experiences-1.jpeg'); ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($attraction['name']) ?></h5>
                                        <div class="card-review">
                                        <?php if ($attraction['rating'] <= 0): ?>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] <= 1 && $attraction['rating'] > 0): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] > 1 && $attraction['rating'] <= 2): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] > 2 && $attraction['rating'] <= 3): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] > 3 && $attraction['rating'] <= 4): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] > 4 && $attraction['rating'] < 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($attraction['rating'] = 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <?php endif ?>
                                            <span class="card-review-amount align-middle"><?= esc($attraction['rating_count']) ?> Reviews</span>
                                        </div>
                                        <p class="card-text"><?= $attraction['country_name'] ?></p>
                                        <a class="stretched-link" href="<?= base_url('things-to-do/view/') . $attraction['country_name'] . '/' . $attraction['attraction_id'] ?>"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="top-experiences-container section-divider content-container">
        <div class="top-experiences-heading-container">
            <h2 class="category-header">Top restaurants on Tripadvisor</h2>
            <span class="category-subheading">The best food, cuisines and culture</span>
        </div>
        <div class="top-experiences-content-container">
            <div class="container">
                <div class="row">
                    <?php if (! empty($trending_restaurants) && is_array($trending_restaurants)): ?>
                        <?php foreach($trending_restaurants as $restaurant): ?>
                            <div class="col-3">
                                <div class="card">
                                    <img src="<?php echo isset($restaurant['images']) ? $restaurant['images'] : base_url('images/top-restaurants-1.jpeg'); ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($restaurant['name']) ?></h5>
                                        <div class="card-review">
                                        <?php if ($restaurant['rating'] <= 0): ?>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] <= 1 and $restaurant['rating'] > 0): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] > 1 and $restaurant['rating'] <= 2): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] > 2 and $restaurant['rating'] <= 3): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] > 3 and $restaurant['rating'] <= 4): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] > 4 and $restaurant['rating'] < 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($restaurant['rating'] = 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <?php endif ?>
                                            <span class="card-review-amount align-middle"><?= esc($restaurant['rating_count']) ?> Reviews</span>
                                        </div>
                                        <p class="card-text"><?= $restaurant['country_name'] ?></p>
                                        <a class="stretched-link" href="<?= base_url('restaurants/view/') . $restaurant['country_name'] . '/' . $restaurant['eatery_id'] ?>"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="top-experiences-container section-divider content-container">
        <div class="top-experiences-heading-container">
            <h2 class="category-header">Top hotels on Tripadvisor</h2>
            <span class="category-subheading">The best accomodations, comfy and cozy</span>
        </div>
        <div class="top-experiences-content-container">
            <div class="container">
                <div class="row">
                    <?php if (! empty($trending_hotels) && is_array($trending_hotels)): ?>
                        <?php foreach($trending_hotels as $hotel): ?>
                            <div class="col-3">
                                <div class="card">
                                    <img src="<?php echo isset($hotel['images']) ? $hotel['images'] : base_url('images/best-hotels-category-1.jpeg'); ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($hotel['name']) ?></h5>
                                        <div class="card-review">
                                        <?php if ($hotel['rating'] <= 0): ?>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] <= 1 and $hotel['rating'] > 0): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] > 1 and $hotel['rating'] <= 2): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] > 2 and $hotel['rating'] <= 3): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] > 3 and $hotel['rating'] <= 4): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] > 4 and $hotel['rating'] <= 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($hotel['rating'] = 5): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <?php endif ?>
                                            <span class="card-review-amount align-middle"><?= esc($hotel['rating_count']) ?> Reviews</span>
                                        </div>
                                        <p class="card-text"><?= $hotel['country_name'] ?></p>
                                        <a class="stretched-link" href="<?= base_url('hotels/view/') . $hotel['country_name'] . '/' . $hotel['hotel_id'] ?>"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="more-to-explore-container section-divider">
        <div class="more-to-explore-background-container content-container">
            <div class="more-to-explore-heading-container">
                <h2 class="category-header">More to explore</h2>
            </div>
            <div class="more-to-explore-content-container">
                <div class="container">
                    <div class="row">
                        <div class="col-4 d-flex align-items-stretch">
                            <div class="card">
                                <img src="<?= base_url('images/more-to-explore-1.jpeg') ?>" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Your summer break list: 7 must-do experiences for an adventure of a lifetime</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex align-items-stretch">
                            <div class="card">
                                <img src="<?= base_url('images/more-to-explore-1.jpeg') ?>" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title text-center">A local's guide to Bangkok's best art galleries, cocktail bars, and more</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex align-items-stretch">
                            <div class="card">
                                <img src="<?= base_url('images/more-to-explore-1.jpeg') ?>" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title text-center">4 best hawker centers in Singapore-and what to eat there</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
