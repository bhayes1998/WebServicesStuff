<?php
/*
   Scott Campbell
   KV data model

pasword.php must have:
$user, $pass, $db, $host  and $addPass

 */

/*
 * if init, put in some test data
 * */

function initKeys() {
  $_SESSION['keys'] = array();
  add("test","HelloWorld","PASSWORD");
  add("test1","Test","PASSWORD");
  add("test2", "thething1982", "PASSWORD");
  add("test3", "success", "PASSWORD");
  add("test4", "hello there", "PASSWORD");
}

/*
 * this function will return an array of keys from the table
 * */

function getKeys() {    
  if (!isset($_SESSION['keys']))
    initKeys();
  return $_SESSION['keys'];
}

//given a key, find the associate value
function getValue($keyIn) {
  if (!isset($_SESSION['keys']))
    initKeys();

  foreach ($_SESSION['keys'] as $k=>$v) 
    if ($k == $keyIn)
      return $v;
  return "";
}


function add($k,$v,$pass) { 
  if ($pass != "PASSWORD")
    return "FAIL";
  if (!isset($_SESSION['keys']))
    initKeys();

  $_SESSION['keys'][$k] = $v;
  return "OK";
}
