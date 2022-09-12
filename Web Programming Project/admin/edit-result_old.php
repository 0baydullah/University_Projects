<?php
    include_once 'parts/header.php';

    $result_id;
    $team_a_name;
    $team_b_name;
    $team_a_score;
    $team_b_score;
    $time;
    $venue;

    if( isset($_GET['id'])){

        $result_id = $_GET['id'];

        $sql = $connection->prepare( "SELECT * FROM results WHERE id=:id" );
        $sql->execute( array( ':id' => $result_id ) );
        
        if ( $sql->rowCount() > 0 ){
            while( $row = $sql->fetch() ){
    
                $team_a_name =  $row['team_a'];
                $team_b_name =  $row['team_b'];
    
                $team_a_score = $row['team_a_score'];
                $team_b_score = $row['team_b_score'];
    
                $time = $row['time'];
                $venue = $row['venue'];
            }
    
        }

    }

    if( isset($_POST['update']) ){

        $result_id = $_POST['result_id'];
        
        $team_a_name = $_POST['team_a_name'];
        $team_b_name = $_POST['team_b_name'];

        $team_a_score = $_POST['team_a_score'];
        $team_b_score = $_POST['team_b_score'];

        $time         = $_POST['time'];
        $venue        = $_POST['venue'];
        
        try{

            $sql    = $connection->prepare( "UPDATE results SET team_a=:team_a, team_b=:team_b, team_a_score =:a_score, team_b_score=:b_score, time=:time, venue =:venue WHERE id=:id" );
            $sql->execute( array(
                ':team_a'  => $team_a_name,
                ':team_b'  => $team_b_name,
                ':a_score' => $team_a_score,
                ':b_score' => $team_b_score,
                ':time'    => $time,
                ':venue'   => $venue,
                ':id'      => $result_id
            ) );

            $count = $sql->rowCount();
            echo alert( $count . " data updated!" );

        }catch(PDOException $e){
            echo alert( $e->getMessage() . " Error updating record" );
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
                <h1>Edit Results</h1>
                <div class="row">
                    <div class="col-6">

                        <form action="edit-result.php" method="POST">
                            <input class="form-control" type="hidden"  name="result_id" id="result_id" value="<?php echo $result_id?>" >

                            <div class="form-group">
                                <label for="team_a_name">Team A Name</label>
                                <input class="form-control" type="text" name="team_a_name" id="team_a_name" value="<?php echo $team_a_name?>" required>
                            </div>

                            <div class="form-group">
                                <label for="team_b_name">Team B Name</label>
                                <input class="form-control" type="text" name="team_b_name" id="team_b_name"  value="<?php echo $team_b_name?>" required>
                            </div>

                            <div class="form-group">
                                <label for="team_a_score">Team A Score</label>
                                <input class="form-control" type="text" name="team_a_score" id="team_a_score"  value="<?php echo $team_a_score?>" required>
                            </div>

                            <div class="form-group">
                                <label for="team_b_score">Team B Score</label>
                                <input class="form-control" type="text" name="team_b_score" id="team_b_score"  value="<?php echo $team_b_score?>" required>
                            </div>

                            <div class="form-group">
                                <label for="time">Time</label>
                                <input class="form-control" type="text" name="time" id="time"  value="<?php echo $time?>" required>
                            </div>

                            <div class="form-group">
                                <label for="venue">Venue</label>
                                <input class="form-control" type="text" name="venue" id="venue"  value="<?php echo $venue?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </form>

                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>