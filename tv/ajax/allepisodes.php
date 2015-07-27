<?php
if($_GET['name'] && $_GET['year']){
	$name = $_GET['name'];
	$year = $_GET['year'];
	$response = file_get_contents("http://imdbapi.poromenos.org/js/?name=".str_replace(" ", "+", $name)."&year=".$year);
	$response = explode("[", $response);
	$response = $response[1];
	$response = explode("]", $response);
	$response = $response[0];
	$response = "[".$response."]";
	$json = json_decode($response, true);

	if (isset ( $json[0] )) {
		foreach ( $json as $item ) {
			if (strpos($item['name'],'#') == false) {
				$results [] = array (
						'season' => $item['season'],
						'name' => $item['name'],
						'number' => $item['number']
				);
			}
		}
	}

	# get a list of sort columns and their data to pass to array_multisort
	$sort = array();
	foreach($results as $k=>$v) {
	    $sort['season'][$k] = $v['season'];
	    $sort['number'][$k] = $v['number'];
	}
	// sort by event_type desc and then title asc
	array_multisort($sort['season'], SORT_DESC, $sort['number'], SORT_DESC, $results);
	echo json_encode($results);

}else{
	echo "Enter Name And Year";
}
?>