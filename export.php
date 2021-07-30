<?php

//Import DB using custom script
$conn = mysqli_connect("localhost", "root", "", "lfg");

$filename = "export_games.csv";
$fp = fopen('php://output', 'w');
/*
$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='lfg' AND TABLE_NAME='LFG_Game'";
$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_row($result)) {
	$header[] = $row[0];
}	*/

$header = array('id'  , 'title', 'category', 'description', 'image_url'); 

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$query = "SELECT game.id, game.title,CONCAT(ge.title, '>', type.title), game.description,  game.imageURL FROM `LFG_Game` as game left join LFG_GameType as type on type.id = game.type_id left JOIN LFG_GameGenre as ge on ge.id = game.genre_id ORDER BY `game`.`genre_id` ASC ";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_row($result)) {
	fputcsv($fp, $row);
}
exit;
?>