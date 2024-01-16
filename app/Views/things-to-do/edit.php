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
            <h2 class="main-header">Update Thing To Do</h2>
        </div>
    </div>

    <div class="form-container container mb-4">
        <?php if(isset($validation)): ?>
            <div class="alert alert-warning">
                <?= validation_list_errors() ?>
            </div>
        <?php endif ?>
        <form action="<?= base_url('things-to-do/dashboard/edit-thing-to-do/') . $thing_to_do['attraction_id'] ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Select a Country</label>
                <select class="form-select" name="country">Select Country
                    <option selected>Select a country</option>
                    <?php if (isset($countries) && is_array($countries)): ?>
                        <?php foreach($countries as $country): ?>
                        <option value="<?= esc($country['country_id']) ?>" <?php echo ($thing_to_do['country_name'] == $country['country_name']) ? 'selected' : ''; ?>><?= ucfirst(esc($country['country_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= esc($thing_to_do['name']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control" name="street_address" value="<?= esc($thing_to_do['street_address']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="<?= esc($thing_to_do['city']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" value="<?= esc($thing_to_do['postal_code']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" placeholder="This Attraction is amazing..." style="height: 100px;" name="description"><?= esc($thing_to_do['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" name="website" value="<?= esc($thing_to_do['website']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="<?= esc($thing_to_do['email']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" value="<?= esc($thing_to_do['contact_no']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" class="form-control" name="price" value="<?= esc($thing_to_do['price']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Image Link</label>
                <input type="text" class="form-control" name="images" value="<?= esc($thing_to_do['images']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Things to Do Types</label>
                <select class="form-select" name="attraction_type[]" multiple>
                    <?php $attraction_type_array = (array) explode(", ", $thing_to_do['attraction_type']) ?>
                    <?php if (isset($attraction_types) && is_array($attraction_types)): ?>
                        <?php foreach($attraction_types as $attraction_type): ?>
                        <option value="<?= esc($attraction_type['attraction_type_id']) ?>" <?php echo (in_array($attraction_type['attraction_type_name'], $attraction_type_array, false)) ? 'selected' : ''; ?>><?= ucfirst(esc($attraction_type['attraction_type_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>