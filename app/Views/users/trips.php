<style>

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

     /* Travel Guides Header CSS */
    .travel-guides-header-container {
    padding: 35px 0 35px 0;
    text-align: center;
    }

    .travel-guides-heading {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
    }

    .search-bar {
        width: 40%;
        height: 42px;
        padding-left: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
    }

    /* Travel Guides CSS */
    .travel-guides-container {
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .travel-guides-container .card {
        border: none;
    }

    .travel-guides-container .card-image-wrapper {
        height: 170px;
        width: 255px;
    }

    .travel-guides-container .guide-image {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .travel-guides-container .card-title {
        font-size: 18px;
        line-height: 27px;
    }

    .travel-guides-container .card-text {
        color: rgb(33, 37, 41);
        font-size: 16px;
        text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .user-wrapper {
        height: 26px;
        width: 26px;
    }

    .user {
        margin-left: 6px;
        font-size: 16px;
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

    /* Travel Guides Header CSS */
    .review-content-container {
        margin-bottom: 20px;
    }

    .heading-container {
        padding: 35px 0 15px 0;
        text-align: center;
    }

    .subheading {
        font-size: 24px;
        line-height: 29px;
        color: rgb(117, 117, 117);
        text-align: center;
    }

    .img-wrapper {
        height: 136px;
        width: 100%;
    }

    .img-wrapper img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .card-title {
        font-size: 16px;
        line-height: 20px;
        font-weight: 700;
    }

    .card-text {
        color: rgb(117, 117, 117);
        font-size: 12px;
        line-height: 18px;
        text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .user {
        font-size: 12px;
        line-height: 18px;
    }

</style>

<div class="main-content-container">
    <div class="travel-guides-header-container content-container">
            <div class="heading-container">
                <h2 class="travel-guides-heading">Your Trip Guides</h2>
            </div>
        <div class="travel-guides-search-container">
            <form action="<?= base_url('guides') ?>" method="post">
                <input type="text" name="name" class="form-text search-bar" placeholder="Search for a guide">

                <input type="hidden" name="submit">
            </form>
        </div>
            <a class="btn mt-3" href="<?= base_url('guides/trip-date') ?>">Create Travel Guide</a>
        </div>
        <?php if (! empty($guides) && is_array($guides)):?>
            <div class="travel-guides-container content-container">
                <div class="row">
                    <?php foreach($guides as $guide): ?>
                    <div class="col-4 mb-2">
                        <div class="card">
                            <div class="img-wrapper">
                                <?php if(isset($guide['image'])): ?>
                                <img src= "<?= $guide['image'] ?>" class="img-fluid guide-image">
                                <?php else: ?>    
                                <img src= "<?= base_url('images/top-experiences-1.jpeg') ?>" class="img-fluid guide-image">
                                <?php endif ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($guide['title']) ?></h5>
                                <p class="card-text">
                                    <?= esc($guide['description']) ?>
                                </p>
                                <span class="user">By <strong><?= esc($guide['user']) ?></strong></span>
                                <a class="stretched-link" href="<?= base_url('guides/view/') . esc($guide['_id']) ?>"></a>
                            </div>
                        </div>
                        <div>
                            <a class="btn mt-4" style="background-color: #33b249; color: black;" href="<?= base_url('guides/update/') . esc($guide['_id']) ?>">Edit Guide</a>
                            <a class="btn mt-4" style="background-color: #bd2222;" href="<?= base_url('guides/delete/') . esc($guide['_id']) ?>">Delete Guide</a>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <?= $pager ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>