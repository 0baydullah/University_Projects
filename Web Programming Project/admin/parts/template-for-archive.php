<?php
    include_once 'parts/header.php';
 ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vertical-menu">
                <?php include_once 'parts/sidebar.php' ?>
            </div>
            <div class="col-10">
               
                   
                <h1>Results</h1>
                <a href="results.php"><button type="button" class="btn btn-secondary">New Event</button></a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Team A</th>
                            <th scope="col">Team B</th>
                            <th scope="col">Time</th>
                            <th scope="col">Venue</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
                  
               
            </div>
        </div>
    </div>
</body>