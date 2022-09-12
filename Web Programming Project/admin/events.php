<?php 
    include_once 'parts/header.php';
    
    if( isset( $_GET[ 'delete' ] ) ){
        $id = $_GET['delete'];

        try{
            $sql = $connection->prepare( "DELETE FROM events WHERE id=:id" );
            $sql->execute( array( ':id' => $id ) );
            $count = $sql->rowCount();
            echo alert( $count.' record deleted' );
        }catch(PDOException $e){
            echo alert( "Try again" );
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
                <a href="add-event.php"><button type="button" class="btn btn-secondary">New Event</button></a>
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">Game</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $sql = $connection->prepare( "SELECT * FROM events" );
                        $sql->execute();
                    
                        while( $row = $sql->fetch() ){
                            $event_id = $row['id'];
                            $event_name = $row['event_name'];
                            $game   = $row['game']; ?>

                        <tr>
                            <th scope="row"><?php echo $event_id; ?></th>
                            <td><?php echo $event_name; ?></td>
                            <td><?php echo $game; ?></td>
                            <td>
                                <a href="edit-event.php?id=<?php echo $event_id ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                            </td>
                            <td>
                                <a href="events.php?delete=<?php echo $event_id ?>"><button type="button" class="btn btn-danger">delete</button></a>
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