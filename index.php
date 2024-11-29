<?php include("includes/header.php"); 
        include "countfunctions.php"; ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 display-4">Dashboard</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6"><h3> </h3></div>
                </div>
                <div class="container-fluid px-4">
                    <div class="row g-3 ny-2">
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        <?php
                                            countServers();
                                        ?>
                                    </h3>
                                    <p class="fs-8">Servers</p>
                                </div>
                                <div>
                                    <i class="bi bi-server fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                    <?php
                                            countCPU();
                                        ?>
                                    </h3>
                                    <p class="fs-8">CPU-PC</p>
                                </div>
                                <div>
                                    <i class="bi bi-pc fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        2987
                                    </h3>
                                    <p class="fs-8">Monitor</p>
                                </div>
                                <div>
                                    <i class="bi bi-display-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        786
                                    </h3>
                                    <p class="fs-8">Printer</p>
                                </div>
                                <div>
                                    <i class="bi bi-printer-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        310
                                    </h3>
                                    <p class="fs-8">Router</p>
                                </div>
                                <div>
                                    <i class="bi bi-router-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        351
                                    </h3>
                                    <p class="fs-8">Switch</p>
                                </div>
                                <div>
                                    <i class="bi bi-ethernet fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        528
                                    </h3>
                                    <p class="fs-8">Webcam</p>
                                </div>
                                <div>
                                    <i class="bi bi-webcam-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        498
                                    </h3>
                                    <p class="fs-8">Sigpad</p>
                                </div>
                                <div>
                                    <i class="bi bi-clipboard-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        3145
                                    </h3>
                                    <p class="fs-8">Keyboard</p>
                                </div>
                                <div>
                                    <i class="bi bi-keyboard-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        3122
                                    </h3>
                                    <p class="fs-8">Mouse</p>
                                </div>
                                <div>
                                    <i class="bi bi-mouse2-fill fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        341
                                    </h3>
                                    <p class="fs-8">UPS-Server</p>
                                </div>
                                <div>
                                    <i class="bi bi-battery-charging fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 border-2">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        3124
                                    </h3>
                                    <p class="fs-8">UPS-PC</p>
                                </div>
                                <div>
                                    <i class="bi bi-battery-charging fs-1 primary-text rounded-full secondary-bg p-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
<?php include("includes/footer.php"); ?>
