<style>
    .content-container {
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
        width: calc(1136px + 24px * 2);
    }

    .footer-background-color {
        background-color: #faf1ed;
    }

    footer {
        padding: 32px 0 32px 0;
    }

    .footer-brand {
        font-size: 12px;
        color: rgb(51, 51, 51);
        margin-left: 4px;
    }

    footer .nav-link {
        color: rgb(51, 51, 51);
        font-size: 16px;
        font-weight: 700;
        line-height: 19px;
        text-decoration-color: rgb(51, 51, 51);
        text-decoration-line: underline;
        text-decoration-style: solid;
    }

    footer .nav-link:hover {
        color: darkgrey;
    }

    .footer-copyright-container {
        max-width: 752px;
    }

    .footer-copyright {
        color: rgb(51, 51, 51);
        font-size: 12px;
        line-height: 4px;
    }


</style>

<div class="footer-background-color noprint">
    <footer class="content-container">
        <div class="footer-content-container d-flex flex-wrap justify-content-between align-items-center">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/"><img src="<?= base_url('images/tripadvisor-icon.png') ?>" width="40" height="40"></a>
                <span class="footer-brand">&copy; 2023 AdviceTrip LLC All rights reserved.</span>
            </div>
            <ul class="nav col-md-6 justify-content-end">
                <li class="nav-item">
                    <a href="<?= base_url('home') ?>" class="nav-link px-2">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('hotels') ?>" class="nav-link px-2">Hotels</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('things-to-do') ?>" class="nav-link px-2">Things to Do</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('restaurants') ?>" class="nav-link px-2">Restaurants</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('guides') ?>" class="nav-link px-2">Travel Guides</a>
                </li>
            </ul>
        </div>
        <div class="footer-copyright-container">
            <span class="footer-copyright">This is the version of our website addressed to speakers of English in Singapore. If you are a resident of another country or region, please select the appropriate version of Tripadvisor for your country or region in the drop-down menu.</span>
        </div>
    </footer>
</div>

</body>
</html>