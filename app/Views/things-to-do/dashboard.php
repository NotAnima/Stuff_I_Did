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
            <h2 class="main-header">Attraction Dashboard</h2>
        </div>
    </div>

    <div class="dashboard-container container">
        <a class="btn" href="<?= base_url('things-to-do/dashboard/create-thing-to-do') ?>">Create Attraction</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Attraction Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($things_to_do) && is_array($things_to_do)): ?>
                    <?php $counter = 1 ?>
                    <?php foreach($things_to_do as $thing_to_do): ?>
                    <tr>
                        <th scope="row"><?= esc($counter) ?></th>
                        <td><?= $thing_to_do['name'] ?></td>
                        <td><?= $thing_to_do['country_name'] ?></td>
                        <td>
                            <a class="btn" href="<?= base_url('things-to-do/view/') . $thing_to_do['country_name'] . '/' . $thing_to_do['attraction_id'] ?>">View</a>
                            <a class="btn" href="<?= base_url('things-to-do/dashboard/edit-thing-to-do/') . $thing_to_do['attraction_id'] ?>">Edit</a>
                            <a class="btn" href="<?= base_url('things-to-do/dashboard/delete-thing-to-do/') . $thing_to_do['attraction_id'] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php $counter += 1 ?>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>