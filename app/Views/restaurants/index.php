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

    .main-header {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
        text-align: center;
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
            <h2 class="main-header">Find your perfect restaurant</h2>
        </div>
        <div class="search-container">
            <form action="<?= base_url('restaurants') ?>" method="post">
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
                                <i class="fa-solid fa-mug-saucer"></i>
                            </div>
                            <h5 class="card-title">Find the best places to eat</h5>
                            <p class="card-text">
                                4.3 million restaurants - everything from street food to fine dining
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="icon-container">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h5 class="card-title">See the latest reviews</h5>
                            <p class="card-text">
                                Millions of restaurant reviews and photos from our global travel community
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="icon-container">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <h5 class="card-title">Reserve a table</h5>
                            <p class="card-text">
                                Make online bookings at restaurants worldwide
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="restaurants-container content-container">
        <div class="restaurants-heading-container">
            <h2 class="category-header">Trending restaurants</h2>
        </div>
        <div class="container">
            <div class="row">
                <?php if (!empty($trending_restaurants) && is_array($trending_restaurants)): ?>
                    <?php foreach ($trending_restaurants as $trending_restaurant): ?>
                    <div class="col-3">
                        <div class="card">
                                <?php if (isset($trending_restaurant['images']) && !empty($trending_restaurant['images'])): ?>
                                    <img src="<?= $trending_restaurant['images'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= base_url('images/travel-guides-2.jpeg') ?>" class="img-fluid">
                                <?php endif ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($trending_restaurant['name']) ?></h5>
                                <div class="card-review d-flex align-items-center">
                                    <?php if ($trending_restaurant['rating'] <= 0): ?>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] < 1 and $trending_restaurant['rating'] > 0): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] > 1 and $trending_restaurant['rating'] < 2): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] > 2 and $trending_restaurant['rating'] < 3): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] > 3 and $trending_restaurant['rating'] < 4): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] > 4 and $trending_restaurant['rating'] < 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($trending_restaurant['rating'] = 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <?php endif ?>
                                    <span class="card-review-amount align-middle"><?= esc($trending_restaurant['rating_count']) ?> Reviews</span>
                                </div>
                                <p class="card-text"><?= esc($trending_restaurant['city']) ?></p>
                                <a class="stretched-link" href="<?= base_url('restaurants/view/') . $trending_restaurant['country_name'] . '/' . $trending_restaurant['eatery_id'] ?>"></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="restaurants-container content-container">
        <div class="restaurants-heading-container">
            <h2 class="category-header">Chinese restaurants</h2>
        </div>
        <div class="container">
            <div class="row">
                <?php if (!empty($chinese_restaurants) && is_array($chinese_restaurants)): ?>
                    <?php foreach ($chinese_restaurants as $chinese_restaurant): ?>
                    <div class="col-3">
                        <div class="card">
                                <?php if (isset($chinese_restaurant['images']) && !empty($chinese_restaurant['images'])): ?>
                                    <img src="<?= $chinese_restaurant['images'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= base_url('images/travel-guides-2.jpeg') ?>" class="img-fluid">
                                <?php endif ?>                            
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($chinese_restaurant['name']) ?></h5>
                                <div class="card-review d-flex align-items-center">
                                    <?php if ($chinese_restaurant['rating'] <= 0): ?>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] < 1 and $chinese_restaurant['rating'] > 0): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] > 1 and $chinese_restaurant['rating'] < 2): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] > 2 and $chinese_restaurant['rating'] < 3): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] > 3 and $chinese_restaurant['rating'] < 4): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] > 4 and $chinese_restaurant['rating'] < 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($chinese_restaurant['rating'] = 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <?php endif ?>
                                    <span class="card-review-amount align-middle"><?= esc($chinese_restaurant['rating_count']) ?> Reviews</span>
                                </div>
                                <p class="card-text"><?= esc($chinese_restaurant['city']) ?></p>
                                <a class="stretched-link" href="<?= base_url('restaurants/view/') . $chinese_restaurant['country_name'] . '/' . $chinese_restaurant['eatery_id'] ?>"></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="restaurants-container content-container">
        <div class="restaurants-heading-container">
            <h2 class="category-header">Italian restaurants</h2>
        </div>
        <div class="container">
            <div class="row">
                <?php if (!empty($italian_restaurants) && is_array($italian_restaurants)): ?>
                    <?php foreach ($italian_restaurants as $italian_restaurant): ?>
                    <div class="col-3">
                        <div class="card">
                            <?php if (isset($italian_restaurant['images']) && !empty($italian_restaurant['images'])): ?>
                                    <img src="<?= $italian_restaurant['images'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= base_url('images/travel-guides-2.jpeg') ?>" class="img-fluid">
                                <?php endif ?> 
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($italian_restaurant['name']) ?></h5>
                                <div class="card-review d-flex align-items-center">
                                    <?php if ($italian_restaurant['rating'] <= 0): ?>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] < 1 and $italian_restaurant['rating'] > 0): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] > 1 and $italian_restaurant['rating'] < 2): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] > 2 and $italian_restaurant['rating'] < 3): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] > 3 and $italian_restaurant['rating'] < 4): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] > 4 and $italian_restaurant['rating'] < 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($italian_restaurant['rating'] = 5): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                    <?php endif ?>
                                    <span class="card-review-amount align-middle"><?= esc($italian_restaurant['rating_count']) ?> Reviews</span>
                                </div>
                                <p class="card-text"><?= esc($italian_restaurant['city']) ?></p>
                                <a class="stretched-link" href="<?= base_url('restaurants/view/') . $italian_restaurant['country_name'] . '/' . $italian_restaurant['eatery_id'] ?>"></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>