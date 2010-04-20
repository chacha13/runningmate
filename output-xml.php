<?php
session_start();

$connection = mysql_connect ("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

  function parseToXML($htmlStr) {
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
  } 

  // Select all the rows in the markers table
  $query = "SELECT lat, lng, DATE_FORMAT(datetime,
  '%W %M %D, %Y %T') AS datetime FROM markers WHERE 1";
  $result = mysql_query($query);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

header("Content-type: text/xml");

  // Start XML file, echo parent node
  echo "<markers>\n";

  // Iterate through the rows, printing XML nodes for each
  while ($row = @mysql_fetch_assoc($result)){
    // ADD TO XML DOCUMENT NODE
    echo '<marker ';
    echo 'lat="' . $row['lat'] . '" ';
    echo 'lng="' . $row['lng'] . '" ';
    echo 'datetime="' . $row['datetime'] . '" ';
    echo "/>\n";
  }

  // End XML file
  echo '</markers>';

  // Free up the resources
  mysql_free_result ($result);

  // Close the database connection
  mysql_close();

?>