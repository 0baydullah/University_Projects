<?php
    include_once "parts/header.php";

    if( isset( $_GET[ 'update' ] ) ){
        $id = $_GET['ev-id'];
        $team_name = $_GET['team_name'];
        $games_arr = $_GET['game-select'];
        $p         = $_GET['p'];
        $d         = $_GET['d'];
        $w         = $_GET['w'];
        $l         = $_GET['l'];
        $pts       = $_GET['pts'];
        $event     = $_GET['event'];
        sort( $games_arr );
        $games_str = implode( ',', $games_arr );
        $fields = array( $id, $team_name, $games_arr, $p, $d, $w, $l, $pts, $event );
        $count = if_empty( $fields );
        if( !empty( $count ) ){
    
            try{
                $sql = $connection->prepare( "UPDATE teams SET team_name=:name, team_event=:event, team_game=:game, players=:p, win=:w, draw=:d, lost=:l, points=:pts  WHERE id=:id" );
                $sql->execute( array( 
                    ':id' => $id, 
                    ':name' => $team_name, 
                    ':game' => $games_str,
                    ':event'=>  $event,
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

    try{
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
            $sql = $connection->prepare( "SELECT * FROM teams WHERE id=:id" );
            $sql->execute( array( ':id' => $id ) );
    
            while( $row = $sql->fetch() ){
                $team_name = $row['team_name'];
                $p         = $row['players'];
                $d         = $row['draw'];
                $w         = $row['win'];
                $l         = $row['lost'];
                $pts       = $row['points'];
                $games = $row['team_game'];
                $team_event = $row['team_event'];
                $games_arr = explode( ",", $games );
                sort( $games_arr );
                $games_str = implode( ',', $games_arr );
            }
    
        }

    }catch( PDOException $e ){
        echo alert( 'Options could not find.' );
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
                            <input type="text" class="form-control" name="team_name" value="<?php echo $team_name; ?>">
                            <input type="text" name="ev-id" class="form-control d-none" value="<?php echo $id ?>" >
                        </div>
                        <div class="form-group">
                            <label for="game-select">Games</label>
                            <?php 
                                if( isset( $games_str ) ){
                                    $selected_options = getOption( $games_str, $options_str, $games_arr );
                                }

                                
                            ?>
                            <select class="form-control" name="game-select[]" id="game-select" multiple>
                                    <?php 
                                        foreach( $selected_options as $option ){

                                            if( $option[1] == true ){
                                                echo "<option value=$option[0] class='selected'>$option[0]</option>";
                                            }
                                            else{
                                                echo "<option value=$option[0]>$option[0]</option>";
                                            }
                                        }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Event</label>
                            <?php
                                $all_events = getEvents($connection); ?>
                                <select class='form-control' name='event'>
                            <?php foreach( $all_events as $e ){
                                    if( $e == $team_event ){ ?>
                                        <option value="<?php echo $e ?>" class='selected'><?php echo $e ?></option>
                                <?php }else{ ?>
                                        <option value="<?php echo $e ?>"><?php echo $e ?></option>
                                <?php }
                                }
                                echo "</select>";
                             ?>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">P</label>
                                    <input type="text" class="form-control" name="p" value="<?php echo ( isset( $p ) ) ? $p : '' ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">W</label>
                                    <input type="text" class="form-control" name="w" value="<?php echo ( isset( $w ) ) ? $w : ''; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">D</label>
                                    <input type="text" class="form-control" name="d" value="<?php echo ( isset( $d ) ) ? $d : ''; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">L</label>
                                    <input type="text" class="form-control" name="l" value="<?php echo ( isset( $l ) ) ? $l : ''; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Pts</label>
                                    <input type="text" class="form-control" name="pts" value="<?php echo ( isset( $pts ) ) ? $pts : ''; ?>">
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