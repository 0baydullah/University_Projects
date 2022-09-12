<?php 
    include_once 'parts/header.php';

    if( isset( $_GET["add-event"] ) ){
        $event_name  = $_GET["event-name"];

        if( !empty( $event_name ) ){

            $game_select = $_GET['game-select'];
            $game_string = implode( ',', $game_select );
            
           try{
                $sql = $connection->prepare( 'SELECT * FROM events WHERE event_name = :name' );
                $sql->execute( array( ':name' => $event_name ) );
        
                if( $row = $sql->fetch() ){
                    $string_from_array = implode( ',', explode( ',', $row['game'] ) );
                    
                    if( !str_contains( $string_from_array, $game_string ) ){
                        $game_string .= ',' . $row['game'];
                        $sql = $connection->prepare( 'UPDATE events SET game=:game WHERE event_name = :name' );
                        $sql->execute( array( ':game' => $game_string, ':name' => $event_name ) );
                    }else{
                        echo alert( 'Already added!' );
                    }
                    
                }else{
                    $sql = $connection->prepare( "INSERT INTO events ( event_name, game ) VALUES ( :name, :game )" );
                    $sql->execute( array( ':name' => $event_name, ':game' => $game_string ) );
                }

                $count = $sql->rowCount();
                echo alert( $count.' record added!' );

           }catch( PDOException $e ){
                echo alert( $e->getMessage() );
           }

        }else{
            echo alert( 'Fields can not be empty' );
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
                                <input class="form-control" type="text" name="event-name" id="event-name">
                            </div>
                            <div class="form-group">
                                <label for="game-select">Games</label>
                                <select class="form-control" name="game-select[]" id="game-select" multiple size='4'>
                                    <?php 
                                    $sql = $connection->prepare( "SELECT * FROM games" );
                                    $sql->execute();
                            
                                    while( $row = $sql->fetch() ){
                                        $games = $row['games'];
                                        $games_arr = explode( ",", $games );
                                    }
                                    if( isset( $games_arr ) ){
                                            foreach( $games_arr as $game ){ ?>

                                                <option value="<?php echo $game ?>"><?php echo ucfirst($game) ?></option>

                                    <?php   }
                                        } 
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add-event">Submit</button>
                        </form>

                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>