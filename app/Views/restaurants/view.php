<style>
    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    /* Main Header Container CSS */
    .main-header-container {
        padding: 35px 0 35px 0;
    }

    .header-container {
        margin-bottom: 8px;
    }

    .main-header {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
        text-align: center;
    }

    .restaurant-name {
        font-size: 28px;
        line-height: 32px;
        font-weight: 700;
        margin-bottom: 0;
    }

    .main-header-container .nav-link {
        font-size: 16px;
        line-height: 20px;
        color: rgb(51, 51, 51);
        font-weight: normal;
        border-right: 1px solid #e0e0e0;
        padding: 0;
    }

    .main-header-container .navbar-nav > .nav-item:last-child .nav-link {
        border-right: none;
    }

    /* Restaurant Details CSS */
    .checked {
        color: rgb(0, 170, 108);
    }

    .restaurant-review-container {
        border-right: 1px solid #e0e0e0;
        padding: 2px 10px 2px 0;
    }

    .restaurant-details-container .restaurant-review-amount {
        font-weight: 700;
        font-size: 14px;
        line-height: 18px;
        margin-left: 3px;
    }

    .restaurant-rank-container {
        padding: 2px 10px;
        border-right: 1px solid #e0e0e0;
    }

    .restaurant-rank-container .restaurant-rank {
        font-size: 14px;
        line-height: 18px;
    }

    .restaurant-type-container {
        padding: 2px 10px;
    }

    .restaurant-type {
        font-size: 14px;
        color: rgb(51, 51, 51);
        line-height: 18px;
    }

    /* Restaurant Contact CSS */
    .restaurant-contact-container span {
        font-size: 14px;
        line-height: 18px;
    }

    .restaurant-location-container {
        padding: 2px 10px 2px 0;
        border-right: 1px solid #e0e0e0;
    }

    .restaurant-number-container {
        padding: 2px 10px;
        border-right: 1px solid #e0e0e0;
    }

    .restaurant-website-container {
        padding: 2px 10px;
        border-right: 1px solid #e0e0e0;
    }

    .restaurant-website {
        border-bottom: 1px dotted #e0e0e0;
        text-decoration: none;
        color: black;
        font-size: 14px;
        line-height: 18px;
    }

    .restaurant-menu-container {
        padding: 2px 10px;
        border-right: 1px solid #e0e0e0;
    }

    .restaurant-menu {
        border-bottom: 1px dotted #e0e0e0;
        text-decoration: none;
        color: black;
        font-size: 14px;
        line-height: 18px;
    }

    .restaurant-opening-hours-container {
        padding: 2px 10px;
        border-right: 1px solid #e0e0e0;
    }

    /* Restaurant Image CSS */
    .restaurant-image-container .restaurant-parent-container {
        height: 340px;
        padding: 0;
    }

    .restaurant-image-container .row {
        height: 100%;
        width: auto;
    }

    .restaurant-image-container .col-12 {
        height: 100%;
    }

    .restaurant-image-container .col-12 img {
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

    /* Restaurant Information CSS */
    .restaurant-information-container {
        margin-top: 20px;
        margin-bottom: 30px;
    }

    .restaurant-information-container .container {
        padding: 0;
    }

    .restaurant-information-container .col-4 .restaurant-information-background-container {
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        height: 100%;
    }
    
    .restaurant-information-container .card {
        border: none;
    }

    .restaurant-information-container .card-title {
        font-size: 18px;
        line-height: 22px;
        padding-bottom: 16px;
        font-weight: 700;
        margin-bottom: 0;
    }

    .restaurant-information-review-container {
        margin-bottom: 12px;
    }

    .restaurant-information-review-container .review-amount {
        font-size: 24px;
        font-weight: 700;
        vertical-align: middle;
        margin-right: 4px;
    }

    .restaurant-information-review-container i {
        margin-right: 1px;
    }

    .restaurant-information-review-container .review-count {
        font-size: 14px;
        font-weight: 700;
        margin-left: 7px;
    }

    .restaurant-information-container .restaurant-ranking {
        font-size: 14px;
        line-height: 22px;
    }

    .restaurant-information-award-container {
        margin-top: 14px;
    }

    .restaurant-information-award-container span {
        font-size: 14px;
        font-weight: 700;
    }

    .hr {
        border-color: #e0e0e0;
        border-width: 0 0 2px;
        margin: 16px 0;
        border-style: solid;
    }

    .restaurant-about-heading-container {
        margin-bottom: 7px;
    }

    .restaurant-about-heading {
        font-size: 12px;
        line-height: 16px;
        text-transform: uppercase;
        font-weight: 700;
    }

    .restaurant-about {
        font-size: 14px;
        line-height: 18px;
    }

    .restaurant-details-container .restaurant-about {
        display: block;
        padding: 12px 0 24px;
    }

    .restaurant-location-image-container {
        max-height: 151px;
        margin-bottom: 24px;
    }

    .restaurant-location-contact-container {
        margin-top: 12px;
    }

    .restaurant-about-link {
        font-size: 14px;
        color: #333;
        line-height: 18px;
        text-decoration: none;
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
    <div class="main-header-container content-container">
        <div class="header-container d-flex align-items-center justify-content-between">
            <div class="restaurant-name-container">
                <h2 class="restaurant-name"><?= esc($restaurant['name']) ?></h2>
            </div>

        </div>
        <div class="restaurant-details-container d-flex align-items-center">
            <div class="restaurant-review-container">
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
                <span class="restaurant-review-amount align-middle"><?= esc($num_reviews) ?> reviews</span>
            </div>
            <div class="restaurant-rank-container">
                <span class="restaurant-rank"><strong>#459</strong> of 10,201 Restaurants in Singapore</span>
            </div>
            <div class="restaurant-type-container" style="max-width: 200px">
                <span class="restaurant-type" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">$$$$, <?= ' ' . $restaurant['cuisines'] ?></span>
            </div>
        </div>
        <div class="restaurant-contact-container d-flex align-items-center">
            <div class="restaurant-location-container">
                <span class="restaurant-location"><i class="fa-solid fa-location-dot"></i> <?= esc($restaurant['street_address']) . ', ' . esc($restaurant['city']) . ' ' . esc($restaurant['postal_code']) ?></span>
            </div>
            <?php if(!empty($restaurant['contact_no'])): ?>
            <div class="restaurant-number-container">
                <span class="restaurant-number"><i class="fa-solid fa-phone"></i> <?= esc($restaurant['contact_no']) ?></span>
            </div>
            <?php endif ?>
            <?php if(!empty($restaurant['website'])): ?>
            <div class="restaurant-website-container">
                <a class="restaurant-website" href="<?= esc($restaurant['website']) ?>"><i class="fa-solid fa-laptop"></i> Website</a>
            </div>
            <?php endif ?>
            <?php if(!empty($restaurant['menu'])): ?>
            <div class="restaurant-menu-container">
                <a class="restaurant-menu" href="<?= esc($restaurant['menu']) ?>"><i class="fa-solid fa-utensils"></i> Menu</a>
            </div>
            <?php endif ?>
            <div class="restaurant-opening-hours-container">
                <span class="restaurant-opening-hours"><i class="fa-solid fa-clock"></i> <strong>Open now:</strong> 12:00 PM - 2:30 PM 6:00 PM - 10:00 PM</span>
            </div>
        </div>
    </div>

    <div class="restaurant-image-container content-container">
        <div class="container restaurant-parent-container">
            <div class="row g-1">
                <div class="col-12">
                    <?php if(!empty($restaurant['images'])): ?>
                    <img src="<?= $restaurant['images'] ?>" class="img-fluid">
                    <?php else: ?>
                    <img src="<?= base_url('images/top-restaurants-1.jpeg') ?>" class="img-fluid">
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <div class="restaurant-information-container content-container">
        <div class="container">
            <div class="row g-4">
                <div class="col-4">
                    <div class="restaurant-information-background-container">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ratings and reviews</h5>
                                <div class="restaurant-information-review-container d-flex align-items-center">
                                    <span class="review-amount"><?= esc($restaurant['rating']) ?></span>
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
                                    <span class="review-count"><?= esc($num_reviews) ?> reviews</span>
                                </div>
                                <div class="restaurant-information-ranking-container">
                                    <span class="restaurant-ranking"><strong>#110</strong> of 534 European in Singapore</span>
                                    <br>
                                    <span class="restaurant-ranking"><strong>#459</strong> of 10,201 Restaurants in Singapore</span>
                                </div>
                                <div class="restaurant-information-award-container">
                                    <span>Travellers' Choice Best of the Best 2022</span>
                                </div>
                                <hr class="hr">
                                <div class="restaurant-about-container">
                                    <div class="restaurant-about-heading-container">
                                        <span class="restaurant-about-heading">ABOUT</span>
                                    </div>
                                    <span class="restaurant-about"><?= esc($restaurant['about']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 restaurant-details-container">
                    <div class="restaurant-information-background-container">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Details</h5>
                                <?php if(!empty($restaurant['price_range'])): ?>
                                <div class="restaurant-price-container">
                                    <div class="restaurant-price-heading-container">
                                        <span class="restaurant-about-heading">PRICE RANGE</span>
                                    </div>
                                    <span class="restaurant-about"><?= esc($restaurant['price_range']) ?></span>
                                </div>
                                <?php endif ?>
                                <div class="restaurant-cuisine-container">
                                    <div class="restaurant-cuisine-heading-container">
                                        <span class="restaurant-about-heading">CUISINES</span>
                                    </div>
                                    <span class="restaurant-about"><?= esc($restaurant['cuisines']) ?></span>
                                </div>
                                <div class="restaurant-special-diets-container">
                                    <div class="restaurant-special-diets-heading-container">
                                        <span class="restaurant-about-heading">SPECIAL DIETS</span>
                                    </div>
                                    <span class="restaurant-about">Gluten Free Options</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="restaurant-information-background-container">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Location and Contact</h5>
                                <div class="restaurant-location-image-container">
                                    <img src="<?= base_url('images/location-and-contact-1.jpeg') ?>" class="img-fluid">
                                </div>
                                <div class="restaurant-location-contact-container d-flex align-items-center">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span class="restaurant-about ms-2"><?= esc($restaurant['street_address']) . ', ' . esc($restaurant['city']) . ' ' . esc($restaurant['postal_code']) ?></span>
                                </div>
                                <div class="restaurant-location-contact-container d-flex align-items-center">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span class="restaurant-about ms-2">Outram<br><strong>0.4 km</strong> from Chinatown</span>
                                </div>
                                <?php if(!empty($restaurant['website'])): ?>
                                <div class="restaurant-location-contact-container d-flex align-items-center">
                                    <i class="fa-solid fa-laptop fa-xs"></i>
                                    <a href="<?= esc($restaurant['website']) ?>" class="restaurant-about-link ms-2">Website</a>     
                                </div>
                                <?php endif ?>
                                <!-- <div class="restaurant-location-contact-container d-flex align-items-center">
                                    <i class="fa-solid fa-envelope fa-xs"></i>
                                    <a href="#" class="restaurant-about-link ms-2">Email</a>     
                                </div> -->
                                <?php if(!empty($restaurant['contact_no'])): ?>
                                <div class="restaurant-location-contact-container d-flex align-items-center">
                                    <i class="fa-solid fa-phone fa-xs"></i>
                                    <span class="restaurant-about-link ms-2"><?= esc($restaurant['contact_no']) ?></span>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="restaurant-customer-review-container content-container">
        <div class="restaurant-customer-review-heading-container d-flex justify-content-between">
            <h2 class="restaurant-customer-review-heading">Reviews</h2>
            <a href="<?= base_url('restaurants/create-review/') . $country . '/' . $restaurant['eatery_id'] ?>" class="btn">Write a review</a>
        </div>
        <div class="restaurant-customer-review-container">
            <div class="customer-review-container">
                <?php if (!empty($reviews) && is_array($reviews)) :?>
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
                                            <?php if ($review['rating'] <= 0): ?>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] <= 1 and $review['rating'] > 0): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] > 1 and $review['rating'] <= 2): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] > 2 and $review['rating'] <= 3): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] > 3 and $review['rating'] <= 4): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] > 4 and $review['rating'] < 5): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm"></i>
                                            <?php elseif ($review['rating'] = 5): ?>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <?php endif ?>
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
                                        <?php 
                                            $visit_date = strtotime($review['visit_date']);
                                            $visit_date_view = date("j F Y", $visit_date);
                                        ?>
                                        <div class="review-date-of-visit-container">
                                            <span class="review-date-of-visit"><strong>Date of visit:</strong> <?= esc($visit_date_view) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
                <?= $pager ?>
            </div>
        </div>
    </div>
</div>
<div class="print-container">
    <a class="btn mt-3" onclick="window.print()">Print</a>
</div>