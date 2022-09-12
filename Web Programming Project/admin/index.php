<?php 
    include_once 'parts/header.php';
?>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vertical-menu">
                <?php include_once 'parts/sidebar.php' ?>
            </div>
            <div class="col-10 flex align-center justify-center">
                <h1>Hi <?php echo $_SESSION['username']; ?></h1>
            </div>
        </div>
    </div>

</body>
</html>