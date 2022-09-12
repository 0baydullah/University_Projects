<?php
    include_once 'parts/header.php';

    if( isset( $_GET['id'] ) ){ 
        $id = $_GET['id'];
        try{
            $sql = $connection->prepare( 'SELECT * FROM fixture WHERE id=:id' );
            $sql->execute( array( ':id' =>  $id ) );

            while( $row = $sql->fetch() ){
                $team_a = $row['team_a'];
                $team_b = $row['team_b'];
                $date = $row['date'];
                $time   = $row['time'];
                $venue  = $row['venue'];
            }
        }catch( PDOExecption $e ){
            echo alert( $e->getMessage() );
        }

    }


    if( isset($_GET['submit']) ){
        $id    = $_GET['id'];
        $team_a = $_GET['team_name_a'];
        $team_b = $_GET['team_name_b'];
        $date = $_GET['date'];
        $time   = $_GET['time'];
        $venue  = $_GET['venue'];
        $fields = array( $team_a, $team_b, $date, $time, $venue );
        $empty = if_empty( $fields );

        if( !$empty ){

            if( $team_a !== $team_b ){
                try{

                    $sql = $connection->prepare( "UPDATE fixture SET `team_a`=:team_a,`team_b`=:team_b,`date`=:date,`time`=:time,`venue`=:venue WHERE id=:id" );
                    $sql->execute( array( 
                        ':team_a' => $team_a,
                        ':team_b' => $team_b,
                        ':date' => $date,
                        ':time' => $time,
                        ':venue' => $venue,
                        ':id'   => $id
                     ) );
    
                    $count = $sql->rowCount();
                    echo alert( $count . " team added" );
    
                }catch( PDOException $e ){
                    echo alert( $e->getMessage() );
                }
            }else{
                echo alert( 'Team A and Team B can not be the same' );
            }

            
        }else{
            echo alert( $empty . ' field need to be filled' );
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

               <div class="row">
                   <div class="col-6">
                        <h1>Edit Result</h1>
                    
                        <form action="" class="form" method="GET">
                            <div class="form-group">
                                <label for="">Team A</label>
                                <select name="team_name_a" id="" class="form-control">
                                    <?php
                                        $teams = get_team($connection);
                                        foreach( $teams as $team ){
                                            if( isset( $team_a ) ){
                                                if( $team_a == $team[1] ){
                                                    echo "<option value='$team[1]'>$team[1]*</option>";
                                                }else{
                                                    echo "<option value='$team[1]'>$team[1]</option>";
                                                }
                                            }else{
                                                echo "<option value='$team[1]'>$team[1]</option>";
                                            }
                                        }
                                     ?>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Team B</label>
                                <select name="team_name_b" id="" class="form-control">
                                    <?php
                                        $teams = get_team($connection);
                                        foreach( $teams as $team ){
                                            if( isset( $team_b ) ){
                                                if( $team_b == $team[1] ){
                                                    echo "<option value='$team[1]'>$team[1]*</option>";
                                                }else{
                                                    echo "<option value='$team[1]'>$team[1]</option>";
                                                }
                                            }else{
                                                echo "<option value='$team[1]'>$team[1]</option>";
                                            }
                                        }
                                     ?>
                                    
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="text" name="date" class="form-control" value="<?php echo $date ?>">
                                        <input type="text" name="id" class="form-control d-none" value="<?php echo $id ?>">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Time</label>
                                        <input type="textt" name="time" class="form-control" placeholder="April 04 2019" value="<?php echo $time ?>">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Venue</label>
                                        <input type="text" name="venue" class="form-control" value="<?php echo $venue ?>">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                   </div>
                   <div class="col-6"></div>
               </div>
               
            </div>
        </div>
    </div>
</body>