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
            <h2 class="main-header">Update Hotel</h2>
        </div>
    </div>

    <div class="form-container container mb-4">
        <?php if(isset($validation)): ?>
            <div class="alert alert-warning">
                <?= validation_list_errors() ?>
            </div>
        <?php endif ?>
        <form action="<?= base_url('hotels/dashboard/edit-hotel/') . $hotel['hotel_id'] ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Select a Country</label>
                <select class="form-select" name="country">Select Country
                    <option selected>Select a country</option>
                    <?php if (isset($countries) && is_array($countries)): ?>
                        <?php foreach($countries as $country): ?>
                        <option value="<?= esc($country['country_id']) ?>" <?php echo ($hotel['country_name'] == $country['country_name']) ? 'selected' : ''; ?>><?= ucfirst(esc($country['country_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Hotel Name</label>
                <input type="text" class="form-control" name="name" value="<?= esc($hotel['name']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control" name="street_address" value="<?= esc($hotel['street_address']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="<?= esc($hotel['city']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" value="<?= esc($hotel['postal_code']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" placeholder="This Hotel is amazing..." style="height: 100px;" name="description"><?= esc($hotel['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" name="website" value="<?= esc($hotel['website']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="<?= esc($hotel['email']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" value="<?= esc($hotel['contact_no']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" class="form-control" name="price" value="<?= esc($hotel['price']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Image Link</label>
                <input type="text" class="form-control" name="images" value="<?= esc($hotel['images']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Hotel Amenities</label>
                <select class="form-select" name="amenities[]" multiple>
                    <?php $amenities_array = (array) explode(", ", $hotel['amenities']) ?>
                    <?php if (isset($amenities) && is_array($amenities)): ?>
                        <?php foreach($amenities as $amenity): ?>
                        <option value="<?= esc($amenity['amenity_id']) ?>" <?php echo (in_array($amenity['amenity_name'], $amenities_array, false)) ? 'selected' : ''; ?> ><?= ucfirst(esc($amenity['amenity_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Hotel Room Types</label>
                <select class="form-select" name="room_types[]" multiple>
                    <?php $room_types_array = (array) explode(", ", $hotel['room_types']) ?>
                    <?php if (isset($room_types) && is_array($room_types)): ?>
                        <?php foreach($room_types as $room_type): ?>
                        <option value="<?= esc($room_type['room_types_id']) ?>" <?php echo (in_array($room_type['room_types_name'], $room_types_array, false)) ? 'selected' : ''; ?>><?= ucfirst(esc($room_type['room_types_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Hotel Room Features</label>
                <select class="form-select" name="room_features[]" multiple>
                    <?php $room_features_array = (array) explode(", ", $hotel['room_features']) ?>
                    <?php if (isset($room_features) && is_array($room_features)): ?>
                        <?php foreach($room_features as $room_features): ?>
                        <option value="<?= esc($room_features['room_features_id']) ?>" <?php echo (in_array($room_features['room_features_name'], $room_features_array, false)) ? 'selected' : ''; ?>><?= ucfirst(esc($room_features['room_features_name'])) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>