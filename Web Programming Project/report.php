<?php 
    include_once 'parts/header.php';

?>
    
    <section id="basketball">
        <div class="container">
            <h1>
                <?php 
                    if( isset( $_GET["game"] ) ){
                        echo $_GET["game"];
                    }
                ?>
            </h1>
            <div class="tabs-wrapper">

                <ul class="tabs">
                    <li class="tab active" data-detail="teams">Teams</li>
                    <li class="tab" data-detail="fixture">Fixture</li>
                    <li class="tab" data-detail="result">Results</li>
                </ul>
    
                <div class="table-report show" data-detail="teams">
                    <ul class="table flat">
                        <li class="table-list">
                            <table cellspacing=0>
                                <thead>
                                    <tr>
                                        <th>Updated: <?php echo date('d/m/Y h:i:s A') ?></th>
                                        <th>P</th>
                                        <th>W</th>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>Pts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( isset( $_GET["game"] ) ){
                                            $event_name = $_GET['event'];
                                            $game_name = $_GET["game"];
                                    
                                            $sql = $connection->prepare("SELECT * FROM teams WHERE team_game=:name AND team_event=:event");
                                            $sql->execute( array( ':name' => $game_name, ':event' => $event_name ) );
                                    
                                            $data = [];
                                            $idx = 0;

                                            while( $row = $sql->fetch() ){
                                                $team_name = $row['team_name'];
                                                $players    = $row['players'];
                                                $win    = $row['win'];
                                                $draw   = $row['draw'];
                                                $lost = $row['lost'];
                                                $points = $row['points']; 
                                                
                                                $data[] = array(
                                                    'team_name' => $team_name,
                                                    'players'   => $players,
                                                    'win'       => $win,
                                                    'draw'      => $draw,
                                                    'lost'      => $lost,
                                                    'points'    => $points
                                                );

                                            } 

                                            for( $j = 0; $j < count( $data ); $j++ ){

                                                for( $i = 0; $i < count( $data ) - $j - 1; $i++ ){

                                                    if( $data[$i]['points'] < $data[$i+1]['points'] ){
                                                        $temp = $data[$i];
                                                        $data[$i] = $data[$i+1];
                                                        $data[$i+1] = $temp;
                                                    }
                                                    
                                                }

                                            }

                                            foreach( $data as $row ){

                                                $idx++;

                                                $team_name  = $row['team_name'];
                                                $players    = $row['players'];
                                                $win        = $row['win'];
                                                $draw       = $row['draw'];
                                                $lost       = $row['lost'];
                                                $points     = $row['points'];  ?>

                                                <tr>
                                                    <td><span class="idx"><?php echo $idx; ?></span><?php echo $team_name ?></td>
                                                    <td><?php echo $players ?></td>
                                                    <td><?php echo $win ?></td>
                                                    <td><?php echo $draw ?></td>
                                                    <td><?php echo $lost ?></td>
                                                    <td><?php echo $points ?></td>
                                                </tr>

                                    <?php   }
                                        }
                                    ?>
                                   
                                </tbody>
                            </table>
                        </li>
                    </ul>
                </div>

                <div class="table-report" data-detail="fixture">
                    <?php
                        $events = $_GET['event'];
                        $games  = $_GET['game'];
                        $sql = $connection->prepare( "SELECT * FROM teams WHERE team_event=:events AND team_game=:game" );
						$sql->execute(array(':events'=>$events, ':game' => $games));
                                        
                        $teams = [];

                        while( $row = $sql->fetch() ){
                            $team_name = $row['team_name'];
                            $teams[] = $team_name;
                        }

                        $teams_db = [];

                        foreach( $teams as $team ){
                            $sql = $connection->prepare( "SELECT * FROM fixture WHERE team_a=:team_a OR team_b=:team_a" );
                            $sql->execute( array( ':team_a' => $team ) );
                            while( $row = $sql->fetch() ){
                                $teams_db[] = $row;
                            }
                        }

                        $teams_unique = makeUnique( $teams_db);

                        foreach( $teams_unique as $t ){ ?>

                            <ul class="table flat border-bottom">
                                <li class="table-list">
                                    <div class="fixture-table">

                                        <div class="team-1">
                                            <h2><?php echo $t[1] ?></h2>
                                        </div>
                                        <div class="details">
                                            <p class="date"><?php echo $t[3] ?></p>
                                            <p class="time"><?php echo $t[4] ?></p>
                                            <h3><?php echo $t[5] ?></h3>
                                        </div>
                                        <div class="team-2">
                                            <h2><?php echo $t[2] ?></h2>
                                        </div>

                                    </div>
                                </li>
                            </ul>

                    <?php }   

                    ?>
                </div>



                <div class="table-report" data-detail="result">
                    <?php
                        $events = $_GET['event'];
                        $games  = $_GET['game'];
                        $sql = $connection->prepare( "SELECT * FROM teams WHERE team_event=:events AND team_game=:game" );
						$sql->execute(array(':events'=>$events, ':game' => $games));
                                        
                        $teams = [];

                        while( $row = $sql->fetch() ){
                            $team_name = $row['team_name'];
                            $teams[] = $team_name;
                        }

                        $teams_db = [];

                        foreach( $teams as $team ){
                            $sql = $connection->prepare( "SELECT * FROM results WHERE team_a=:team_a OR team_b=:team_a" );
                            $sql->execute( array( ':team_a' => $team ) );
                            while( $row = $sql->fetch() ){
                                $teams_db[] = $row;
                            }
                        }

                        $teams_unique = makeUnique( $teams_db);

                        foreach( $teams_unique as $t ){ ?>

                            <ul class="table flat border-bottom">
                                <li class="table-list">
                                    <div class="fixture-table">

                                        <div class="team-1">
                                            <h2><?php echo $t[1] ?></h2>
                                        </div>
                                        <div class="details">
                                            <p class="date"><?php echo $t[5] ?></p>
                                            <p class="result"><?php echo $t[3] ?>-<?php echo $t[4] ?></p>
                                            <h3><?php echo $t[6] ?></h3>
                                        </div>
                                        <div class="team-2">
                                            <h2><?php echo $t[2] ?></h2>
                                        </div>

                                    </div>
                                </li>
                            </ul>

                        <?php }
						
                    ?>
                    
                </div>



            </div>
        </div>
    </section>

    <script src="js/report.js"></script>
</body>
</html>