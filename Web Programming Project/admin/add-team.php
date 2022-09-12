<?php
    include_once "parts/header.php";

    if( isset( $_GET[ 'update' ] ) ){
        $team_name = $_GET['team_name'];
        $games_arr = $_GET['game-select'];
        $event_arr = $_GET['event-select'];

        $fields = [ $team_name, $games_arr ];
        $count = if_empty( $fields );

        if( empty( $count ) ){
            $p         = $_GET['p'];
            $d         = $_GET['d'];
            $w         = $_GET['w'];
            $l         = $_GET['l'];
            $pts       = $_GET['pts'];
            sort( $games_arr );
            $games_str = implode( ',', $games_arr );
            $events_str = implode( ',', $event_arr );
    
            try{
                $sql = $connection->prepare( "INSERT INTO teams (team_name, team_event, team_game, players, win, draw, lost, points) VALUES ( :name, :event, :game, :p, :w, :d, :l, :pts )" );
                $sql->execute( array( 
                    ':name' => $team_name, 
                    ':event' => $events_str,
                    ':game' => $games_str,
                    ':p'    => $p,
                    ':d'    => $d,
                    ':w'    => $w,
                    ':l'    => $l,
                    ':pts'  => $pts
    
                ) );
                $count = $sql->rowCount();
                echo alert( $count.' record updated' );
            }catch(PDOException $e){
                echo alert( $e->getMessage() );
            }
        }else{
            echo alert( "Fields can't be empt!" );
        }
        
    }

 ?>

<div class="container-fluid">
        <div class="row">
            <div class="col-2 vertical-menu">
                <?php include_once 'parts/sidebar.php' ?>
            </div>
            <div class="col-10">
                <div class="col-6">
                    <h1>Team</h1>
                    <form action="" method="GET">
                        <div class="form-group">
                            <label for="">Team name</label>
                            <input type="text" class="form-control" name="team_name">
                        </div>
                        <div class="form-group">
                            <label for="game-select">Games</label>
                            <?php 
                               
                                $selected_options = getOptions($connection);
                                

                                
                            ?>
                            <select class="form-control" name="game-select[]" id="game-select" multiple>
                                    <?php 
                                        foreach( $selected_options as $option ){ ?>
                                            <option value="<?php echo $option ?>"><?php echo $option ?></option>
                                    <?php  }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="game-select">Event</label>
                            <?php 
                               
                                $selected_options = getEvents($connection);
                                

                                
                            ?>
                            <select class="form-control" name="event-select[]" id="game-select">
                                    <?php 
                                        foreach( $selected_options as $option ){ ?>
                                        <option value="<?php echo $option ?>"><?php echo $option ?></option>
                                    <?php
                                        }
                                    ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">P</label>
                                    <input type="text" class="form-control" name="p">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">W</label>
                                    <input type="text" class="form-control" name="w">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">D</label>
                                    <input type="text" class="form-control" name="d">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">L</label>
                                    <input type="text" class="form-control" name="l">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Pts</label>
                                    <input type="text" class="form-control" name="pts">
                                </div>
                            </div>
                            <div class="col-2">
                                
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">Submit</button>
                    </form>
                </div>
                <div class="col-6"></div>
            </div>
        </div>
</div>