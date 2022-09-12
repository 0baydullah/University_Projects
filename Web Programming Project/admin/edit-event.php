<?php 
    include_once 'parts/header.php';

    if( isset( $_GET[ 'update' ] ) ){
        $id = $_GET['ev-id'];
        $event_name = $_GET['event-name'];
        $games_arr = $_GET['game-select'];
        sort( $games_arr );
        $games_str = implode( ',', $games_arr );

        try{
            $sql = $connection->prepare( "UPDATE events SET event_name=:name, game=:game WHERE id=:id" );
            $sql->execute( array( ':id' => $id, ':name' => $event_name, ':game' => $games_str ) );
            $count = $sql->rowCount();
            echo alert( $count.' record updated' );
        }catch(PDOException $e){
            echo alert( $e->getMessage() );
        }
        
    }

    $sql = $connection->prepare( "SELECT * FROM games" );
    $sql->execute();

    $options_string;

    while( $row = $sql->fetch() ){
        $options_string = $row['games'];
    }

    $options = explode( ',', $options_string );
    sort( $options );
    $options_str = implode( ',', $options );


    if( isset( $_GET['id'] ) ){
        $id = $_GET['id'];
        $sql = $connection->prepare( "SELECT * FROM events WHERE id=:id" );
        $sql->execute( array( ':id' => $id ) );

        while( $row = $sql->fetch() ){
            $event_name = $row['event_name'];
            $games = $row['game'];
            $games_arr = explode( ",", $games );
            sort( $games_arr );
            $games_str = implode( ',', $games_arr );
        }

    }
?>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vertical-menu">
                <?php include_once 'parts/sidebar.php' ?>
            </div>
            <div class="col-10">
                <h1>Events</h1>
                <div class="row">
                    <div class="col-6">

                        <form action="" method="GET">
                            <div class="form-group">
                                <label for="event-name">Event Name</label>
                                <input class="form-control" type="text" name="event-name" id="event-name" value="<?php echo ( isset( $event_name ) ) ? $event_name : ''; ?>">
                                <input type="text" name="ev-id" class="form-control d-none" value="<?php echo $id ?>" >
                            </div>
                            <div class="form-group">
                                <label for="game-select">Games</label>
                                    <?php 
                                        $selected_options = getOption( $games_str, $options_str, $games_arr );
                                        
                                    ?>
                                <select class="form-control" name="game-select[]" id="game-select" multiple>
                                        <?php 
                                            foreach( $selected_options as $option ){

                                                if( $option[1] == true ){
                                                    echo "<option value='$option[0]' class='selected'>$option[0]</option>";
                                                }
                                                else{
                                                    echo "<option value='$option[0]'>$option[0]</option>";
                                                }
                                            }
                                        ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" name="update">Submit</button>
                        </form>

                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>