<?php
/*
 * Plugin Name: Login
 * Description: Login System
 * Author:      Justin Preuß
 */

add_filter("the_content", "login");

function login($content){

  if( isset($_POST['username']) && isset($_POST['password']) ){
    $usn = $_POST['username'];
    $pwd = $_POST['password'];
    return $content;
  }else{
   $form ='
    <form method="post">
      <input type="text" name="Username" value="'.$usn.'">
      <input type="text" name="Password"  value="'.$pwd.'">
      <input type="submit" value = "Submit">
    </form>';

    $content = str_replace("[login]",$form, $content);
  }

  
  return $content;
}

