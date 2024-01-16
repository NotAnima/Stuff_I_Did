<style>
    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
    }

    .nav-link svg {
        margin-right: 5px;
    }

    #star-rating i {
        font-size: 24px;
        color: #ddd;
        cursor: pointer;
        margin-right: 4px;
    }

    #star-rating i:hover,
    #star-rating i.active {
        color: rgb(0, 170, 108);
    }

    /* Restaurant Review Container */
    .restaurant-review-container {
        margin-top: 96px;
        margin-bottom: 96px;
    }

    .restaurant-container h2 {
        font-size: 42px;
        font-weight: 800;
        line-height: 50px;
    }

    .card {
        display: inline-flex;
        padding: 16px;
    }

    .card-image-container {
        height: 213px;
        width: 213px;
    }

    .card-image-container img {
        object-fit: cover !important;
        object-position: center;
        height: 100%;
        width: 100%;
    }

    .card-body {
        margin-top: 16px;
        padding: 0;
    }

    .card-subtitle, .card-text {
        font-size: 14px;
        font-weight: 400;
        color: rgb(51, 51, 51);
    }

    .card-title {
        font-size: 18px;
        line-height: 22px;
        font-weight: 700;
    }

    .form-label {
        font-size: 24px;
        font-weight: 700;
        line-height: 29px;
        margin-bottom: 16px;
    }

    .form-select {
        min-width: 54px;
        display: block;
        border-radius: 20px;
        color: black;
        width: auto;
        text-align: center;
        font-size: 13.3px;
    }

    .col-7 textarea {
        height: clamp(127px, 131px, 450px);
        max-height: 450px;
        border-radius: 4px;
        padding: 16px;
        font-size: 16px;
        line-height: 19px;
    }

    .col-7 textarea::placeholder {
        font-size: 16px;
    }

    .col-7 .text {
        border: 2px solid #e0e0e0;
        padding: 14px;
        text-align: start;
        font-size: 14px;
        line-height: 17px;
    }

    .btn {
        background-color: black;
        color: white;
        border-radius: 28px;
        padding: 18px 24px;
        width: 100%;
    }
    
</style>

<div class="main-content-container">
    <div class="restaurant-review-container content-container">
        <div class="row">
            <div class="col-5">
                <div class="restaurant-container">
                    <h2>Tell us, how was your visit?</h2>
                </div>
                <div class="restaurant-details-container">
                    <div class="card">
                        <div class="card-image-container">
                            <?php if (!empty($restaurant['images'])): ?>
                                <img src="<?= esc($restaurant['images']) ?>" class="img-fluid">
                            <?php else: ?>
                                <img src="<?= base_url('images/top-restaurants-1.jpeg') ?>" class="img-fluid">
                            <?php endif ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; max-width: 200px;"><?= $restaurant['name'] ?></h5>
                            <h6 class="card-subtitle" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; max-width: 200px;"><?= $restaurant['street_address'] ?></h6>
                            <p class="card-text"><?= $restaurant['city'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <form action="<?= base_url('things-to-do/create-review/') . $country . '/' . $attraction_id ?>" method="post">
                    <div class="mb-5">
                        <label class="form-label">How would you rate your experience?</label>
                        <div class="star-rating" id="star-rating">
                        </div>
                        <input name="star-rating" style="display: none;" id="star-rating-value" type="number" min="1" max="5">
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Write your review</label>
                        <textarea rows="5" minlength="100" class="form-control" name="review" placeholder="This sport is great for a casual night out..."></textarea>
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Title your review</label>
                        <input type="text" placeholder="Give us the gist of your experience" name="review-title" class="form-control text">
                    </div>
                    <div>
                        <button type="submit" class="btn">Submit review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // Get the star-rating div
    var starRating = $("#star-rating");
    var setRating = document.getElementById('star-rating-value');

    // Create five star icons using Bootstrap's classes
    for (var i = 1; i <= 5; i++) {
      var star = $("<i></i>").addClass("fa-solid fa-circle fa-sm");
      star.attr("data-rating", i); // Set the data-rating attribute to represent the rating value
      star.appendTo(starRating);
    }

    // Handle the hover event on the stars
    starRating.on("mouseenter", "i", function() {
      var selectedStar = $(this).data("rating"); // Get the rating value of the selected star

      // Color all the stars before the selected star
      starRating.find("i").each(function() {
        var star = $(this);
        var rating = star.data("rating");

        if (rating <= selectedStar) {
          star.addClass("active");
        } else {
          star.removeClass("active");
        }
      });
    });

    // Handle the click event on the stars
    starRating.on("click", "i", function() {
      var rating = $(this).data("rating"); // Get the rating value from the clicked star
      setRating.value = rating;
      console.log(setRating.value);
    });
  });
</script>