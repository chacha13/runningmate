<?

function make_thumb($src,$dest,$desired_width)
{

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	
	/* copy source image at a resized size */
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image,$dest);
}

function createRandomPassword() {
   $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;

        $i++;
    }
    return $pass;
}

function encode5t($str)
{
  for($i=0; $i<5;$i++)
  {
    $str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
  }
  return $str;
}

//function to decrypt the string
function decode5t($str)
{
  for($i=0; $i<5;$i++)
  {
    $str=base64_decode(strrev($str)); //apply base64 first and then reverse the string}
  }
  return $str;
}



function time_stamp($session_time) {
    $session_time ="1264326122";

    $time_difference = time() - $session_time ;

    $seconds    = $time_difference ;
    // Seconds
    if($seconds <= 60) {
        return "$seconds seconds ago";
    }

    $minutes    = round($time_difference / 60 );
    //Minutes
    if($minutes <= 60) {
        if($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    }
   
    $hours      = round($time_difference / 3600 );
    //Hours
    if($hours <= 24) {
        if($hours == 1) {
            return "one hour ago";
        } else {
            return "$hours hours ago";
        }
    }
   
    $days      = round($time_difference / 86400 );
    //Days
    if($days <= 7) {
        if($days == 1) {
            return "one day ago";
        } else {
            return "$days days ago";
        }
    }
   
    $weeks      = round($time_difference / 604800 );
    //Weeks
    if($weeks <= 4) {
        if($weeks == 1) {
            return "one week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
   
    $months    = round($time_difference / 2419200 );
    //Months
    if($months <= 12) {
        if($months==1) {
            return "one month ago";
        } else {
            return "$months months ago";
        }
    }
   
    $years      = round($time_difference / 29030400 );
    //Years
    if($years==1) {
        return "one year ago";
    } else {
        return "$years years ago";
    }

}

//error_reporting (E_ALL ^ E_NOTICE);


?>