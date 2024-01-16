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

    /* Travel Guide Image CSS */
    .travel-guide-image-container {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .travel-guide-image-container .img-wrapper {
        height: 450px;
        width: auto;
    }

    .travel-guide-image-container .img-wrapper img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    /* Travel Guide Content CSS */
    .travel-guide-content-container {
        margin-bottom: 15px;
    }

    .travel-guide-content-container .travel-guide-header {
        font-size: 36px;
        font-weight: 700;
    }

    .travel-guide-content-container .travel-guide-creator-container {
        max-width: 500px;
        margin-bottom: 15px;
    }

    .travel-guide-creator-container .card {
        border: none;
    }

    .travel-guide-content-container .travel-guide-creator-image-wrapper-container {
        height: 36px;
        width: 36px;
    }

    .travel-guide-creator-container .card-body {
        padding: 0 0 0 5px;
    }

    .travel-guide-creator-container .card-title {
        font-size: 18px;
        line-height: 27px;
        margin-bottom: 4px;
    }

    .travel-guide-creator-container .card-text {
        font-size: 14px;
        line-height: 21px;
    }

    .travel-guide-sub-header {
        color: rgb(108, 117, 125);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
    }

    .travel-guide-section-header-container {
        margin-bottom: 10px;
    }

    .travel-guide-section-header {
        margin-left: 5px;
        margin-bottom: 0px;
        font-size: 36px;
        font-weight: 700;
        line-height: 36px;
    }

    .travel-guide-section-container .card {
        border: none;
        border-bottom: 1px dotted #e0e0e0;
    }

    .travel-guide-section-container .col-10 {
        margin-top: 10px;
    }

    .card-title-container .card-title {
        margin-bottom: 0px;
        font-size: 18px;
        font-weight: 700;
    }

    .tags-container {
        margin-bottom: 10px;
    }

    .tags-container .tag {
        padding: 4px 8px;
        background-color: rgb(233, 236, 239);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .travel-guide-section-container .card-text {
        font-size: 16px;
        text-align: left;
    }

    .travel-guide-section-img-wrapper {
        width: 200px;
        height: 100px;
        margin: auto;
    }

    .travel-guide-section-img-wrapper img {
        height: 100%;
        width: 100%;
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
    <div class="travel-guide-image-container content-container">
        <div class="img-wrapper">
            <?php if(isset($guide['image'])): ?>
                <img src= "<?= $guide['image'] ?>" class="img-fluid guide-image">
            <?php else: ?>    
                <img src="<?= base_url('images/travel-guides-1.jpeg') ?>" class="img-fluid">
            <?php endif ?>
        </div>
    </div>

    <div class="travel-guide-content-container content-container">
        <div class="travel-guide-header-container">
      <h2 class="travel-guide-header"><?= esc($guide['title']) ?></h2>
        </div>
        <div class="travel-guide-creator-container">
            <div class="card">
                <div class="row align-items-center">
                    <div class="col-1">
                        <div class="travel-guide-creator-image-wrapper-container">
                            <img src="<?= base_url('images/tripadvisor-icon.png') ?>" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($guide['user']) ?></h5>
                            <p class="card-text"><?php if(isset($guide['date'])){echo esc($guide['date']);}else{echo "9th Jun 2023";}?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert alert-warning mt-2">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif ?>
            <?php if($user === $guide['user']): ?>
                <a class="btn mt-4" style="background-color: #33b249; color: black;" href="<?= base_url('guides/update/') . esc($guide['_id']) ?>">Edit Guide</a>
                <a class="btn mt-4" style="background-color: #bd2222;" href="<?= base_url('guides/delete/') . esc($guide['_id']) ?>">Delete Guide</a>
            <?php endif ?>
            <form action="<?= base_url('guides/view/' . $id) ?>" method="post">
                <button type="submit" class="btn mt-3">Send Trip to Email</button>
            </form>
        </div>
        <div class="travel-guide-sub-header-container">
            <h3 class="travel-guide-sub-header">
              <?= esc($guide['description']); ?>
            </h3>
        </div>
        <?php foreach ($guide['days'] as $day): ?>
        <div class="travel-guide-section-container">
            <div class="travel-guide-section-header-container">
                <h5 class="travel-guide-section-header">Day <?= esc($day['number']) ?></h5>
                <?php $counter=1; ?>
            </div>
            <?php foreach ($day['attractions'] as $attraction): ?>
              <div class="card">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">
                                    <div class="fa-2x">
                                        <span class="fa-layers fa-fw">
                                            <i class="fa-solid fa-location-pin"></i>
                                            <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-8 down-3"><?= esc($counter) ?></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-10">
                                  <h5 class="card-title"><?= esc($attraction['title']) ?></h5>
                                    <p class="card-text">
                                      <?= esc($attraction['details']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <div class="travel-guide-section-img-wrapper">
                            <img src="https://live.staticflickr.com/2919/14408389822_5ae12fe015_b.jpg" class="img-fluid">
                        </div>
                    </div>
                </div>
                <?php $counter+=1 ?>
              <?php endforeach ?>

            <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="print-container">
    <a class="btn mt-3" onclick="window.print()">Print</a>
</div>



