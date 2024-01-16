<style>
    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    .section-divider {
        margin-top: 64px;
    }

    /* Main Header Container CSS */
    .main-header-container {
        padding: 35px 0 35px 0;
    }

    .main-header {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
        text-align: center;
    }

    /* Features CSS */
    .features-container {
        margin-bottom: 25px;
    }

    .features-container .card {
        border: 1px solid rgb(224, 224, 224);
        border-radius: 2px;
    }

    .features-container .card-body {
        position: relative;
    }

    .icon-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        margin-top: -10px;
    }

    .icon-container i {
        background-color:rgb(0, 170, 108);
        color: white;
        padding: 10px;
        border-radius: 50%;
    }

    .features-container .card-title {
        margin-top: 15px;
        color: rgb(0, 170, 108);
        font-size: 20px;
        font-weight: 700;
    }

    .features-container .card-text {
        color: rgb(51, 51, 51);
        font-size: 16px;
        line-height: 22px;
    }

    /* Top Attractions CSS */
    .top-attractions-header-container {
        margin-bottom: 25px;
    }

    .search-container {
        text-align: center;
    }

    .search-bar {
        width: 40%;
        height: 42px;
        padding-left: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
    }

    /* Restaurants Content CSS */
    .restaurants-heading-container {
        margin-bottom: 24px;
    }

    .category-header {
        font-size: 24px;
        font-weight: 700;
        line-height: 28px;
    }

    .restaurants-container .container {
        margin-bottom: 25px;
    }

    .restaurants-container .col-3 {
        padding-left: 6px;
        padding-right: 6px;
    }

    .restaurants-container .row > .col-3:first-child {
        margin-left: -6px;
    }

    .restaurants-container .row > .col-3:last-child {
        margin-right: -6px;
    }

    .restaurants-container .card {
        border: none;
    }

    .restaurants-container .card img {
        padding-bottom: 8px;
        height: 190px;
        object-fit: cover;
    }

    .restaurants-container .card-body {
        padding: 0 !important;
    }

    .restaurants-container .card-title {
        font-size: 16px;
        line-height: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .card-review {
        margin-bottom: 4px;
    }

    .card-review i {
        margin-right: 2px;
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .card-review-amount {
        font-size: 12px;
        color: rgb(140, 140, 140);
        line-height: 16px;
        margin-left: 5px;
    }

    .card-text {
        color: rgb(140, 140, 140);
        font-size: 12px;
        line-height: 16px;
    }

</style>

<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Things to Do</h2>
        </div>
        <div class="search-container">
            <form action="<?= base_url('things-to-do') ?>" method="post">
                <input type="text" name="country" class="form-text search-bar" placeholder="Search by Country">

                <input type="hidden" name="submit">
            </form>
        </div>
    </div>
    
    <div class="features-container content-container">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="icon-container">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h5 class="card-title">Trusted Reviews and Ratings</h5>
                            <p class="card-text">
                                Know you're booking the best thanks to our helpful global traveller community
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="icon-container">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <h5 class="card-title">Free 24-hour Cancellation</h5>
                            <p class="card-text">
                                Plans changed? No problem. Change or cancel up to 24 hours before your experience.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="icon-container">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <h5 class="card-title">Low-price Guarantee</h5>
                            <p class="card-text">
                                Enjoy the best experience at the best price, every time
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="restaurants-container content-container">
        <div class="restaurants-heading-container">
            <h2 class="category-header">Trending Attractions</h2>
        </div>
        <div class="container">
            <div class="row">
                <?php foreach ($trending_attractions as $attraction): ?>
                <div class="col-3">
                    <div class="card">
                        <?php if (isset($attraction['images']) && !empty($attraction['images'])): ?>
                            <img src="<?= $attraction['images'] ?>" class="img-fluid">
                        <?php else: ?>
                            <img src="<?= base_url('images/travel-guides-2.jpeg') ?>" class="img-fluid">
                        <?php endif ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $attraction['name'] ?></h5>
                            <div class="card-review d-flex align-items-center">
                                    <?php if ($attraction['rating'] <= 0): ?>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($attraction['rating'] <= 1 and $attraction['rating'] > 0): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($attraction['rating'] > 1 and $attraction['rating'] <= 2): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($attraction['rating'] > 2 and $attraction['rating'] <= 3): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($attraction['rating'] > 3 and $attraction['rating'] <= 4): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($attraction['rating'] > 4 and $attraction['rating'] < 5): ?>
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
                                <span class="card-review-amount align-middle"><?= $attraction['rating_count'] ?> Reviews</span>
                            </div>
                            <p class="card-text"><?= $attraction['country_name'] ?></p>
                            <a class="stretched-link" href="<?= base_url('things-to-do/view/') . $attraction['country_name'] . '/' . $attraction['attraction_id'] ?>"></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            </div>
        </div>
</div>
