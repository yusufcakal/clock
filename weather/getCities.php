<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Get City</title>
  </head>
  <body>

    <?php

      $rows = array();
      $db = new PDO("mysql:host=rdbms.strato.de;dbname=DB2596576;charset=utf8", "U2596576", "yusuf341996");

      if ($db) {
        $query = $db->query("SELECT * FROM weather", PDO::FETCH_ASSOC);
         if ( $query->rowCount() ){
           foreach( $query as $row ){
             $rows[] = ['plate' => $row['id'],
                       'city' => $row['name'],
                       //'link_name' => $row['link_name'],
                       'image' => $row['image']
                     ];

           }
           header('Content-Type: application/json');
           echo json_encode(array('cities' => $rows));
         }
      }

    ?>

  </body>
</html>
