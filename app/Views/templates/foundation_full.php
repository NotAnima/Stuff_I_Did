<style>
    .pagination-container {
        padding: 12px 10px 0 10px;
        border-bottom: 1px solid #eee;
    }

    .page-link {
        font-weight: 700;
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        padding: 8px 16px;
        color: white;
        background-color: black;
        border: 1px solid black;
        border-radius: 0px !important;
    }

    .pagination li {
        background-color: transparent;
    }

    .disabled {
        border: 1px solid #8c8c8c;
        opacity: .32;
    }

    .page-number-container .page-link {
        font-size: 14px;
        background-color: white;
        color: black;
        font-weight: 700;
        padding: 8.5px 15.5px;
        border: none;
    }

    .page-number-container .selected {
        background-color: #f0f0f0;
    }
</style>

<?php $pager->setSurroundCount(2) ?>

<nav class="pagination-container">
    <ul class="pagination justify-content-between">
        <?php if ($pager->getPreviousPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>">Previous</a>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link disabled" href="#">Previous</a>
            </li>
        <?php endif ?>
        <div class="page-number-container d-flex align-items-center">
            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item">
                    <a class="page-link <?= $link['active'] ? 'selected' : '' ?>" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
                </li>
            <?php endforeach ?>
        </div>
        <?php if ($pager->hasNextPage()): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getNextPage() ?>">Next</a>
        </li>
        <?php else: ?>
        <li class="page-item">
            <a class="page-link disabled" href="#">Next</a>
        </li>
        <?php endif ?>
    </ul>
</nav>