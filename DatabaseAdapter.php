<?php
  include 'DatabaseManager.php';

  define("COURT_TABLE", "Court");
  define("GAME_TABLE", "Game");
  define("MESSAGE_TABLE", "Message");
  define("PLAYER_TABLE", "Player");
  define("PLAYER_GAME_TABLE", "PlayerGame");

  //Input: player name, password
  //Output: player ID
  function addPlayer($name, $pass){
    return addRow(PLAYER_TABLE, array("Name", "Password"), array($name, $pass));
  }

  //Input: player name
  //Ouput: player
  function getPlayerByName($name){
    return getRow(PLAYER_TABLE, "Name", $name);
  }

  //Input: player ID
  //Ouput: player
  function getPlayerById($id){
    return getRow(PLAYER_TABLE, "ID", $id);
  }

  //Input: game ID
  //Ouput: game
  function getGameByID($id){
    return getRow(GAME_TABLE, "ID", $id);
  }

  //Input: player ID
  //Output: list of games player has joined
  function getGamesByPlayerID($playerID){
    $playerGameMap = getRows(PLAYER_GAME_TABLE, "PlayerID", $playerID);
    $games = array();
    foreach ($playerGameMap as $playerGame){
      $game = getGameByID($playerGame["GameID"]);
      array_push($games, $game);
    }
    return $games;
  }

  //Input: courtID
  //Ouput: list of games scheduled for that court
  function getGamesByCourtID($courtID){
    //TODO
  }

  //Input: court ID
  //Output: court
  function getCourtByID($id){
    return getRow(COURT_TABLE, "ID", $id);
  }

  //Input: longitude, latitude, [lat range, lon range]
  //Output: list of all Courts within range of ($lat, $lon)
  function getCourtsInRange($longitude, $latitude, $ranges){
    $cols = ["Longitude", "Latitude"];
    $vals = [$longitude, $latitude];
    return getRowsByRange(COURT_TABLE, $cols, $vals, $ranges);
  }
