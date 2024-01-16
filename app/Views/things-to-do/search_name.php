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

    .top-attractions-header {
        font-size: 28px;
        font-weight: 800;
        line-height: 34px;
    }

    .category-header {
        font-size: 24px;
        font-weight: 700;
        line-height: 29px;
    }

    .category-subheading {
        font-size: 16px;
        line-height: 22px;
    }

    .top-attractions-container .card {
        border: none;
    }

    .top-attractions-container .img-wrapper {
        height: 300px;
    }

    .top-attractions-container img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .top-attractions-container .card-body {
        padding: 0;
        padding-top: 10px;
    }

    .top-attractions-container .card-title {
        font-size: 18px;
        font-weight: 700;
        line-height: 22px;
    }

    .card-review-container {
        margin-bottom: 5px;
    }

    .card-review-container i {
        margin-right: 2px;
    }

    .card-review-container .card-review-amount {
        margin-left: 5px;
        font-size: 12px;
        font-weight: 400;
        line-height: 14px;
        color: rgb(51, 51, 51);
    }

    .checked {
        color: rgb(0, 170, 108);
    }

    .tag {
        color: rgb(51, 51, 51);
        font-size: 14px;
        line-height: 17px;
    }

    .top-attractions-container .location-container .location {
        font-size: 14px;
        color: rgb(51, 51, 51);
        line-height: 17px;
    }

    .review-creator-container {
        margin-top: 10px;
    }

    .review-creator-img-wrapper {
        width: 24px;
        height: 24px;
    }

    .review-creator {
        margin-left: 8px;
    }

    .review-container {
        margin-top: 8px;
    }

    .review {
        font-size: 14px;
        color: rgb(51, 51, 51);
        line-height: 17px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Top Experiences CSS */
    .top-experiences-heading-container {
        margin-bottom: 16px;
    }

    .top-experiences-content-container {
        margin-bottom: 15px;
    }

    .top-experiences-content-container .row::-webkit-scrollbar {
        display: none;
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
        margin-left: 10px;
        color: rgb(51, 51, 51);
        font-weight: 400;
    }

    .top-experiences-content-container .card-text {
        font-size: 16px;
        font-weight: 700;
    }

    .top-experiences-container .img-fluid {
        height: 250px;
    }

</style>

<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Things to Do in <?= esc(ucfirst($country)) ?></h2>
        </div>
        <div class="search-container">
            <form action="<?= base_url('things-to-do/') . $country ?>" method="post">
                <input type="text" name="name" class="form-text search-bar" placeholder="Search for a Attraction within the Country">

                <input type="hidden" name="submit">
            </form>
        </div>
    </div>

    <div class="top-attractions-container section-divider content-container">
        <div class="top-attractions-header-container">
            <h5 class="top-attractions-header">Search</h5>
        </div>
        <div class="container">
            <div class="row">

                <?php if(!empty($things_to_do) && is_array($things_to_do)): ?>
                    <?php foreach($things_to_do as $thing_to_do): ?>
                    <div class="col-4">
                        <div class="card">
                            <div class="img-wrapper">
                                <?php if (isset($thing_to_do['images']) && !empty($thing_to_do['images'])): ?>
                                    <img src="<?= $thing_to_do['images'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= base_url('images/travel-guides-2.jpeg') ?>" class="img-fluid">
                                <?php endif ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($counter) ?>. <?= esc($thing_to_do['name']) ?></h5>
                                <div class="card-review-container d-flex align-items-center">
                                    <?php if ($thing_to_do['rating'] <= 0): ?>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($thing_to_do['rating'] <= 1 and $thing_to_do['rating'] > 0): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($thing_to_do['rating'] > 1 and $thing_to_do['rating'] <= 2): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($thing_to_do['rating'] > 2 and $thing_to_do['rating'] <= 3): ?>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm checked"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                        <i class="fa-solid fa-circle fa-sm"></i>
                                    <?php elseif ($thing_to_do['rating'] > 3 and $thing_to_do['rating'] <= 4): ?>
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
                                    <span class="card-review-amount align-middle"><?= esc($thing_to_do['rating_count']) ?></span>
                                </div>
                                <div class="tags-container">
                                    <span class="tag"><?= esc($thing_to_do['attraction_type']) ?></span>
                                </div>
                                <div class="location-container">
                                    <span class="location"><?= esc($thing_to_do['street_address']) ?></span>
                                </div>
                                <div class="review-creator-container d-flex align-items-center">
                                    <div class="review-creator-img-wrapper">
                                        <img src="<?= base_url('images/tripadvisor-icon.png') ?>" class="img-fluid">
                                    </div>
                                    <span class="review-creator">By <strong>Oylin65</strong></span>
                                </div>
                                <div class="review-container">
                                    <p class="review">
                                        If you do nothing else in Singapore visit here!!! It is free( as is the light show in the evening) 
                                        unless you book the domes or Supertrees and is a fabulous way to spend several hours wondering around 
                                        beautifully laid out gardens. We visited 3 or 4 times during our stay at different times of the day and 
                                        saw something different each time. The supertree walkway is brilliant and the observatory walk interesting 
                                        if you want to visit the highest tree. For us the best part is the Cloud Forest dome, stayed for a couple 
                                        of hours just meandering round....loads of photos later!!! We watched the evening light show from Dragonfly 
                                        lake, quieter and could see it all
                                    </p>
                                </div>
                                <a href="<?= base_url('things-to-do/view/') . strtolower($country) . '/' . $thing_to_do['attraction_id'] ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <h5>No Attractions found for this Country</h5>
                <?php endif ?>

                <?= $pager ?>
            </div>
        </div>
    </div>
</div>