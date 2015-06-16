<?php
error_reporting(0);
if ($_GET['q']) {
	if (($handle = fopen("http://services.tvrage.com/tools/quickinfo.php?show=".urlencode($_GET['q']), "r")) !== FALSE) {
	    echo '{"status":1,';
	  while (($data = fgetcsv($handle, 1000, "@")) !== FALSE) {
	    $num = count($data);
	    // echo $data[0];
	    if (strcmp($data[0], "Show Name") == 0) {
	    	echo '"name":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Ended") == 0) {
	    	echo '"ended":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Latest Episode") == 0) {
	    	$episode = explode("^", $data[1]);
	    	echo '"latest_episode":'.json_encode($episode).',';
	    }else if (strcmp($data[0], "Next Episode") == 0) {
	    	$episode = explode("^", $data[1]);
	    	echo '"next_episode":'.json_encode($episode).',';
	    }else if (strcmp($data[0], "Country") == 0) {
	    	echo '"country":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Status") == 0) {
	    	echo '"show_status":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Classification") == 0) {
	    	echo '"classification":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Genres") == 0) {
	    	echo '"genres":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Network") == 0) {
	    	echo '"network":"'.$data[1].'",';
	    }else if (strcmp($data[0], "Runtime") == 0) {
	    	echo '"runtime":"'.$data[1].'"';
	    }
	  }
	  echo "}";
	  fclose($handle);
	}else{
		die('{"status":0,"error":"Cannot Connect Right Now"}');
	}
}else{
	die('{"status":0,"error":"Add q"}');
}
?>
