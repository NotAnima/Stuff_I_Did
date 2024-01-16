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

    form {
        width: 410px;
        margin: 0 auto;
    }

    .subheading-container {
        margin-bottom: 24px;
    }

    .subheading {
        font-size: 28px;
        font-weight: 700;
        line-height: 33.6px;
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
    
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Plan a new trip</h2>
        </div>
        <div class="form-container">
            <form action="<?= base_url('guides/trip-date') ?>" method="post">
                <div class="mb-3">
                    <label for="country" class="form-label">Where to ?</label>
                    <input type="text" class="form-control" name="country">
                </div>
                <div class="mb-3">
                    <label for="start-date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start-date">
                </div>
                <div class="mb-3">
                    <label for="end-date" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end-date">
                </div>
                <button type="submit" class="btn btn-primary">Start planning</button>
            </form>
        </div>
    </div>
</div>