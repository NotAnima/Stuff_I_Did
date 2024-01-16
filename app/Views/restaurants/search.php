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

    /* Restaurants and Filter Content CSS */
    .restaurants-and-filter-content-container {
        background-color: #f2f2f2;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    /* Filter Content CSS */
    .filter-content-background-container {
        padding: 20px 20px 20px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        background-color: white;
    }

    .filter-header { 
        font-size: 16px;
        line-height: 20px;
        font-weight: 700;
    }

    .filter-input-container {
        margin-top: 10px;
    }

    .form-check {
        display: flex;
        align-items: center;
        vertical-align: middle;
    }

    .form-check .form-check-label {
        display: block;
        white-space: nowrap;
    }

    .form-check .form-check-input {
        width: 16px;
        height: 16px;
        border: 1px solid #000;
        border-radius: 2px;
        box-shadow: inset 0 0 2px rgba(0, 0, 0, .1);
        color: #fff;
        vertical-align: middle;
    }

    .form-check label span {
        vertical-align: middle;
        color: #333;
        font-size: 14px;
        line-height: 14px;
    }

    .form-check-input:checked {
        background-color: #000;
        content: "\e02b";
    }

    /* Restaurants Content CSS */
    .category-header {
        font-size: 24px;
        font-weight: 700;
        line-height: 28px;
    }

    .restaurants-content-container {
        padding-bottom: 25px;
    }

    .restaurants-content-container .row {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .restaurants-content-container .row::-webkit-scrollbar {
        display: none;
    }

    .restaurants-content-container .col-3-5 {
        display: inline-block;
        float: none;
        width: 28.75%;
        padding-left: 8px;
        padding-right: 8px;
    }

    .restaurants-content-container .row > .col-3-5:first-child {
        margin-left: -8px;
    }

    .restaurants-content-container .row > .col-3-5:last-child {
        margin-right: -8px;
    }
    
    .restaurants-content-container .card {
        border: none;
    }

    .restaurants-content-container img {
        height: 130px;
    }

    .restaurants-content-container .card-body {
        padding: 8px 14px 14px;
    }

    .restaurants-content-container .card-title {
        font-size: 14px;
    }

    .restaurants-content-container .card-review .checked {
        color: rgb(0, 170, 108);
    }

    .restaurants-content-container .card-review-amount {
        font-size: 12px;
        margin-left: 10px;
        color: rgb(51, 51, 51);
        font-weight: 400;
    }

    .card-text-container p {
        margin-bottom: 0;
    }

    .restaurants-content-container .card-text {
        width: 70%;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        color: rgb(51, 51, 51);
    }

    .restaurants-content-container .card-price-range {
        width: 30%;
        font-size: 12px;
        color: rgb(51, 51, 51);
        white-space: nowrap;
    }


    /* Top Restaurants CSS */
    .top-restaurants-container .col-3-5 {
        width: 28.75%;
    }

    .top-restaurants-container .col-8-5 {
        width: 71.25%;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .top-restaurants-container .card {
        margin: 8px;
    }

    .top-restaurants-container img {
        width: 268px;
        height: 100%;
        object-fit: cover;
    }

    .top-restaurants-container .card-body {
        padding: 8px 15px 0 15px;
    }

    .top-restaurants-container .card-title {
        font-size: 20px;
        font-weight: 700;
        line-height: 24px;
    }

    .top-restaurants-container .card-review-amount {
        color: #333;
        margin-left: 5px;
        font-size: 14px;
        line-height: 18px;
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .card-text-container {
        padding-bottom: 4px;
    }

    .top-restaurants-container .card-text {
        display: inline-block;
        padding-right: 8px;
        color: rgb(51, 51, 51);
        font-size: 14px;
        line-height: 18px;
    }

    .top-restaurants-container .card-price-range {
       padding: 0 8px;
       color: rgb(51, 51, 51);
       font-size: 14px;
       line-height: 18px; 
    }

    .card-customer-review-container {
        margin-top: 8px;
    }

    .card-customer-review {
        margin-bottom: 0;
        padding: 8px 0;
        color: rgb(51, 51, 51);
        font-size: 14px;
        line-height: 18px;
    }

    .reserve-button-container {
        padding: 12px 0;
    }

    .top-restaurants-container .btn {
        background-color: rgb(242, 178, 3);
        font-size: 14px;
        font-weight: 700;
        line-height: 18px;
        padding: 8px 16px;
        border-radius: 18px;
        border: 1px solid rgb(242, 178, 3);
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

    .top-restaurants-container .img-fluid {
        height: 250px;
    }

</style>


<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Restaurants in <?= esc(ucfirst($country)) ?></h2>
        </div>

        <div class="search-container">
            <form action="<?= base_url('restaurants/') . $country ?>" method="post">
                <input type="text" name="name" class="form-text search-bar" placeholder="Search for a Restaurant within the Country">

                <input type="hidden" name="submit">
            </form>
        </div>
    </div>

    <div class="restaurants-and-filter-content-container">
        <div class="container content-container">
            <div class="row">
                <div class="col-3 filter-content-container">
                </div>
                <div class="col-9">
                
                    <div class="top-restaurants-container">
                        <div class="top-restaurants-heading-container">
                            <h2 class="category-header">Top Restaurants in <?= esc(ucfirst($country)) ?></h2>
                            <span class="category-subheading"><?= $num_results ?> results returned</span>
                        </div>
                        <?php if (! empty($restaurants) && is_array($restaurants)): ?>
                            <?php foreach ($restaurants as $restaurant): ?>
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-3-5">
                                        <?php if (isset($restaurant['images']) && !empty($restaurant['images'])): ?>
                                            <img src="<?= $restaurant['images'] ?>" class="img-fluid">
                                        <?php else: ?>
                                            <img src="<?= base_url('images/top-restaurants-1.jpeg') ?>" class="img-fluid">
                                        <?php endif ?>
                                    </div>
                                    <div class="col-8-5">
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
                                                <span class="card-review-amount align-middle"><?= $restaurant['rating_count'] ?> reviews</span>  
                                            </div>
                                            <div class="card-text-container d-flex">
                                                <p class="card-text"><?= $restaurant['cuisines'] ?></p>
                                                <p class="card-price-range"><?= $restaurant['price_range'] ?></p>
                                            </div>
                                            <div class="card-customer-review-container border-top border-bottom">
                                                <p class="card-customer-review">"Similarly, the polpo with the candies cherry tomatoes is divine which brings..."</p>
                                                <p class="card-customer-review">"... sauce and hazelnuts, and the porcini and potato tortelli with param ham e..."</p>
                                            </div>
                                            <div class="reserve-button-container">
                                                <a href="<?= base_url('restaurants/view/') . strtolower($country) . '/' . $restaurant['eatery_id'] ?>" class="btn stretched-link">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <?php endforeach ?>
                        <?php else: ?>
                            <h5>No Restaurants can be found in this Country</h5>
                        <?php endif ?>
                        <?= $pager ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
