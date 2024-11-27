<?php include("includes/header.php"); 
        include "countfunctions.php"; ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 display-4">Dashboard</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6"><h3>This is a homepage.</h3></div>
                </div>
                <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-3 mb-4 mt-2">
                                <div class="card card-body p-3" style="width: 18rem;">
                                    <p class="text-sm mb-0 text-capitalizatize font-weight-bold">Servers
                                        <h5 class="font-weight-bolder mb-0">
                                        <?php
                                            countServers();
                                        ?>
                                        </h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card card-body p-3" style="width: 18rem;">
                                    <p class="text-sm mb-0 text-capitalizatize font-weight-bold">CPU-PC
                                        <h5 class="font-weight-bolder mb-0">
                                        <?php
                                            countCPU();
                                        ?>
                                        </h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card card-body p-3" style="width: 18rem;">
                                    <p class="text-sm mb-0 text-capitalizatize font-weight-bold">Printers
                                        <h3 class="font-weight-bolder mb-0">
                                            1234
                                        </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
<?php include("includes/footer.php"); ?>
