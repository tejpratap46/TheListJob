<?php 
# http://gdata.youtube.com/feeds/api/playlists/PLDcnymzs18LVXfO_x0Ei0R24qDbVtyy66/?v=2&alt=json&start-index=1
$cont = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLDcnymzs18LVXfO_x0Ei0R24qDbVtyy66/?v=2&alt=json&start-index=1')); 
$feed = $cont->feed->entry;
if(count($feed)):
	foreach($feed as $item): // youtube start
		echo $item->title->{'$t'}
		echo $item->{'media$group'}->{'media$thumbnail'}[1]->{'url'}
		echo $item->{'media$group'}->{'media$description'}->{'$t'}
	endforeach;
endif;
 ?>