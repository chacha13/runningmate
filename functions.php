<?

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

function toLink($text){
        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1">\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1">\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2">\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
        '<a href="mailto:\\1">\\1</a>', $text);
        return $text;
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


?>