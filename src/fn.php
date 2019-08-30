<?php

function getDateBD($date) {
    $aux = explode('-', $date);
    return $aux[2].'-'.$aux[1].'-'.$aux[0];
}

function getDateToForm($date) {
    $aux = explode('-', $date);
    return $aux[2].'/'.$aux[1].'/'.$aux[0];
}

function getDateMonthToForm($date) {
    $aux = explode('-', $date);
    return $aux[1].'/'.$aux[0];
}

function getDateHourBD( $d ) {
    $aux = explode(' ', $d);
    $aux2 = explode('-', $aux[0]);
    return $aux2[2].'-'.$aux2[1].'-'.$aux2[0].' '.$aux[1];
}

function getFullDate($date) { 
    $date = strtotime($date);
    $week_days = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    $aux_d = date("w", $date);
    $day_w = $week_days[$aux_d];
    
    $day = date("d", $date);
    
    $aux_m = date("n", $date);
    $month = $months[$aux_m-1];

    $year = date("Y", $date);
    $date = $day_w.", ".$day." de ".$month." de ".$year;
    return $date;
}

function getMonthDate($date) { 
    $date = strtotime($date);
    $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    $aux_m = date("n", $date);
    $month = $months[$aux_m-1];

    $year = date("Y", $date);
    $date = $month." de ".$year;
    return $date;
}

function getMonth($date) {
	$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return $months[$date-1];
}

function setDateBD($date) {
    $aux = explode('/', $date);
    return $aux[2].'-'.$aux[1].'-'.$aux[0];
}

function getExtension($e) {
    switch (strtolower($e)):
        // Image
        case "gif":     $ext = "photo"; break;
        case "jpg":     $ext = "photo"; break;
        case "jpeg":    $ext = "photo"; break;
        case "png":     $ext = "photo"; break;
        // Video
        case "wmv":     $ext = "movie"; break;
        case "mov":     $ext = "movie"; break;
        case "mp4":     $ext = "movie"; break;
        case "avi":     $ext = "movie"; break;
        // Zipped
        case "rar":     $ext = "zip"; break;
        case "zip":     $ext = "zip"; break;
        // Excel
        case "xls":     $ext = "excel"; break;
        case "xlsx":    $ext = "excel"; break;
        case "csv":     $ext = "excel"; break;
        // Powerpoint
        case "ppt":     $ext = "powerpoint"; break;
        case "pptx":    $ext = "powerpoint"; break;
        // AReader
        case "pdf":     $ext = "pdf"; break;
        // Word
        case "doc":     $ext = "word"; break;
        case "docx":    $ext = "word"; break;
        case "rtf":     $ext = "word"; break;
        // Other
        default:        $ext = "file"; break;
    endswitch;
    
    return $ext;
}

function getColorExt($e) {
    switch (strtolower($e)):
        // Image
        case "gif":     $ext = "navy"; break;
        case "jpg":     $ext = "navy"; break;
        case "jpeg":    $ext = "navy"; break;
        case "png":     $ext = "navy"; break;
        // Video
        case "wmv":     $ext = "navy"; break;
        case "mov":     $ext = "navy"; break;
        case "mp4":     $ext = "navy"; break;
        case "avi":     $ext = "navy"; break;
        // Zipped
        case "rar":     $ext = "purple"; break;
        case "zip":     $ext = "purple"; break;
        // Excel
        case "xls":     $ext = "green"; break;
        case "xlsx":    $ext = "green"; break;
        case "csv":     $ext = "green"; break;
        // Powerpoint
        case "ppt":     $ext = "orange"; break;
        case "pptx":    $ext = "orange"; break;
        // AReader
        case "pdf":     $ext = "red"; break;
        // Word
        case "doc":     $ext = "blue"; break;
        case "docx":    $ext = "blue"; break;
        case "rtf":     $ext = "blue"; break;
        // Other
        default:        $ext = "gray"; break;
    endswitch;
    
    return $ext;
}

function getFilesize($f) {
    $decimals = 2;
    $bytes = filesize($f);
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
}

function removeAccents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 
      'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 
      'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 
      'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 
      'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 
      'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 
      'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 
      'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 
      'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 
      'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 
      'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 
      'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή', 'º', '°');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 
      'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 
      'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 
      'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 
      'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 
      'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 
      'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 
      'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 
      'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 
      'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 
      'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 
      'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η', 'o', 'o');
  return str_replace($a, $b, $str);
}