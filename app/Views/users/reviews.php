<style>

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    /* Travel Guides Header CSS */
    .review-content-container {
        margin-bottom: 20px;
    }

    .heading-container {
        padding: 35px 0 15px 0;
        text-align: center;
    }

    .heading {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
    }

    .subheading-container {
        max-width: 670px;
        margin: 0 auto;
        text-align: center;
    }

    .subheading {
        font-size: 24px;
        line-height: 29px;
        color: rgb(117, 117, 117);
    }

    .image-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .review-heading-container {
        margin-bottom: 24px;
    }

    .review-heading {
        font-size: 24px;
        font-weight: 700;
        line-height: 29px;
    }

    .user-container {
        margin-bottom: 20px;
    }

    .user-img-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 100%;
    }

    .user-details-container p {
        margin-bottom: 0;
        margin-left: 5px;
    }

    .user-details-container .user {
        font-size: 14px;
        line-height: 18px;
        padding-bottom: 2px;
    }

    .user-details-container .user-date {
        color: #757575;
        font-size: 12px;
        line-height: 16px;
    }

    .review-rating-container {
        margin-bottom: 12px;
    }

    .review-rating-container i {
        margin-right: 2px;
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .review-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
        line-height: 22px;
    }

    .review-text {
        color: rgb(51, 51, 51);
        font-size: 16px;
        line-height: 24px;
    }

    .location-container {
        max-width: 290px;
    }

    .card .img-wrapper {
        height: 66px;
        width: 66px;
    }

    .card img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .content-wrapper {
        margin-left: 12px;
        max-width: 70%;
    }

    .content-wrapper .card-title {
        font-size: 12px;
        font-weight: 700;
        line-height: 16px;
        margin-bottom: 2px;
    }

    .subreview-rating-container {
        margin-top: 10px;
        margin-bottom: 8px;
    }

    .subreview-rating-container i {
        margin-right: 1px;
    }

    .num-reviews {
        margin-left: 5px;
    }

    .content-wrapper .card-text {
        color: rgb(117, 117, 117);
        font-size: 12px;
        line-height: 16px;
    }


    .why-review-img-wrapper {
        height: 500px;
        width: 375px;
        position: relative;
    }

    .why-review-content-container {
        position: absolute;
        bottom: 0;
        left: 0;
        color: white;
        padding: 32px 48px 32px 24px;
        max-width: 303px;
    }

    .why-review-header {
        font-size: 40px;
        font-weight: 800;
        line-height: 40px;
        letter-spacing: 0.8px;
    }

    .why-review {
        font-size: 20px;
        font-weight: 400;
        line-height: 24px;
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

    .restaurant-customer-review-heading-container {
        margin-bottom: 10px;
    }

    .restaurant-customer-review-heading {
        font-size: 28px;
        font-weight: 700;
        line-height: 32px;
    }

</style>

<div class="main-content-container">
    <div class="content-container review-content-container">
        <div class="heading-container">
            <h2 class="heading">Write a review, make someone's trip</h2>
        </div>
        <div class="subheading-container">
            <h3 class="subheading">Stories like yours are what helps travellers have better trips. Share your experience and help out a fellow traveller!</h3>
        </div>
        <div class="image-container d-flex align-items-center justify-content-center">
            <div class="review-image-wrapper">
                <img src="<?= base_url('images/reviews-1.png') ?>" class="img-fluid">
            </div>
            <div class="review-image-wrapper ms-4 me-4">
                <img src="<?= base_url('images/reviews-2.png') ?>" class="img-fluid">
            </div>
            <div class="review-image-wrapper">
                <img src="<?= base_url('images/reviews-3.png') ?>" class="img-fluid">
            </div>
        </div>

        <div>
            <div class="row">
                <div class="col-8">
                    <?php if(! empty($reviews) && is_array($reviews)): ?>
                    <div class="review-heading-container">
                        <h5 class="review-heading">Your reviews</h5>
                    </div>

                    <?php foreach($reviews as $review): ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="user-container d-flex align-items-center">
                                <div class="user-img-wrapper">
                                    <img src="<?= base_url('images/tripadvisor-icon.png') ?>" class="img-fluid">
                                </div>
                                <div class="user-details-container">
                                    <p class="user">You wrote a review</p>
                                    <?php 
                                        $review_date = strtotime($review['created_on']);
                                        $review_date_view = date("j F Y", $review_date);
                                    ?>
                                    <p class="user-date"><?= esc($review_date_view) ?></p>
                                </div>
                            </div>
                            <div class="review-rating-container d-flex align-items-center">
                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                <i class="fa-solid fa-circle fa-sm checked"></i>
                                <i class="fa-solid fa-circle fa-sm checked"></i>
                            </div>
                            <h5 class="review-title"><?= esc($review['review_title']) ?></h5>
                            <p class="review-text">
                                <?= esc($review['review']) ?>
                            </p>
                            <?php if (! empty($review['visit_date']) && $review['visit_date'] != null): ?>
                                <?php 
                                    $visit_date = strtotime($review['visit_date']);
                                    $visit_date_view = date("j F Y", $visit_date);
                                ?>
                                <p class="date-of-visit"><strong>Date of experience: </strong><?= esc($visit_date_view) ?></p>
                            <?php endif ?>
                            <div class="location-container card">
                                <div class="d-flex align-items-center">
                                    <div class="img-wrapper">
                                        <img src="<?= base_url('images/top-experiences-1.jpeg') ?>" class="img-fluid">
                                    </div>


                                    <div class="content-wrapper">
                                        <h5 class="card-title" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"><?= esc($review['name']) ?></h5>
                                        <!-- <div class="subreview-rating-container fa-xs d-flex align-items-center">
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <i class="fa-solid fa-circle fa-sm checked"></i>
                                            <span class="num-reviews">27 reviews</span>
                                        </div> -->
                                        <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"><i class="fa-solid fa-location-dot fa-xs"></i> <?= esc($review['street_address']) ?></p>
                                    </div>
                                </div>
                                <?php if(! empty($review['eatery_id']) && $review['eatery_id'] != null): ?>
                                    <a class="stretched-link" href="<?= base_url('restaurants/') . $review['country_name'] . '/' . $review['eatery_id'] ?>"></a>
                                </div>
                                <a class="btn mt-4" href="<?= base_url('restaurants/delete-review/') . $review['eatery_review'] ?>">Delete Review</a>
                                <?php endif ?>
                                <?php if(! empty($review['hotel_id']) && $review['hotel_id'] != null): ?>
                                    <a class="stretched-link" href="<?= base_url('hotels/') . $review['country_name'] . '/' . $review['hotel_id'] ?>"></a>
                                </div>
                                <a class="btn mt-4" href="<?= base_url('hotels/delete-review/') . $review['hotel_review'] ?>">Delete Review</a>
                                <?php endif ?>
                                <?php if(! empty($review['attraction_id']) && $review['attraction_id'] != null): ?>
                                    <a class="stretched-link" href="<?= base_url('things-to-do/view/') . $review['country_name'] . '/' . $review['attraction_id'] ?>"></a>
                                </div>
                                <a class="btn mt-4" href="<?= base_url('things-to-do/delete-review/') . $review['attraction_review'] ?>">Delete Review</a>
                                <?php endif ?>
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

                <div class="col-4">
                    <div class="why-review-img-wrapper">
                        <img src="<?= base_url('images/why_review_image-1.png') ?>" class="img-fluid">
                        <div class="why-review-content-container">
                            <h5 class="why-review-header">Why review?</h5>
                            <span class="why-review">See how your reviews help millions of travellers and business owners</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>