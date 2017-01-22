<?php

Flight::route('/', function(){
  Flight::render('index.php');
});

Flight::route('/sign-in', function(){
  Flight::render('signin.php');
});
