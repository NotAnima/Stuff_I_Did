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

    <div class="content-container signup-container">
        <div class="heading-container">
            <h2 class="travel-guides-heading">Sign Up</h2>
        </div>
        <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert alert-warning">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-warning">
                <?= validation_list_errors() ?>
            </div>
        <?php endif ?>
        <form action="<?= base_url('signup') ?>" method="post">
            <?= csrf_field() ?>
            <div class="subheading-container">
                <h2 class="subheading">Join to unlock the best of Tripadvisor</h2>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

                <div class="col">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm-password" placeholder="Confirm Password">
                </div>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>
    </div>
</div>