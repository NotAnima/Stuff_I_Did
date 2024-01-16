<style>
    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
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

    /* Form CSS */
    .signup-container {
        margin-bottom: 20px;
    }

    form {
        width: 410px;
        margin: 0 auto;
    }

    .subheading-container {
        margin-bottom: 24px;
        text-align:center;
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
        width: 410px;
        background-color: rgb(0, 0, 0);
        font-size: 16px;
        color: rgb(255, 255, 255);
        font-weight: 700;
    }

    .subheading {
        color: rgb(51, 51, 51);
        font-size: 16px;
        line-height: 22px;
    }

</style>


<div class="main-content-container">

    <div class="content-container signup-container">
        <div class="heading-container">
            <h2 class="travel-guides-heading">Scan QR Code</h2>
        </div>
        <div class="subheading-container">
            <p class="subheading">Please scan the QR Code below using your Google Authenticator App</p>
        </div>
        <div class="container d-flex justify-content-center">
            <div class="img-wrapper">
                <?= $inline_url ?>
            </div>
        </div>
        <div class="container d-flex justify-content-center">
            <a href="<?= base_url() ?>" class="btn">Back to Home</a>
        </div>
    </div>
</div>