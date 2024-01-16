<style>
    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    /* Restaurant Image CSS */
    .restaurant-image-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .restaurant-image-container .restaurant-parent-container {
        height: 340px;
        padding: 0;
    }

    .restaurant-image-container .row {
        height: 100%;
        width: auto;
    }

    .restaurant-image-container .col-8 {
        height: 100%;
    }

    .restaurant-image-container .col-8 img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .restaurant-image-container .col-4 {
        height: 340px;
    }

    .restaurant-image-container .col-4 .image-container {
        height: 50%;
    }

    .restaurant-image-container .col-4 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Restaurant Review CSS */
    .restaurant-customer-review-heading-container {
        margin-bottom: 10px;
    }

    .restaurant-customer-review-heading {
        font-size: 28px;
        font-weight: 700;
        line-height: 32px;
    }

    .restaurant-customer-review-heading-container a {
        font-size: 16px;
        line-height: 18px;
        background-color: black;
        color: white;
        border-radius: 2px;
        font-weight: 700;
        padding: 8px 16px;
    }

    .restaurant-customer-review-container {
        margin-bottom: 16px;
    }

    .customer-review-container {
        padding: 16px 24px 16px 24px;
        border: 1px solid #eee;
    }

    .customer-review-container .card {
        border: none;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
        padding-top: 16px;
    }

    .customer-view-container > .card:first-child {
        padding-top: 0;
    }

    .customer-review-container > .card:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .review-profile-picture-container {
        width: 72px;
        height: 72px;
        border-radius: 72px;
        overflow: hidden;
        margin: 0 auto;
        margin-bottom: 7px;
    }

    .review-username-container {
        text-align: center;
    }

    .review-username {
        color: rgb(51, 51, 51);
        font-size: 12px;
    }

    .customer-review-container .card-body {
        padding: 0;
    }

    .review-rating-container i {
        margin-right: 2px;
    }

    .restaurant-review-date {
        font-size: 12px;
        color: #333;
        margin-left: 7px;
    }

    .review-heading {
        font-size: 20px;
    }

    .review-content {
        font-size: 14px;
        line-height: 20px;
        color: #333;
        word-wrap: break-word;
    }

    .review-date-of-visit-container {
        margin-top: 12px;
    }

    .review-date-of-visit {
        font-size: 14px;
        color: #333;
    }

    .things-to-do-header {
        font-size: 28px;
        font-weight: 800;
        line-height: 34px;
    }

    .things-to-do-creator {
        font-size: 16px;
        font-weight: 400;
        color: rgb(51, 51, 51);
    }

    .things-to-do-review-container i {
        margin-right: 2px;
    }

    .things-to-do-review-container span {
        color: rgb(51, 51, 51);
        font-size: 16px;
        margin-left: 4px;
        line-height: 22px;
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .things-to-do-details {
        font-size: 16px;
        color: rgb(51, 51, 51);
        margin-top: 22px;
        margin-bottom: 22px;
        line-height: 22px;
    }

    /* Pagination CSS */
    .pagination-container {
        padding: 12px 10px 0 10px;
        border-bottom: 1px solid #eee;
    }

    .page-link {
        font-weight: 700;
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        padding: 8px 16px;
        color: white;
        background-color: black;
        border: 1px solid black;
        border-radius: 0px !important;
    }

    .disabled {
        border: 1px solid #8c8c8c;
        opacity: .32;
    }

    .page-number-container .page-link {
        font-size: 14px;
        background-color: white;
        color: black;
        font-weight: 700;
        padding: 8.5px 15.5px;
        border: none;
    }

    .page-number-container .selected {
        background-color: #f0f0f0;
    }

    .image-wrapper {
        width: 100%;
        height: 100%;
    }

    .image-wrapper .img-fluid {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn {
        font-size: 16px;
        line-height: 16px;
        background-color: black;
        color: white;
        border-radius: 2px;
        font-weight: 700;
        padding: 8px 16px;
    }

    .print-container {

    display: flex;
    justify-content: center; 
    align-items: center; 
    padding: 8px 16px;
    }

</style>

<div class="main-content-container">
    <div class="restaurant-image-container content-container">
        <div class="container restaurant-parent-container">
            <div class="image-wrapper">
                <img src="<?= esc($thing_to_do['images']) ?>" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="things-to-do-content-container content-container">
        <div class="container">
            <div class="col-8">
                <div class="things-to-do-header-container">
                    <h5 class="things-to-do-header"><?= esc($thing_to_do['name']) ?></h5>
                </div>
                <div class="things-to-do-creator-container">
                    <span class="things-to-do-creator">By Bike Around Tour</span>
                </div>
                <div class="things-to-do-review-container d-flex align-items-center">
                        <?php if ($thing_to_do['rating'] <= 0): ?>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] < 1 and $thing_to_do['rating'] > 0): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] > 1 and $thing_to_do['rating'] < 2): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] > 2 and $thing_to_do['rating'] < 3): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] > 3 and $thing_to_do['rating'] < 4): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] > 4 and $thing_to_do['rating'] < 5): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm"></i>
                        <?php elseif ($thing_to_do['rating'] = 5): ?>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                            <i class="fa-solid fa-circle fa-sm checked"></i>
                        <?php endif ?>
                    <span class="restaurant-review-amount align-middle"><?= esc($num_reviews) ?> reviews</span>
                </div>
                <div class="things-to-do-details-container">
                    <p class="things-to-do-details">
                        <?= esc($thing_to_do['description']) ?>
                    </p>
                </div>
            </div>

            <div class="col-4">

            </div>
        </div>
    </div>

    <div class="restaurant-customer-review-container content-container">
        <div class="restaurant-customer-review-heading-container d-flex justify-content-between">
            <h2 class="restaurant-customer-review-heading">Reviews</h2>
            <a href="<?= base_url('things-to-do/create-review/') . $country . '/' . $thing_to_do['attraction_id'] ?>" class="btn">Write a review</a>
        </div>
        <div class="restaurant-customer-review-container">
            <div class="customer-review-container">

                <?php if (!empty($reviews) && is_array($reviews)): ?>
                    <?php foreach($reviews as $review): ?>
                    <div class="card">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="review-profile-picture-container">
                                    <img src="<?= base_url('images/tripadvisor-icon.png') ?>" class="img-fluid">
                                </div>
                                <div class="review-username-container">
                                    <span class="review-username"><?= esc($review['username']) ?></span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="review-rating-container d-flex align-items-center">
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <?php 
                                            $review_date = strtotime($review['created_on']);
                                            $review_date_view = date("j F Y", $review_date);
                                        ?>
                                        <span class="restaurant-review-date align-middle">Reviewed <?= esc($review_date_view) ?></span>
                                    </div>
                                    <div class="review-heading-container">
                                        <span class="review-heading"><?= esc($review['review_title']) ?></span>
                                    </div>
                                    <div class="review-content-container">
                                        <span class="review-content">
                                            <?= esc($review['review']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <?= $pager ?>

                    <?php else: ?>
                        <div class="container text-center">
                            <p class="restaurant-customer-review-heading">No Reviews</p>
                        </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<div class="print-container">
    <a class="btn mt-3" onclick="window.print()">Print</a>
</div>