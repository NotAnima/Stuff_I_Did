<style>

    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    /* Travel Guides Header CSS */
    .travel-guide-main-content-container {
        margin-bottom: 20px;
    }

    .heading-container {
        padding: 35px 0 35px 0;
        text-align: center;
    }

    .travel-guides-heading {
        font-size: 34px;
        color: rgb(44, 44, 44);
        font-weight: 700;
    }

    .travel-date {
        color: rgb(108, 117, 125);
        font-size: 14px;
        font-weight: 700;
        line-height: 21px;
    }

    .huge-form-label {
        font-size: 24px;
        color: rgb(33, 37, 41);
        font-weight: 700;
        line-height: 28.8px;
    }

    .travel-guide-section-header {
        margin-bottom: 20px;
        margin-top: 20px;
        font-size: 36px;
        font-weight: 700;
        line-height: 36px;
    }

    .section-heading-container {
        margin-top: 20px;
    }

    .section-heading {
        font-size: 36px;
        color: rgb(33, 37, 41);
        font-weight: 700;
        line-height: 36px;
    }

    .section-sub-heading-container {
        margin-top: 20px;
    }

    /* Places Details CSS */
    .places-details-container {
        margin-bottom: 20px;
    }

    .places-details-container .card {
        border: none;
        background-color: rgb(243, 244, 245);
        padding: 20px;
    }

    .places-details-container .card-title {
        font-size: 16px;
        color: rgb(73, 80, 87);
        font-weight: 700;
        line-height: 24px;
    }

    .places-details-container .card-text {
        font-size: 16px;
        color: rgb(73, 80, 87);
        font-weight: 400;
        line-height: 22.72px;
    }

    .places-details-container .img-wrapper-container {
        width: 200px;
        height: 120px;
        margin: 0 auto;
    }

    .places-details-container img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        line-height: 18px;
    }

    input {
        padding: 4px 4px 4px 8px;
        font-size: 14px;
        font-weight: 400;
        height: 48px;
        box-sizing: border-box;
        border-radius: 4px;
        border: 2px solid rgb(224, 224, 224);
    }
    
    input::placeholder {
        font-size: 14px;
        color: rgb(224, 224, 224);
    }

    .btn {
        width: 100%;
        background-color: rgb(0, 0, 0);
        font-size: 16px;
        color: rgb(255, 255, 255);
        font-weight: 700;
    }

</style>


<div class="main-content-container">
    <div class="travel-guide-main-content-container content-container">
        <div class="heading-container">
            <h2 class="travel-guides-heading"><?= $guide['title'] ?></h2>
        </div>

        <form action="<?= base_url('/guides/update/') . $id ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="title" class="form-label huge-form-label">Title</label>
                <textarea class="form-control" name="title" placeholder="Title for this trip guide"><?php if(isset($guide['title'])): ?><?= $guide['title'] ?><?php endif ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label huge-form-label">Guide Cover Image</label>
                <textarea class="form-control" name="image" placeholder="Image URL"><?php if(isset($guide['image'])): ?><?= $guide['image'] ?><?php endif ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label huge-form-label">Description</label>
                <textarea class="form-control" name="description" placeholder="Write or paste anything here: how to get around, tips and tricks"><?php if(isset($guide['description'])): ?><?= $guide['description'] ?><?php endif ?></textarea>
            </div>

            <div class="section-heading-container">
                <h5 class="section-heading">Itinerary</h5>
            </div>

            <?php foreach($guide['days'] as $key => $day): ?>
                <div class="travel-guide-section-header-container">
                    <h5 class="travel-guide-section-header">Day <?= $key ?></h5>
                </div>
                <?php foreach($day['attractions'] as $attraction): ?>
                <div class="places-details-container" details-id="<?= $key ?>">
                    <div class="card mt-2" id="<?= $attraction['title']. '-' . $key ?>">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <input type="text" name="title-<?= $key ?>[]" style="display:none;" value="<?= $attraction['title'] ?>">
                                <input type="text" name="notes-<?= $key ?>[]" style="display:none;" value="<?= $attraction['details'] ?>">
                                <h5 class="card-title"><?= $attraction['title'] ?></h5>
                                <p class="card-text">
                                <?= $attraction['details'] ?>
                                </p>
                            </div>

                            <div class="col-4">
                                <div class="img-wrapper-container">
                                    <img src="<?= base_url('images/top-experiences-1.jpeg') ?>" class="img-fluid">
                                </div>
                            </div>
                            <input class="btn mt-2" style="width:150px;" value="Delete" type="button" onclick="RemoveCard('<?= $attraction['title']. '-' . $key ?>')">
                        </div>
                    </div>
                </div>
                <?php endforeach ?>

                <div class="place-container">
                    <div class="mb-3">
                        <label for="place" class="form-label">Add a place</label>
                        <input type="text" class="form-control" place-no="<?= $key ?>">
                    </div>
                    <div class="mb-3">
                        <label for="place-notes" class="form-label">Notes</label>
                        <textarea class="form-control" placeholder="Add Notes" notes-no="<?= $key ?>"></textarea>
                    </div>
                    <button type="button" class="btn add-place" id="add-place" button-no="<?= $key ?>">Add Place</button>
                </div>
            <?php endforeach ?>

            <button type="submit" id="add-place" class="mt-4 btn add-place">Update Trip</button>
        </form>
    </div>
</div>

<script>


    const add_places = document.getElementsByClassName("add-place");

    for (var i = 0; i < add_places.length; i ++) {
        var add_place = add_places[i];
        add_place.addEventListener('click', function addPlace(event) {
            console.log(this.getAttribute('button-no'));
            const id = this.getAttribute('button-no');
            const place = document.querySelector(`[place-no="${id}"]`).value;
            const notes = document.querySelector(`[notes-no="${id}"]`).value;

            const details_container = document.querySelector(`[details-id="${id}"]`);
            console.log(place);
            console.log(notes);

            if (place != '') {
                const card =
                `
                <div class="card mt-2" id="${place}-${id}">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <input type="text" name="title-${id}[]" style="display:none;" value="${place}">
                            <input type="text" name="notes-${id}[]" style="display:none;" value="${notes}">
                            <h5 class="card-title">${place}</h5>
                            <p class="card-text">
                            ${notes}
                            </p>
                        </div>

                        <div class="col-4">
                            <div class="img-wrapper-container">
                                <img src="<?= base_url('images/top-experiences-1.jpeg') ?>" class="img-fluid">
                            </div>
                        </div>
                        <input class="btn mt-2" style="width:150px;" value="Delete" type="button" onclick="RemoveCard('${place}-${id}')">
                    </div>
                </div>
                `;

                details_container.innerHTML += card;
                document.querySelector(`[place-no="${id}"]`).value = "";
                document.querySelector(`[notes-no="${id}"]`).value = "";
            } 


        });
    }
    add_place.addEventListener('click', function addPlace(event) {


    });

    function RemoveCard(index) {
        var card_remove = document.getElementById(index);
        card_remove.remove();
    }

</script>

