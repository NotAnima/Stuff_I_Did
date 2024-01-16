<style>
    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
    }

    .nav-link svg {
        margin-right: 5px;
    }

    .nav-link {
        font-size: 16px;
        font-weight: 700;
    }

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
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
    .fa-circle {
        color: #eee;
    }

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
    }

    .restaurant-rank-container .restaurant-rank {
        font-size: 14px;
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
    }

    .restaurant-website {
        border-bottom: 1px dotted #e0e0e0;
        text-decoration: none;
        color: black;
        font-size: 14px;
        line-height: 18px;
    }

    /* Hotel Price Image CSS */
    .hotel-price-image-container .col-4 {
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }

    .hotel-price-image-container .col-4 .card {
        border: none;
    }

    .hotel-price-image-container .card-title {
        text-align: center;
        font-size: 17px;
        color: rgb(51, 51, 51);
    }

    .deal-image-wrapper {
        width: 50%;
    }

    .deal-image {
        max-height: 44px;
    }

    .deal {
        font-size: 24px;
        font-weight: 700;
        text-align: right;
    }

    .view-deal {
        font-weight: 700;
        background-color: rgb(242, 178, 3);
        color: black;
        border-radius: 20px;
        font-size: 16px;
        width: 100%;
        margin-top: 15px;
    }

    .hotel-image-container {
        min-height: 250px;
        max-height: 450px;
    }

    .hotel-image-container .row {
        height: 100%;
        width: auto;
    }

    .hotel-image-container .col-12 {
        height: 100%;
    }

    .hotel-image-container .image-container {
        height: 50%;
    }

    .hotel-price-image-container img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    /* Hotel About CSS */
    .hotel-about-container {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .hotel-about-container .card {
        width: 65%;
        padding: 24px;
    }

    .hotel-about-container .card-title {
        font-size: 28px;
        font-weight: 700;
        line-height: 30px;
    }

    .hotel-about-container .card-body {
        border-top: 1px solid #eee;
        padding: 0;
    }

    .hotel-about-container .card-body .col-6 {
        padding: 12px;
    }

    .hotel-about-review-number {
        margin-right: 5px;
    }

    .hotel-about-container .hotel-about-review-number span {
        font-size: 48px;
        font-weight: 700;
        line-height: 22px;
    }

    .hotel-about-rating {
        font-size: 16px;
        font-weight: 700;
        line-height: 19.2px;
    }

    .hotel-review-amount {
        color: rgb(51, 51, 51);
        font-size: 14px;
        margin-left: 5px;
        border-bottom: 1px dotted rgb(224, 224, 224);
    }

    .hotel-about-ranking-container {
        margin-bottom: 12px;
    }

    .hotel-about-ranking {
        font-size: 14px;
        color: rgb(51, 51, 51);
    }

    .about-container {
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .hotel-about {
        font-size: 16px;
        color: rgb(51, 51, 51);
        line-height: 22px;
    }

    /* Hotel Amenities CSS */
    .hotel-amenities-header-container {
        margin-bottom: 16px;
    }

    .hotel-amenities {
        font-size: 16px;
        font-weight: 700;
        padding-top: 20px;
    }

    .amenities-text {
        font-size: 14px;
        color: rgb(51, 51, 51);
        line-height: 18px;
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
                <h2 class="restaurant-name"><?= esc($hotel['name']) ?></h2>
            </div>
            <div class="restaurant-settings-container">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg>
                                Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-regular fa-heart"></i>
                                Save</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-share"></i>
                                Share</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="restaurant-details-container d-flex align-items-center">
            <div class="restaurant-review-container">
                <?php if ($avg_review['average'] <= 0): ?>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] <= 1 and $avg_review['average'] > 0): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] > 1 and $avg_review['average'] <= 2): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] > 2 and $avg_review['average'] <= 3): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] > 3 and $avg_review['average'] <= 4): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] > 4 and $avg_review['average'] < 5): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm"></i>
                <?php elseif ($avg_review['average'] = 5): ?>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                    <i class="fa-solid fa-circle fa-sm checked"></i>
                <?php endif ?>
                <span class="restaurant-review-amount align-middle"><?= esc($num_reviews) ?> reviews</span>
            </div>
            <!-- <div class="restaurant-rank-container">
                <span class="restaurant-rank"><strong>#52</strong> of 366 hotels in Singapore</span>
            </div> -->
        </div>
        <div class="restaurant-contact-container d-flex align-items-center">
            <div class="restaurant-location-container">
                <span class="restaurant-location"><i class="fa-solid fa-location-dot"></i> <?= esc($hotel['street_address']) . ', ' . esc($hotel['city']) . ' ' . esc($hotel['postal_code']) ?></span>
            </div>
            <?php if (!empty(esc($hotel['contact_no']))): ?>
            <div class="restaurant-number-container">
                <span class="restaurant-number"><i class="fa-solid fa-phone"></i> <?= esc($hotel['contact_no']) ?></span>
            </div>
            <?php endif ?>

            <?php if (!empty(esc($hotel['website']))): ?>
            <div class="restaurant-website-container">
                <a class="restaurant-website" href="<?= esc($hotel['website']) ?>"><i class="fa-solid fa-laptop"></i> Website</a>
            </div>
            <?php endif ?>
        </div>
    </div>

    <div class="hotel-price-image-container content-container">
        <div class="container">
            <div class="row g-4">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Lock in the lowest price from these sites</h5>
                            <div class="deal-container d-flex justify-content-between align-items-center">
                                <div class="deal-image-wrapper">
                                    <img src="<?= base_url('images/booking-com.png') ?>" class="img-fluid deal-image">
                                </div>
                                <span class="deal">S$<?= esc($hotel['price']) ?></span>
                            </div>
                            <button class="btn view-deal">View deal</button>
                        </div>
                    </div>
                </div>

                <div class="col-8 hotel-image-container">
                    <div class="row g-0">
                        <div class="col-12">
                            <?php if(!empty($hotel['images'])): ?>
                            <img src="<?= $hotel['images'] ?>" class="img-fluid">
                            <?php else: ?>
                            <img src="<?= base_url('images/marina-bay-1.jpg') ?>" class="img-fluid">
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hotel-about-container content-container">
        <div class="card">
            <h5 class="card-title">About</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="hotel-about-review-container d-flex align-items-end">
                            <div class="hotel-about-review-number">
                                <span><?= esc($avg_review['average']) ?></span>
                            </div>
                            <div class="hotel-circle-container">
                                <div class="hotel-about-rating-container">
                                    <span class="hotel-about-rating">Excellent</span>
                                </div>
                                <?php if ($avg_review['average'] <= 0): ?>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] <= 1 and $avg_review['average'] > 0): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] > 1 and $avg_review['average'] <= 2): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] > 2 and $avg_review['average'] <= 3): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] > 3 and $avg_review['average'] <= 4): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] > 4 and $avg_review['average'] < 5): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm"></i>
                                <?php elseif ($avg_review['average'] = 5): ?>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <i class="fa-solid fa-circle fa-sm checked"></i>
                                <?php endif ?>
                            </div>
                            <span class="hotel-review-amount"><?= esc($num_reviews) ?> reviews</span>
                        </div>
                        <!-- <div class="hotel-about-ranking-container">
                            <span class="hotel-about-ranking">#52 of 366 hotels in Singapore</span>
                        </div> -->
                        
                        <div class="about-container">
                            <p class="hotel-about">
                                <?= esc($hotel['description']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-6">
                        <?php if (! empty($hotel_amenities) && is_array($hotel_amenities)): ?>
                        <div class="hotel-amenities-container">
                            <div class="hotel-amenities-header-container">
                                <h5 class="hotel-amenities">Property Amenities</h5>
                            </div>
                            <div class="amenities-container">
                                <div class="row">
                                <?php foreach($hotel_amenities as $amenity): ?>
                                    <div class="amenities col-6">
                                        <div class="row align-items-start">
                                            <div class="col-1">
                                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                            </div>
                                            <div class="col-10">
                                                <span class="amenities-text align-top"><?= esc($amenity['amenity_name']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if (! empty($hotel_room_features) && is_array($hotel_room_features)): ?>
                        <div class="hotel-amenities-container">
                            <div class="hotel-amenities-header-container">
                                <h5 class="hotel-amenities">Room Features</h5>
                            </div>
                            <div class="amenities-container">
                                <div class="row">
                                <?php foreach($hotel_room_features as $room_feature): ?>
                                    <div class="amenities col-6">
                                        <div class="row align-items-start">
                                            <div class="col-1">
                                                <i class="fa-solid fa-hotel"></i>
                                            </div>
                                            <div class="col-10">
                                                <span class="amenities-text align-top"><?= esc($room_feature['room_features_name']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if (! empty($hotel_room_types) && is_array($hotel_room_types)): ?>
                        <div class="hotel-amenities-container">
                            <div class="hotel-amenities-header-container">
                                <h5 class="hotel-amenities">Room Types</h5>
                            </div>
                            <div class="amenities-container">
                                <div class="row">
                                <?php foreach($hotel_room_types as $room_types): ?>
                                    <div class="amenities col-6">
                                        <div class="row align-items-start">
                                            <div class="col-1">
                                                <i class="fa-solid fa-bed"></i>
                                            </div>
                                            <div class="col-10">
                                                <span class="amenities-text align-top"><?= esc($room_types['room_types_name']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="restaurant-customer-review-container content-container">
        <div class="restaurant-customer-review-heading-container d-flex justify-content-between">
            <h2 class="restaurant-customer-review-heading">Reviews</h2>
            <a href="<?= base_url('hotels/create-review/') . $country . '/' . $hotel['hotel_id'] ?>" class="btn">Write a review</a>
        </div>
        <div class="restaurant-customer-review-container">
            <div class="customer-review-container">
                <?php if(!empty($reviews) && is_array($reviews)): ?>
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
                                        <?php if ($review['rating'] < 0): ?>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($review['rating'] < 1 and $review['rating'] > 0): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($review['rating'] > 1 and $review['rating'] < 2): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($review['rating'] > 2 and $review['rating'] < 3): ?>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                            <i class="fa-solid fa-circle fa-sm"></i>
                                        <?php elseif ($review['rating'] > 3 and $review['rating'] < 4): ?>
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