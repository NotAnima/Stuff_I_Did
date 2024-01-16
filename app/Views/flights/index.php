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

    .btn {
        font-size: 16px;
        line-height: 16px;
        background-color: black;
        color: white;
        border-radius: 2px;
        font-weight: 700;
        padding: 8px 16px;
    }

</style>

<div class="main-content-container">
<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Find your flight</h2>
        </div>
        <div class="search-container">
        <?php if (isset($errors)) : ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $field => $error) : ?>
                    <p><?= $error ?></p>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
            <form action="<?= base_url('flight-cost') ?>" method="post">
                <div class="row text-start mb-3">
                    <div class="col-6">
                        <label class="form-label">From Country:</label>
                        <select class="form-select" name="startLocation">
                            <option>Singapore (SIN)</option>
                            <option>Glasgow (GLA)</option>
                            <option>Milan (MIL)</option>
                            <option>Taipei (TPE)</option>
                        </select>       
                    </div>
                    <div class="col-6">
                        <label class="form-label">To Country:</label>
                        <select class="form-select" name="endLocation">
                            <option>Singapore (SIN)</option>
                            <option>Glasgow (GLA)</option>
                            <option>Milan (MIL)</option>
                            <option>Taipei (TPE)</option>
                        </select>
                    </div>
                </div>

                <div class="row text-start mb-3">
                    <div class="col-6">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="departureDate">
                    </div>

                    <div class="col-6">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="returnDate">
                    </div>
                </div>

                <div class="row text-start mb-3">
                    <div class="col-3">
                        <label class="form-label">Select Class</label>
                        <select class="form-select" name="travelClass">
                            <option value="economy">Economy</option>
                            <option value="premium_economy">Premium Economy</option>
                            <option value="business">Business</option>
                            <option value="first_class">First Class</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Number of Adults</label>
                        <input type="number" class="form-control" name="adults">
                    </div>

                    <div class="col-3">
                        <label class="form-label">Number of Children</label>
                        <input type="number" class="form-control" name="children">
                    </div>                    
                </div>
                
                <button type="submit" name="submit" class="btn mt-3">Search</button>
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
                            <h5 class="card-title">See the latest reviews</h5>
                            <p class="card-text">
                                Read airline reviews from our global traveller community
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
                            <h5 class="card-title">The lowest flight prices</h5>
                            <p class="card-text">
                                Find the best flight deals from hundreds of sites with just one search
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
                            <h5 class="card-title">FlyScore</h5>
                            <p class="card-text">
                                Use FlyScore to compare flights, then book the one that is right for you
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', e => {
        $('#input-datalist').autocomplete()
    }, false);
</script>