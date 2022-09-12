<?php

function alert( $txt ){
    return '<div class="alert alert-danger alert-box" role="alert">'.$txt. '</div>';
}

function getOption( $games_str, $options_str, $games_arr ){
     
    $unselected_options_arr = [];
    $unselected_options = strcmp( $games_str, $options_str );
    $selected_options = [];

    foreach( $games_arr as $game ){
        $selected_options[] = array( $game, true );
    }

    if( $unselected_options ){
        $games_split = explode(',', $games_str );
        $options_split = explode(',', $options_str );

        foreach( $options_split as $key=>$o ){
            foreach( $games_split as $k=>$g ){
                if( $o == $g ){
                    unset($options_split[$key]);
                }
            }
        }

        foreach( $options_split as $op ){
            $unselected_options_arr[] = array( $op, false );
        }

        $selected_options = array_merge( $unselected_options_arr, $selected_options );

    }

    return $selected_options;                                        
                                    
}

function get_team($connection){
    
    try{
        $sql = $connection->prepare( "SELECT * FROM teams" );
        $sql->execute();

        $teams = [];

        while( $row = $sql->fetch() ){
            $id = $row['id'];
            $name = $row['team_name'];

            $teams[] = array( $id, $name );
        }

        return $teams;

    }catch( PDOException $e ){
        echo alert( $e->getMessage );
    }

}

function if_empty( $fields ){
    $arr = $fields;
    $count = 0;

    foreach( $arr as $a ){
        if( empty( $a ) ){
            $count++;
        }
    }

    return $count;
    
}

function getOptions($connection){

    try{
        $sql = $connection->prepare( "SELECT * FROM games" );
        $sql->execute();

        while( $row = $sql->fetch() ){
            $name = $row['games'];
            $games_arr = explode( ',', $name );
        }

        return $games_arr;

    }catch( PDOException $e ){
        echo alert( $e->getMessage() );
    }

}

function getEvents($connection){

    try{
        $sql = $connection->prepare( "SELECT * FROM events" );
        $sql->execute();

        $games_arr = [];

        while( $row = $sql->fetch() ){
            $name = $row['event_name'];
            $games_arr[] = $name;
        }

        return $games_arr;

    }catch( PDOException $e ){
        echo alert( $e->getMessage() );
    }

}

function makeUnique( $duplicate ){
    $duplicate_arr = $duplicate;
    $unique_arr = [];

    $len = count($duplicate_arr);

    for( $i = 0; $i < $len; $i++ ){
        if(array_search($duplicate_arr[$i], $unique_arr) === false){

            array_push($unique_arr,$duplicate_arr[$i]);
        }
    }

    return $unique_arr;
}