<?php 
    include_once 'parts/header.php';
    include_once 'parts/Query.php';
?>
    
    <section id="basketball">
        <div class="container">
            <h1 class="section-title">Basketball</h1>

            <ul class="table">
                
                <?php 
                    $stmt = $connection->prepare("SELECT * FROM events");
                    $stmt->execute();

                    while( $row = $stmt->fetch() ){ 
                        $event_name = $row['event_name']; 
                        $game       = $row['game'];
                        $games = explode( ',', $game );

                        if( in_array( 'basketball', $games ) ){

                        
                        ?>

                        <li class="table-list">
                            <a href="report.php?event=<?php echo $event_name ?>&game=basketball" class="table-link"><?php echo $event_name ?></a>
                        </li>

                <?php    }}
                ?>

            </ul>
        </div>
    </section>

    <section id="basketball">
        <div class="container">
            <h1 class="section-title">rugby</h1>

            <ul class="table">
                
                <?php 
                    $stmt = $connection->prepare("SELECT * FROM events");
                    $stmt->execute();

                    while( $row = $stmt->fetch() ){ 
                        $event_name = $row['event_name']; 
                        $game       = $row['game'];
                        $games = explode( ',', $game );

                        if( in_array( 'rugby', $games ) ){
                        ?>

                        <li class="table-list">
                            <a href="report.php?event=<?php echo $event_name ?>&game=rugby" class="table-link"><?php echo $event_name ?></a>
                        </li>

                <?php    }}
                ?>

            </ul>
        </div>
    </section>

    <section id="basketball">
        <div class="container">
            <h1 class="section-title">Cricket</h1>

            <ul class="table">
                
                <?php 
                    $stmt = $connection->prepare("SELECT * FROM events");
                    $stmt->execute();

                    while( $row = $stmt->fetch() ){ 
                        $event_name = $row['event_name']; 
                        $game       = $row['game'];
                        $games = explode( ',', $game );

                        if( in_array( 'cricket', $games ) ){
                        ?>

                        <li class="table-list">
                            <a href="report.php?event=<?php echo $event_name ?>&game=cricket" class="table-link"><?php echo $event_name ?></a>
                        </li>

                <?php    }}
                ?>

            </ul>
        </div>
    </section>

    <section id="basketball">
        <div class="container">
            <h1 class="section-title">Football</h1>

            <ul class="table">
                
                <?php 
                    $stmt = $connection->prepare("SELECT * FROM events");
                    $stmt->execute();

                    while( $row = $stmt->fetch() ){ 
                        $event_name = $row['event_name']; 
                        $game       = $row['game'];
                        $games = explode( ',', $game );

                        if( in_array( 'football', $games ) ){
                        ?>

                        <li class="table-list">
                            <a href="report.php?event=<?php echo $event_name ?>&game=football" class="table-link"><?php echo $event_name ?></a>
                        </li>

                <?php    }}
                ?>

            </ul>
        </div>
    </section>

</body>
</html>