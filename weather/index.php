<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Weather Api</title>
	</head>
	<body>

		<?php

			$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; // get url
			$parameters = explode("/", $url);
			$plate = $parameters[1];

			function curlFunc($url)
		    {
		        $cd   = curl_init();
		        curl_setopt($cd, CURLOPT_URL, $url);
		        curl_setopt($cd, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt($cd, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		        curl_setopt($cd, CURLOPT_REFERER, 'http://www.google.com.tr/');
		        $data = curl_exec($cd);
		        curl_close($cd);
		        return $data;
		    }

		    function search($first, $last, $content){
		        $query='#'.$first.'(.*?)'.$last.'#s';
		        @preg_match_all($query,$content,$cont);
		        return @$cont;
		    }

				$detail = array();

				$db = new PDO("mysql:host=rdbms.strato.de;dbname=DB2596576;charset=utf8", "U2596576", "yusuf341996");
				if ($db) {
					$query = $db->query("SELECT * FROM weather WHERE id = $plate", PDO::FETCH_ASSOC);
					if ( $query->rowCount() ){
							 foreach( $query as $row ){
								 		$city = $row['link_name'];
										$url = "http://www.hurriyet.com.tr/hava-durumu/".$city;
										$content=curlFunc($url);
										$todayDegree = search('<div class="tdy-c">', '</div>', $content);
                    $todayDegree = explode(">",substr($todayDegree[0][0],0, strlen($todayDegree[0][0])-33));
                    $todayDegree = $todayDegree[1];
                    $nightDegree = search('<em>', '</em>', $content);
                    $nightDegree = substr($nightDegree[0][0],4, strlen($nightDegree[0][0])-35);
                    $image = search('<div class="met-ico">', '" alt="" />', $content);
										$image = substr($image[0][0],85, strlen($image[0][0])-96);
                    $status = search('<div class="met-ico-i">', '</div>', $content);
                    $status = substr($status[0][0],23,strlen($status[0][0])-29);

                    $otherDates = search('<div class="d1">', '</div>', $content);
										$otherDays = search('<div class="d2">', '</div>', $content);
										$otherStatus = search('<div class="info">', '</div>', $content);
										$otherImages = search('<div class="di">', '" width="120"', $content);
										$otherDegrees = search('<strong>', '</strong>', $content);

										for ($i=0; $i < 10; $i++) {
											 $otherDegree[] = [
												 $i => substr($otherDegrees[0][$i+2], 8, strlen($otherDegrees[0][$i+2])-17)
											 ];
										}

										$j = 0;
										for ($i=0; $i < 8 ; $i+=2) {
											if ($j >= 4) {
												break;
											}else{
												$otherDegrees[$j][$j] = $otherDegree[$i][$i]. "/" . $otherDegree[$i+1][$i+1];
												$j++;
											}
										}

										$other = array();
										for ($i=0; $i < 4; $i++) {
											$other[] = [
												'date' => substr($otherDates[0][$i], 16, strlen($otherDates[0][$i])-22),
												'day' => substr($otherDays[0][$i], 16, strlen($otherDays[0][$i])-22),
												'status' => substr($otherStatus[0][$i], 18, strlen($otherStatus[0][$i])-24),
												'image' => substr($otherImages[0][$i], 26, strlen($otherImages[0][$i])-39),
												'degrees' => $otherDegrees[$i][$i]
											];
										}

										$detail[] = [
											//'source' => $url
											'city' => $row['name'],
                      'degree' => $todayDegree,
                      'nightDegree' => $nightDegree,
                      'image' => $image,
                      'status' => $status,
											'otherDays' => $other
										];

							 }
							 header('Content-Type: application/json');
		           echo json_encode(array('detail' => $detail));
					}
				}else{
					echo "Veritabanı Bağlantısı Kurulamadı.";
				}

				?>

	</body>
</html>
