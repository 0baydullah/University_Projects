<?php 
    include_once 'parts/header.php';
    if( isset( $_GET[ 'delete' ] ) ){
        $id = $_GET['delete'];
        
        try{
            $sql = $connection->prepare( "DELETE FROM teams WHERE id=:id" );
            $sql->execute( array( ':id' => $id ) );
            $count = $sql->rowCount();
            echo alert( $count.' record deleted' );
        }catch( PDOException $e ){
            echo alet( $e.' Try again!' );
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
                <h1>Teams</h1>
                <a href="add-team.php"><button type="button" class="btn btn-secondary">New Event</button></a>
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Team Name</th>
                        <th scope="col">Event</th>
                        <th scope="col">Game</th>
                        <th scope="col">P</th>
                        <th scope="col">W</th>
                        <th scope="col">d</th>
                        <th scope="col">l</th>
                        <th scope="col">Pts</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $sql = $connection->prepare( "SELECT * FROM teams" );
                        $sql->execute();
                    
                        while( $row = $sql->fetch() ){
                                $team_id = $row['id'];
                                $team_name = $row['team_name'];
                                $event   = $row['team_event']; 
                                $game   = $row['team_game']; 
                                $players = $row['players'];
                                $win = $row['win'];
                                $draw = $row['draw'];
                                $lost = $row['lost'];
                                $points = $row['points'];
                            ?>

                        <tr>
                            <th scope="row"><?php echo $team_id; ?></th>
                            <td><?php echo $team_name; ?></td>
                            <td><?php echo $event; ?></td>
                            <td><?php echo $game; ?></td>
                            <td><?php echo $players; ?></td>
                            <td><?php echo $win; ?></td>
                            <td><?php echo $draw; ?></td>
                            <td><?php echo $lost; ?></td>
                            <td><?php echo $points; ?></td>
                            <td>
                                <a href="edit-team.php?id=<?php echo $team_id ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                            </td>
                            <td>
                                <a href="teams.php?delete=<?php echo $team_id ?>"><button type="button" class="btn btn-danger">delete</button></a>
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
</html>