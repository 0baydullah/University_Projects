<?php
    include_once 'parts/header.php';

    if ( isset($_GET['delete'])){
        
        $result_id = $_GET['delete'];
        try{
            $sql    = $connection->prepare( "DELETE FROM results WHERE id=:id" );
            $sql->execute( array( ':id' => $result_id ) ); 
            $count = $sql->rowCount();
            echo alert( $count . " data deleted!" );

        }catch( PDOException $e ){
            echo alert( $e->getMessage() );
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
               
                   
                <h1>Results</h1>
                <a href="add-result.php"><button type="button" class="btn btn-secondary">New Event</button></a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Team A</th>
                            <th scope="col">Team B</th>
                            <th scope="col">A Score</th>
                            <th scope="col">B Score</th>
                            <th scope="col">Time</th>
                            <th scope="col">Venue</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $sql = $connection->prepare( "SELECT * FROM results" );
                        $sql->execute();
                    
                        while( $row = $sql->fetch() ){
                            $event_id = $row['id'];
                            $team_a = $row['team_a'];
                            $team_b = $row['team_b'];
                            $team_a_score = $row['team_a_score'];
                            $team_b_score = $row['team_b_score'];
                            $time = $row['time'];
                            $venue = $row['venue']; ?>

                        <tr>
                            <th scope="row"><?php echo $event_id; ?></th>
                            <td><?php echo $team_a; ?></td>
                            <td><?php echo $team_b; ?></td>
                            <td><?php echo $team_a_score; ?></td>
                            <td><?php echo $team_b_score; ?></td>
                            <td><?php echo $time; ?></td>
                            <td><?php echo $venue; ?></td>
                            <td>
                                <a href="edit-result.php?id=<?php echo $event_id ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                            </td>
                            <td>
                                <a href="results.php?delete=<?php echo $event_id ?>"><button type="button" class="btn btn-danger">delete</button></a>
                            </td>
                        </tr>

                    <?php  }
                     ?>
                    </tbody>
                </table>
                  
               
            </div>
        </div>
    </div>
</body>