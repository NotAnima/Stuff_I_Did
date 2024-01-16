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
    <div class="main-header-container content-container">
        <div class="main-header-heading-container"> 
            <h2 class="main-header">Edit Restaurant</h2>
        </div>
    </div>

    <div class="form-container container mb-4">
        <?php if(isset($validation)): ?>
            <div class="alert alert-warning">
                <?= validation_list_errors() ?>
            </div>
        <?php endif ?>
        <form action="<?= base_url('restaurants/dashboard/edit-restaurant/') . $restaurant['eatery_id'] ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Select a Country</label>
                <select class="form-select" name="country">Select Country
                    <option>Select a country</option>
                    <?php if (isset($countries) && is_array($countries)): ?>
                        <?php foreach($countries as $country): ?>
                        <option value="<?= esc($country['country_id']) ?>" <?php echo ($restaurant['country_name'] == $country['country_name']) ? 'selected' : ''; ?>><?= ucfirst(esc($country['country_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Restaurant Name</label>
                <input type="text" class="form-control" name="name" value="<?= esc($restaurant['name']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control" name="street_address" value="<?= esc($restaurant['street_address']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="<?= esc($restaurant['city']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" value="<?= esc($restaurant['postal_code']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">About</label>
                <textarea class="form-control" placeholder="This Restaurant is amazing..." style="height: 100px;" name="about"><?= esc($restaurant['about']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" name="website" value="<?= esc($restaurant['website']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="<?= esc($restaurant['email']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" value="<?= esc($restaurant['contact_no']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Price Range</label>
                <input type="text" class="form-control" name="price_range" value="<?= esc($restaurant['price_range']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Menu</label>
                <input type="text" class="form-control" name="menu" value="<?= esc($restaurant['menu']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Image Link</label>
                <input type="text" class="form-control" name="images" value="<?= esc($restaurant['images']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Cuisines</label>
                <select class="form-select" name="cuisines[]" multiple>
                    <?php $cuisine_array = (array) explode(", ", $restaurant['cuisines']) ?>
                    <?php if (isset($cuisines) && is_array($cuisines)): ?>
                        <?php foreach($cuisines as $cuisine): ?>
                        <option value="<?= esc($cuisine['cuisine_id']) ?>" <?php echo (in_array($cuisine['cuisine_type'], $cuisine_array, false)) ? 'selected' : ''; ?>><?= esc($cuisine['cuisine_type']) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>