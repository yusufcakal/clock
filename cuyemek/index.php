<?php


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

	  $contentNames = array();
	  $tabldot = array();

	  $url =  "http://www.cumhuriyet.edu.tr/yemeklistesi.php";
	  $content=curlFunc($url);
	  $date = search('<td align="left" width="60" >', '</td>', $content);
	  $date = substr($date[0][0], 29, strlen($date[0][0])-34);
	  $eat = search('<td align="left" >', '</td>', $content);
	  $eat = substr($eat[0][0], 18, strlen($eat[0][0])-23);
	  $tabldot = explode('-',$eat);

	  $tabldot = [
	  	  'eat1' => iconv('iso-8859-9','utf-8',$tabldot[0]),
	      'eat2' => iconv('iso-8859-9','utf-8',$tabldot[1]),
	      'eat3' => iconv('iso-8859-9','utf-8',$tabldot[2]),
	      'eat4' => iconv('iso-8859-9','utf-8',explode("(", $tabldot[3])[0]) // Kapalı yazısı için
	  ];

	  $eat = search('<td align="left">', '</td>', $content);
	  $eat = substr($eat[0][0], 17, strlen($eat[0][0])-22);
	  $lokanta = explode('-',$eat);

	  $lokanta = [
				'eat1' => iconv('iso-8859-9','utf-8',$lokanta[0]),
				'eat2' => iconv('iso-8859-9','utf-8',$lokanta[1]),
		        'eat3' => iconv('iso-8859-9','utf-8',$lokanta[2]),
		        'eat4' => iconv('iso-8859-9','utf-8',$lokanta[3])
	  		]; 

	  $eat = search('<td align="left">', '</td>', $content);
	  $eat = substr($eat[0][1], 17, strlen($eat[0][1])-22);
	  $cok_amacli_salon = explode('-',$eat);

	  $cok_amacli_salon = [
				'eat1' => iconv('iso-8859-9','utf-8',$cok_amacli_salon[0]),
				'eat2' => iconv('iso-8859-9','utf-8',$cok_amacli_salon[1]),
		        'eat3' => iconv('iso-8859-9','utf-8',$cok_amacli_salon[2]),
		        'eat4' => iconv('iso-8859-9','utf-8',$cok_amacli_salon[3]),
		        'eat5' => iconv('iso-8859-9','utf-8',$cok_amacli_salon[4])
	  		];

	  $contentNames = array($tabldot, $lokanta, $cok_amacli_salon);	

	  header('Content-Type: application/json; charset=utf-8');
      echo json_encode(array('content' => $contentNames));

?>