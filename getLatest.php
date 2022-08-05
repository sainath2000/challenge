<?php

$latestLink ='https://xkcd.com/info.0.json';
$latest_data=json_decode(file_get_contents($latestLink));
$newNumber=$latest_data->num;
$newImg=$latest_data->img;
$newTitle=$latest_data->title;
$newAlt=$latest_data->alt;

function FindData($id){
    $link = 'https://xkcd.com/'.$id.'/info.0.json';
    $raw_data = file_get_contents($link);
    $data = json_decode($raw_data);
    return $data;
}



?>