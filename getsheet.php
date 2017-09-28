<?php
require __DIR__ . '/vendor/autoload.php';
define('SHEET_ID', '1XKLW8RuUpr1ZkkTa6pL_AbUPcLvHJq5w6wKhH3Hqz84'); //sheetnya asprak dap
define('APPLICATION_NAME', 'Manipulating Google Sheets from PHP');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('ACCESS_TOKEN', '	GET THIS ACCESS TOKEN FROM CLIENT_SECRET.JSON	');//dapetin acces_token dari cleint_secret.json
define('SCOPES', implode(' ', [Google_Service_Sheets::SPREADSHEETS]));
$clients = new Google_Client();
$clients->setApplicationName(APPLICATION_NAME);
$clients->setScopes(SCOPES);
$clients->setAuthConfig(CLIENT_SECRET_PATH);
$clients->setAccessToken(ACCESS_TOKEN);
$service = new Google_Service_Sheets($clients);
$sheetInfo = $service->spreadsheets->get(SHEET_ID)->getProperties();
$sheets = $service->spreadsheets->get(SHEET_ID)->getSheets();

$ay = array();
$dar = array();
$range = null;

for($j = 0; $j < count($sheets); $j++) {
	if(isset($sheets[$j]['modelData']['properties']['title'])&&(strpos($sheets[$j]['modelData']['properties']['title'], 'MODUL ') !== false)){
		array_push($ay, preg_replace("/[^0-9]/","",$sheets[$j]['modelData']['properties']['title']));//kalo ada MODUL x, x masuk ke array
	}

}
$range = 'MODUL '.max($ay).'!A2:U';//pilih TAB yang namanya MODUL (x tertinggi, berarti modul terbaru)
$response = $service->spreadsheets_values->get(SHEET_ID, $range);
$values = $response->getValues();
/*
-----------------------PENTING----------------
1 senin
3 selasa
5 rabu
7 kamis
9 jumat
-----------------------PENTING------------
*/
$tosend = null;
date_default_timezone_set('Asia/Jakarta');
$timezone = date_default_timezone_get();
$date = date('D', time());
$today = date("d/m/y", time());
$jam = date("H:i:s", time());
for($j = 0; $j < 9; $j+=2) {
	$tem = null;
if($j==0){
	$hari = "SENIN";
}else if($j==2){
	$hari = "SELASA";
}else if($j==4){
	$hari = "RABU";
}else if($j==6){
	$hari = "KAMIS";
}else if($j==8){
	$hari = "JUMAT";
}
$tem .= "[REMINDER JADWAL ASPRAK HARI ".$hari.", ".$today." BERDASARKAN TAB MODUL ".max($ay)."]

".$values[0][0].": ";
for($i = 0; $i < 12; $i++) {
	if(!empty($values[$i])){
		if((!empty($values[$i][$j+11]))&&(strlen($values[$i][$j+11])>1)){
			if(substr($values[$i][$j+11], 0, 4 ) === "DAP "){
				$tem .= "
";
			}	
			if(strpos($values[$i][$j+11], 'DAP ') !== false){
				$tem .= "	> ".$values[$i][$j+11].": ";
			}else{
				$tem .=  $values[$i][$j+11].", ";	
			}
		}
		if((!empty($values[$i][$j+12]))&&(strlen($values[$i][$j+12])>1)){
			$tem .=  $values[$i][$j+12].", ";
		}
	}
}
$tem .=  "
";
$tem .=  $values[12][0].": ";
for($i = 12; $i < 30; $i++) {
	if(!empty($values[$i])){
		if((!empty($values[$i][$j+11]))&&(strlen($values[$i][$j+11])>1)){
			if(substr($values[$i][$j+11], 0, 4 ) === "DAP "){
				$tem .= "
";
			}	
			if(strpos($values[$i][$j+11], 'DAP ') !== false){
				$tem .= "	> ".$values[$i][$j+11].": ";
			}else{
				$tem .=  $values[$i][$j+11].", ";	
			}
		}
		if((!empty($values[$i][$j+12]))&&(strlen($values[$i][$j+12])>1)){
			$tem .=  $values[$i][$j+12].", ";
		}
	}
}
$tem .=  "
";
$tem .=  $values[30][0].": ";
for($i = 30; $i < 47; $i++) {
	if(!empty($values[$i])){
		if((!empty($values[$i][$j+11]))&&(strlen($values[$i][$j+11])>1)){
			if(substr($values[$i][$j+11], 0, 4 ) === "DAP "){
				$tem .= "
";
			}
			if(strpos($values[$i][$j+11], 'DAP ') !== false){
				$tem .= "	> ".$values[$i][$j+11].": ";
			}else{
				$tem .=  $values[$i][$j+11].", ";	
			}
		}
		if((!empty($values[$i][$j+12]))&&(strlen($values[$i][$j+12])>1)){
			$tem .=  $values[$i][$j+12].", ";
		}
	}
}
$tem .=  "
";
$tem .=  $values[47][0].": ";
for($i = 47; $i < count($values); $i++) {
	if(!empty($values[$i])){
		if((!empty($values[$i][$j+11]))&&(strlen($values[$i][$j+11])>1)){
			if(substr($values[$i][$j+11], 0, 4 ) === "DAP "){
				$tem .= "
";
			}
			if(strpos($values[$i][$j+11], 'DAP ') !== false){
				$tem .= "	> ".$values[$i][$j+11].": ";
			}else{
				$tem .=  $values[$i][$j+11].", ";	
			}
		}
		if((!empty($values[$i][$j+12]))&&(strlen($values[$i][$j+12])>1)){
			$tem .=  $values[$i][$j+12].", ";
		}
	}
}
$tem .= "

JADWAL DAPAT SEWAKTU-WAKTU BERUBAH, CEK https://docs.google.com/spreadsheets/d/1XKLW8RuUpr1ZkkTa6pL_AbUPcLvHJq5w6wKhH3Hqz84/preview UNTUK JADWAL YANG SEBENARNYA.
*data di atas mungkin tidak akurat apabila bang Helmi mengubah pattern table pada link di atas :v

pesan ini dikirim secara otomatis pada hari ini jam ".$jam;
array_push($dar, $tem);
}
if($date=='Mon'){
	$tosend = $dar[0];
}else if($date=='Tue'){
	$tosend = $dar[1];
}else if($date=='Wed'){
	$tosend = $dar[2];
}else if($date=='Thu'){
	$tosend = $dar[3];
}else if($date=='Fri'){
	$tosend = $dar[4];
}else{
	$tosend = "no";
}
echo $tosend;
?>