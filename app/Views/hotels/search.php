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

    .nav-sub-link {
        font-size: 14px !important;
        color: black !important;
        font-weight: normal;
    }

    .active {
        border-bottom: 2px solid black;
        font-weight: 700;
    }

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    .col-3-5 {
        width: 28.75%;
    }

    .col-8-5 {
        width: 71.25%;
    }

    /* Hotel Country Header CSS */
    .hotel-country-header-container {
        text-align: center;
        padding: 35px 0 35px 0;
    }

    .hotel-country-header {
        font-size: 34px;
        font-weight: 700;
    }

    /* Hotels and Filter Content CSS */
    .hotels-and-filter-content-container {
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

    /* Hotels CSS */
    .hotels-and-filter-content-container {
        padding-bottom: 20px;
    }

    .hotels-heading-container {
        margin-bottom: 10px;
    }

    .hotels-heading {
        color: rgb(51, 51, 51);
        font-size: 16px;
        line-height: 22px;
    }

    .hotels-container .card {
        margin: 8px;
    }

    .hotels-container .card-title {
        font-size: 20px;
        font-weight: 700;
        line-height: 24px;
    }

    .hotels-container .card-body .col-4 {
        border-right: 1px solid #eee;
    }
    
    .hotels-container .price-container {
        text-align: center;
        font-size: 24px;
        line-height: 29px;
        font-weight: 700;
        margin-top: 20px;
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

    .review-container i {
        margin-right: 1px;
    }

    .fa-circle {
        color: #eee;
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .card-review-amount {
        margin-left: 6px;
        color: rgb(51, 51, 51);
        font-size: 14px;
        line-height: 17px;
    }

    .hotel-award {
        margin-top: 10px;
        font-size: 13px;
        color: rgb(51, 51, 51);
    }

    .hotel-website {
        font-size: 14px;
        color: black;
        font-weight: 700;
        line-height: 17px;
        text-decoration: none;
        margin-top: 15px;
    }

    .pagination {
        padding: 12px 10px 0 10px;
        border-bottom: 1px solid #eee;
    }

    .pagination li {
        font-size: 14px;
        background-color: white;
        color: black;
        font-weight: 700;
        padding: 8.5px 15.5px;
        border: none;
    }

    .pagination a {
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

    .pagination .active {
        background-color: #f0f0f0;
    }

    .filter-content-background-container .btn {
        background-color: black;
        color: white;
        border-radius: 28px;
        padding: 9px 12px;
        width: 100px;
        font-size: 14px;
        margin-top: 15px;
    }

    .hotels-container img {
        object-fit: cover;
        height: 190px;
        width: 100%;
    }

    .search-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .search-bar {
        width: 40%;
        height: 42px;
        padding-left: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
    }

</style>


<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="hotel-country-header-container content-container">
            <span class="hotel-country-header"><?= esc(ucfirst($country)) ?> Hotels and Places to Stay in <?= esc(ucfirst($country)) ?></span>
        </div>

        <div class="search-container">
            <form action="<?= base_url('hotels/') . $country ?>" method="post">
	              <?= csrf_field() ?>
                <input type="text" name="name" class="form-text search-bar" placeholder="Search for a Hotel within the Country">

                <input type="hidden" name="submit">
            </form>
        </div>
    </div>


    <div class="hotels-and-filter-content-container">
        <div class="container content-container">
            <div class="row">
                <div class="col-3">
                </div>

                <div class="col-9">
                    <div class="hotels-content-container">
                        <div class="hotels-heading-container">
                            <span class="hotels-heading"><strong><?= esc($num_results) ?> properties</strong> in <?= esc(ucfirst($country)) ?></span>
                        </div>
                        <div class="hotels-container">
                            <?php if(!empty($hotels) && is_array($hotels)): ?>
                                <?php foreach ($hotels as $hotel): ?>
                                <div class="card">
                                    <div class="row g-0">
                                        <div class="col-3-5">
                                            <?php if (isset($hotel['images']) && !empty($hotel['images'])): ?>
                                                <img src="<?= $hotel['images'] ?>" class="img-fluid">
                                            <?php else: ?>
                                                <img src="<?= base_url('images/top-hotels-1.jpeg') ?>" class="img-fluid">
                                            <?php endif ?>
                                        </div>
                                        <div class="col-8-5">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= esc($hotel['name']) ?></h5>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="price-container">
                                                            <span class="price">S$<?= esc($hotel['price']) ?></span>
                                                        </div>
                                                        <a href="<?= base_url('hotels/view/') . strtolower($country) . '/' . $hotel['hotel_id'] ?>" class="btn view-deal stretched-link">View deal</a>
                                                    </div>

                                                    <div class="col-8">
                                                        <div class="review-container d-flex align-items-center">
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
                                                            <?php elseif ($hotel['rating'] > 4 and $hotel['rating'] < 5): ?>
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
                                                            <span class="card-review-amount align-middle"><?= esc($hotel['rating_count']) ?> reviews</span>
                                                        </div>
                                                        <!-- <h5 class="hotel-award">#1 best Value of 839 places to stay in Singapore</h5> -->
                                                        <a href="<?= esc($hotel['website']) ?>" class="hotel-website">Visit hotel website</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            <?php else: ?>
                                <h5>No Hotels can be found in this Country</h5>
                            <?php endif ?>

                            <?= $pager ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
