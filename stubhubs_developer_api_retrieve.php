<!DOCTYPE html>
<html>

<head>
    <title>Stubhubs Developer API Retrieve</title>
</head>

<body>

<?php 		 
$apicall = 	"http://publicfeed.stubhub.com/listingCatalog/select?"
			."q=ticket&"
			//."sort=event_date_time_local+asc&"
			."rows=20&"
			."start=0&"
			."wt=json&"
			."indent=on&"
			//."fl=active"
			."sort=totalTickets+desc&"
			."fq=totalTickets:%5B1%20TO%20*%5D&"
			."fq=active:1&"
			."fq=city:dublin&"
			."fq=country:IE";
					 
$debug = 1; if ($debug) {print "GET call = $apicall <br><br>";}   //$resp = simplexml_load_file($apicall,SimpleXMLElement,LIBXML_DTDATTR);	
$contents = file_get_contents($apicall); $contents = utf8_encode($contents); $resp2 = json_decode($contents); 

	foreach ($resp2->response->docs as $count_this) {$counter[] = $count_this;} $array_count = count($counter); echo "<br>"; $num_range = range(0, $array_count-1);echo "<br>";
	function gbp_to_eur ($cur) {return "&euro; ".round($cur * 1.25,-1);}
	foreach ($num_range as $num) {
		
			$seo_title = $resp2->response->docs[$num]->seo_title;
			$city = $resp2->response->docs[$num]->city;
			$event = $resp2->response->docs[$num]->act_primary;
			$name_primary = $resp2->response->docs[$num]->name_primary;
			$currency_code = $resp2->response->docs[$num]->currency_code;
			$minPrice = $resp2->response->docs[$num]->minPrice;
			$maxPrice = $resp2->response->docs[$num]->maxPrice;
			$totalTickets = $resp2->response->docs[$num]->totalTickets;


									echo "$seo_title - ". gbp_to_eur($minPrice). "<br>"
									."Event Id: ".$resp2->response->docs[$num]->event_id."<br>"
									."Primary: $event<br>"
									."City: $city <br>"
									."Date: ".$resp2->response->docs[$num]->event_date_local."<br>"
									."keywords: "; $keywords = array($city,$event,$name_primary); foreach($keywords as $keyword) {echo "#$keyword ";} echo "<br>";
									echo "<br>";$bob = explode("|",$resp2->response->docs[$num]->zoneDescriptions);$e = $bob[rand(1,count($bob)-1)]; if (!$e){$e="Standing";}echo $e."<br><br>";
									echo "Total Tickets: $totalTickets <br>"
									."Min: $currency_code $minPrice <br>"
									."Max: $currency_code $maxPrice <br>"
									."<br><br>";	
			
			}


?>
</body>
</html>
