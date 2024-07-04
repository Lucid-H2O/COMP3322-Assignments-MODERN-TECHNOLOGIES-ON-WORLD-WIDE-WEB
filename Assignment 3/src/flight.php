<?php

  header('Content-Type: application/json;charset=utf-8');
  header('Access-Control-Allow-Origin: *');
  //set the default setting
  $lang='en';
  $cargo='false';
  $arrival='false';
  $date='2022-7-2';
  if (count($_GET) != 4) {
    echo "{\"problemNo\":\"xxxxxxxxxxxxxx\",\"message\":\"invalid query string\"}";
    exit();
  } 
  if (isset($_GET['lang']))
    $lang=urlencode($_GET['lang']);
  if (isset($_GET['cargo']))
    $cargo=urlencode($_GET['cargo']);
  if (isset($_GET['arrival']))
    $arrival=urlencode($_GET['arrival']);
  if (isset($_GET['date'])) {
    $date=urlencode($_GET['date']);  
  } else {
    echo "{\"problemNo\":\"xxxxxxxxxxxxxx\",\"message\":\"must provide a date string\"}";
    exit();    
  }

  $opts = array(
    'http'=>array(
      'protocol_version'=>1.1,
      'ignore_errors'=>true
    )
  );

  $context = stream_context_create($opts);

  try {
    $Odata = file_get_contents("https://www.hongkongairport.com/flightinfo-rest/rest/flights/past?date=$date&lang=$lang&cargo=$cargo&arrival=$arrival", false, $context);
  } catch (Exception $e) {
    echo $e->getMessage(), '\n';
  }
  if (boolval($Odata))
    echo $Odata;
  else
    echo "{\"problemNo\":\"xxxxxxxxxxxxxx\",\"message\":\"HTTP/1.1 400 Bad Request; check your date string\"}";
?>