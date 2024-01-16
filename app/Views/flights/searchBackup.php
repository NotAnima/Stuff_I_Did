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

    .card {
        width: 820px;
    }

    .time-container {
        font-weight: 400;
        font-size: 18px;
        line-height: 20px;
    }

    .location-container {
        color: rgb(117, 117, 117);
        font-size: 14px;
        line-height: 16px;
        margin-top: 4px;
    }

    .hours-container span {
        font-size: 14px;
    }

    .stops-container span {
        color: rgb(117, 117, 117);
        font-size: 13px;
        line-height: 15px;
        margin-top: 4px;
    }

    .btn {
        border-radius: 12px;
        background-color: rgb(242, 178, 3);
        font-size: 14px;
        font-weight: 700;
        line-height: 18px;
        border: 1px solid rgb(242, 178, 3);
        color: black;
    }

    .price {
        font-size: 27px;
        font-weight: 700;
        line-height: 27px;
    }

</style>

<div class="main-content-container">
    <div class="main-header-container content-container">
        <div class="main-header-heading-container">
            <h2 class="main-header">Flights</h2>
        </div>
    </div>

    <div class="flights-content-container content-container mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <div class="time-location-container">
                                            <div class="time-container">
                                                <span>9:30 pm - 7:50 pm</span>
                                            </div>
                                            <div class="location-container">
                                                <span>LHR - SIN, Air India</span>
                                            </div>
                                        </div>
                                        <div class="hours-stops-container text-end">
                                            <div class="hours-container">
                                                <span>27h 20m</span>
                                            </div>
                                            <div class="stops-container">
                                                <span>1 stop, BOM</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        <div class="time-location-container">
                                            <div class="time-container">
                                                <span>12:15 am - 11:30 pm</span>
                                            </div>
                                            <div class="location-container">
                                                <span>SIN - LHR, Air India</span>
                                            </div>
                                        </div>
                                        <div class="hours-stops-container text-end">
                                            <div class="hours-container">
                                                <span>18h 15m</span>
                                            </div>
                                            <div class="stops-container">
                                                <span>1 stop, DEL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="price-container text-end">
                                    <p class="price">S$1,396</p>
                                    <a class="btn btn-primary" href="#">View Deal ></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <div class="time-location-container">
                                            <div class="time-container">
                                                <span>9:30 pm - 7:50 pm</span>
                                            </div>
                                            <div class="location-container">
                                                <span>LHR - SIN, Air India</span>
                                            </div>
                                        </div>
                                        <div class="hours-stops-container text-end">
                                            <div class="hours-container">
                                                <span>27h 20m</span>
                                            </div>
                                            <div class="stops-container">
                                                <span>1 stop, BOM</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        <div class="time-location-container">
                                            <div class="time-container">
                                                <span>12:15 am - 11:30 pm</span>
                                            </div>
                                            <div class="location-container">
                                                <span>SIN - LHR, Air India</span>
                                            </div>
                                        </div>
                                        <div class="hours-stops-container text-end">
                                            <div class="hours-container">
                                                <span>18h 15m</span>
                                            </div>
                                            <div class="stops-container">
                                                <span>1 stop, DEL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="price-container text-end">
                                    <p class="price">S$1,396</p>
                                    <a class="btn btn-primary" href="#">View Deal ></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>