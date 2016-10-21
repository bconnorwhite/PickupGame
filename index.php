<?php
  session_start();
  include 'DatabaseAdapter.php';
  $nameErr = $passErr = "";

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $pass = test_input($_POST["pass"]);

	if(empty($name))
      $nameErr = "* Required";
    else
      $nameErr = "";
    if(empty($pass))
      $passErr = "* Required";
    else
      $passErr = "";

    if(empty($nameErr) && empty($passErr)){//No errors
      $player = getPlayerByName($name);

      if(empty($player)){//If username is not taken
        $playerID = addPlayer($name, $pass);
        login($playerID);
      } else if($player['Password'] == $pass){//correct password
        $playerID = $player['ID'];
        login($playerID);
      } else { //incorrect password OR username taken
        $passErr = "* Incorrect password, or username is taken";
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function login($playerID){
    $_SESSION['playerID'] = $playerID;
    header('Location: map.php');
  }

  include 'head.php';
?>
    <div id="login">
      <h1>Pickup Game</h1>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" accept-charset="UTF-8">
        <input type="text" name="name" placeholder="Username" /><span class="error"><?php echo $nameErr ?></span><br />
        <input type="password" name="pass" placeholder="Password" /><span class="error"><?php echo $passErr ?></span><br />
        <input type="submit" />
      </form>
    </div>