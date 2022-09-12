<?php
    include_once 'parts/header.php';

    if( isset($_GET['submit']) ){
        $team_a = $_GET['team_name_a'];
        $team_b = $_GET['team_name_b'];
        $team_a_score = $_GET['team_a_score'];
        $team_b_score = $_GET['team_b_score'];
        $time   = $_GET['time'];
        $venue  = $_GET['venue'];
        $fields = array( $team_a, $team_b, $team_a_score, $team_b_score, $time, $venue );
        $empty = if_empty( $fields );

        if( !$empty ){

            if( $team_a !== $team_b ){
                try{

                    $sql = $connection->prepare( "INSERT INTO results ( `team_a`, `team_b`, `team_a_score`, `team_b_score`, `time`, `venue`) VALUES ( :team_a, :team_b, :team_a_score, :team_b_score, :time, :venue )" );
                    $sql->execute( array( 
                        ':team_a' => $team_a,
                        ':team_b' => $team_b,
                        ':team_a_score' => $team_a_score,
                        ':team_b_score' => $team_b_score,
                        ':time' => $time,
                        ':venue' => $venue
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
                        <h1>Add Result</h1>
                    
                        <form action="" class="form" method="GET">
                            <div class="form-group">
                                <label for="">Team A</label>
                                <select name="team_name_a" id="" class="form-control">
                                    <?php
                                        $teams = get_team($connection);
                                        foreach( $teams as $team ){
                                            echo "<option value='$team[1]'>$team[1]</option>";
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
                                            echo "<option value='$team[1]'>$team[1]</option>";
                                        }
                                     ?>
                                    
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Team A score</label>
                                        <input type="number" name="team_a_score" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Team B score</label>
                                        <input type="number" name="team_b_score" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Time</label>
                                <input type="textt" name="time" class="form-control" placeholder="April 04 2019">
                            </div>
                            <div class="form-group">
                                <label for="">Venue</label>
                                <input type="text" name="venue" class="form-control">
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