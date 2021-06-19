<?php

if (!function_exists('echo_var'))
{
  /**
   * @param mixed $var
   * @param bool $exit
   */
  function echo_var($var = '', $exit = false)
  {
    error_reporting(0);
    $var = check_var($var);
    echo "<pre style='text-align: initial; border-radius: 4px; border: 1px #0c2b45 solid; padding: 4px'>" . PHP_EOL . print_r($var, 1) . "</pre>" . PHP_EOL;
    if ($exit) exit();
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
  }
}
if (!function_exists('write_log'))
{
  /**
   * @param $var
   * @param string $filename
   * @param bool $rewrite
   */
  function write_log($var, $filename = '', $rewrite = false)
  {
    if (isset($_SERVER['REQUEST_URI']) && stripos($_SERVER['REQUEST_URI'], 'keepalive'))
    {
      $filename = 'keepalive.log';
    } else
    {
      $filename = empty($filename) ? __LOGS_DIR__ . '/general' . __TODAY__ . '.log' : $filename;
    }

    $directory = dirname($filename);
    $directory = (empty($directory) || $directory == '.') ? 'logs' : $directory;

    if (!file_exists($directory)) mkdir($directory, 0777, true);

    $data = (is_array($var) || is_object($var) || is_bool($var) || is_null($var)) ? convert_to_json(check_var($var), JSON_PRETTY_PRINT|JSON_FORCE_OBJECT) : $var;

    $print = '[' . date(DATE_ATOM) . ']' . $data;

    if ($rewrite)
    {
      file_put_contents($filename, $print . PHP_EOL);
    } else
    {
      file_put_contents($filename, $print . PHP_EOL, FILE_APPEND);
    }
  }
}

if (!function_exists('dump_file'))
{
  /**
   * @param mixed $var
   * @param string $filename
   * @param bool $rewrite
   * @return void
   */
  function dump_file($var, $filename = 'dump_file.log', $rewrite = false)
  {
    if (isset($_SERVER['REQUEST_URI']) && stripos($_SERVER['REQUEST_URI'], 'keepalive'))
    {
      $filename = 'keepalive.log';
    } else
    {
      $filename = empty($filename) ? 'dump_file.log' : $filename;
    }

    $print = print_r(check_var($var), true);

    if ($rewrite)
    {
      file_put_contents($filename, $print . PHP_EOL);
    } else
    {
      file_put_contents($filename, $print . PHP_EOL . str_repeat('=', 80) . PHP_EOL, FILE_APPEND);
    }
  }
}

if (!function_exists('check_var'))
{
  /**
   * @param mixed $var
   * @param bool $recursive
   * @return array|null
   */
  function check_var($var = null, $recursive = true)
  {
    $newVar = null;
    if (is_array($var))
    {
      if (count($var) > 0)
      {
        foreach ($var as $key => $value)
        {
          if (is_object($value))
          {
            $newVar[$key] = check_var($value);
          } elseif (is_array($value) && $recursive)
          {
            $newVar[$key] = check_var($value, false);
          } elseif (is_array($value) && !$recursive)
          {
            $newVar[$key] = 'array(' . count($value) . ')';
          } else
          {
            $newVar[$key] = $value;
          }
        }
      } else
      {
        $newVar = $var;
      }
    } elseif (is_object($var))
    {
      $classname  = get_class($var);
      $properties = get_class_vars($classname);
      $properties = (array) $var;
      $methods    = get_class_methods($var);
      foreach ($properties as $property => $value)
      {
        $newVar[$classname]['properties'][$property] = is_object($value) ? 'Object of class: ' . get_class($value) : (is_array($value) ? 'Array(' . count($value) . ')' : $value);
      }
      $newVar[$classname]['methods'] = $methods;
    } elseif (is_bool($var))
    {
      $newVar = ($var === false) ? 'false' : 'true';
    }else{
      $newVar = $var;
    }
    return $newVar;
  }
}

if (!function_exists('str_remove_spaces'))
{
  /**
   * @param $string
   * @param string $space
   * @return string
   */
  function str_remove_spaces($string, $space = ' ')
  {
    return trim(preg_replace('/\s+/', $space, $string));
  }
}

if (!function_exists('str_remove_accents'))
{
  /**
   * @param $string
   * @param bool $remove_virgulilla
   * @return mixed
   */
  function str_remove_accents($string, $remove_virgulilla = true)
  {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
    if ($remove_virgulilla)
    {
      array_push($a, 'Ñ', 'ñ');
      array_push($b, 'N', 'n');
    }
    return str_replace($a, $b, $string);
  }
}

if (!function_exists('to_number'))
{
  /**
   * @param $value
   * @param $dec
   * @return float
   */
  function to_number($value, $dec = 4)
  {
    return round((float)$value, $dec);
  }
}

if (!function_exists('hours_to_time'))
{
  /**
   * @param $num integer
   * @return string hh:mm:ss
   */
  function hours_to_time($num)
  {
    $hrs = floor($num);
    $dec = $num - $hrs;
    $min = ($dec * 60);
    return sprintf("%02d:%02d:00", $hrs, $min);
  }
}

if (!function_exists('min_to_time'))
{
  /**
   * @param $num integer
   * @return string hh:mm:ss
   */
  function min_to_time($num)
  {
    return hours_to_time($num / 60);
  }
}

if (!function_exists('shorten_string'))
{
  /**
   * @param $string
   * @return string
   */
  function shorten_string($string, $max = 80)
  {
    $stripped = trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($string))));
    if ($max > 0)
    {
      return strlen($stripped) <= $max ? $stripped : substr($stripped, 0, $max - 3) . '...';
    }
    return $stripped;
  }
}

if (!function_exists('flatten_string'))
{
  /**
   * @param $string
   * @return string
   */
  function flatten_string($string)
  {
    return shorten_string($string, -1);
  }
}

if (!function_exists('clean_html'))
{
  /**
   * @param $html
   * @return string
   */
  function clean_html($html)
  {
    $allowed_tags = '<html><body><div><p><a><ul><li><table><tr><th><td><span><h1><h2><h3><strong><b><br><img><style>';

    return strip_tags(html_entity_decode($html, ENT_QUOTES, 'UTF-8'), $allowed_tags);
  }
}

if (!function_exists('is_json'))
{
  function is_json($value)
  {
    if (is_string($value))
    {
      return ($value == 'null') ? true : !is_null(json_decode($value, true));
    } elseif (is_integer($value) || is_double($value) || is_float($value))
    {
      return true;
    } else
    {
      return false;
    }
  }
}

if (!function_exists('convert_to_json'))
{
  function convert_to_json($value, $options = 0, $depth = 512)
  {
    return empty($json_string = json_encode($value, $options = 0, $depth = 512)) ? json_last_error_msg() : $json_string;
  }
}

if (!function_exists('convert_from_json'))
{
  function convert_from_json($var)
  {
    return is_null($result = json_decode($var)) ? json_last_error_msg() : $result;
  }
}

if (!function_exists('array_to_table'))
{
  function array_to_table($result_array = array(), $table_attributes = '')
  {
    $headers = array_keys(array_values($result_array)[0]);
    $table = "<table {$table_attributes}><thead><tr>[header]</tr></thead><tbody>[body]</tbody></table>";
    $header = '';
    foreach ($headers as $idx => $col)
    {
      $header .= '<th>' . mb_strtoupper($col) . '</th>';
    }
    $body = '';
    foreach ($result_array as $index => $row)
    {
      $body .= "<tr>";
      foreach ($row as $col => $value)
      {
        $aling = is_numeric($value) ? "style='text-align: right;'" : '';
        $body .= "<td {$aling}>{$value}</td>";
      }
      $body .= "</tr>";
    }
    $table = str_replace('[header]', $header, $table);
    $table = str_replace('[body]', $body, $table);
    return $table;
  }
}

if(!function_exists('get_trace'))
{
  function get_trace()
  {
    $e = new Exception();
    return $e->getTraceAsString();
  }
}

if(!function_exists('url_to_bean'))
{
  function url_to_bean($bean)
  {
    $sugar_config = !empty($GLOBALS['sugar_config']) ? $GLOBALS['sugar_config'] : $GLOBALS['config'];
    $site_url = !empty($sugar_config['site_url_https']) ? rtrim($sugar_config['site_url_https'],'/') : rtrim($sugar_config['site_url'],'/');
    $url = "{$site_url}/index.php?module={$bean->module_name}&action=DetailView&record={$bean->id}";
    return $url;
  }
}

if(!function_exists('get_site_url'))
{
  function get_site_url()
  {
    $sugar_config = !empty($GLOBALS['sugar_config']) ? $GLOBALS['sugar_config'] : $GLOBALS['config'];
    $site_url = !empty($sugar_config['site_url']) ? rtrim($sugar_config['site_url'],'/') : '';
    if (empty($site_url))
    {
      $site_url = (!empty($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['SERVER_NAME'])) ? "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}" : "";
      $site_url = (!empty(__BASE_DIR__)) ? $site_url . __BASE_DIR__ : $site_url;
    }

    return $site_url;
  }
}

if(!function_exists('get_download_public_link'))
{
  function get_download_public_link($id, $nombre_archivo, $nombre_campo, $nombre_modulo, $solo_url = false)
  {
    $site_url = get_site_url();

    $file_url = "{$site_url}/index.php?entryPoint=public_download&id={$id}_{$nombre_campo}&type={$nombre_modulo}&time=".date("YmdHis");

    if ($solo_url == false)
    {
      $file_url = "<a href='{$file_url}' target='_blank'>$nombre_archivo</a>";
    }

    return $file_url;
  }
}

if(!function_exists('link_to_bean'))
{
  function link_to_bean(SugarBean $bean)
  {
    $href = url_to_bean($bean);
    $text = !empty($bean->fetched_row['name']) ? $bean->fetched_row['name'] : "{$bean->module_name} (sin nombre)";
    $link = "<a href='{$href}' target=\"_blank\">{$text}</a>";
    return $link;
  }
}

if(!function_exists('get_user_session_preferences'))
{
  function get_user_session_preferences($preference = null)
  {
    $preferences_list = array();
    if (!empty($GLOBALS['current_user']))
    {
      /** @var User $user */
      $user =& $GLOBALS['current_user'];
      if (!empty($_SESSION[$user->user_name.'_PREFERENCES']['global']))
      {
        $preferences_list = $_SESSION[$user->user_name.'_PREFERENCES']['global'];
      }
    }
    return empty($preference) ? $preferences_list : $preferences_list[$preference];
  }
}

if(!function_exists('separar_valores_de_lista'))
{
  function separar_valores_de_lista($string = '')
  {
    $string = trim($string,'^');
    return explode('^,^', $string);
  }
}

if(!function_exists('get_valores_de_lista'))
{
  function get_valores_de_lista(SugarBean $bean, $campo, $lista_valores = array())
  {
    $app_list_strings =& $GLOBALS['app_list_strings'];
    if (!empty($bean->$campo))
    {
      $lista_valores = !empty($lista_valores) ? $lista_valores : separar_valores_de_lista($bean->$campo);
      if(!empty($bean->field_defs[$campo]['options']) && !empty($app_list_strings[$bean->field_defs[$campo]['options']]))
      {
        $lista_opciones =& $app_list_strings[$bean->field_defs[$campo]['options']];
        foreach ($lista_valores as $key => $value)
        {
          $lista_valores[$value] = !empty($lista_opciones[$value]) ? $lista_opciones[$value] : $value;
          unset($lista_valores[$key]);
        }
      }
    }
    return $lista_valores;
  }
}

if(!function_exists('get_current_usercstm'))
{
  function get_current_usercstm()
  {
    $UserCstm = null;
    if (!empty($GLOBALS['current_user']))
    {
      $UserCstm = $GLOBALS['current_user'];
      /** @var UserCstm $user */
      $UserCstm = BeanFactory::getBean('UserCstm')->retrieve($UserCstm->id);
    }
    return $UserCstm;
  }
}

if(!function_exists('array_to_csv_file'))
{
  function array_to_csv_file($file_name, $resultados, $delimiter = ',', $enclosure = '"')
  {
    /** force download */
    header("Content-Type: text/plain; charset=utf-8");
    //header("Content-Type: application/force-download");
    //header("Content-Type: application/octet-stream");
    //header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=\"{$file_name}.csv\"");

    if (empty($resultados)) echo "No se encontraron registros con los parámetros ingresados.";

    if (!empty($resultados))
    {
      $output = fopen("php://output", "w");
      fputcsv($output, array_keys(reset($resultados)), $delimiter, $enclosure);
      foreach ($resultados as $row)
      {
        fputcsv($output, $row, $delimiter, $enclosure);
      }
      return fclose($output);
    }
    else
    {
      return null;
    }
  }
}

if (!function_exists('strtodate'))
{
  /**
   * @param string $string
   * @return DateTime|false
   */
  function strtodate($string = '')
  {
    /**
     * d y j	Día del mes, 2 dígitos con o sin ceros iniciales	01 a 31 o 1 a 31
     * m y n	Representación numérica de un mes, con o sin ceros iniciales	01 hasta 12 o 1 hasta 12
     * Y	Una representación numérica completa de un año, 4 dígitos	Ejemplos: 1999 o 2003
     */
    $arry = explode('-', $string);
    array_walk($arry, function ($val, $key){ if ($key >= 1) $arry[$key] = str_pad($val,2,'0',STR_PAD_LEFT); });
    $date = DateTime::createFromFormat('Y-m-d', $string);
    if (empty($date))
    {
      $date = DateTime::createFromFormat('Y-n-j', $string);
    }
    return $date;
  }
}

if (!function_exists('datetime_from_user_to_db_tz'))
{
  /**
   * @param string $date_string
   * @param string $format
   * @return SugarDateTime|null
   */
  function datetime_from_user_to_db_tz($date_string = '', $format = 'Y-m-d H:i')
  {
    $date = null;
    /** @var TimeDate $timedate */
    $timedate =& $GLOBALS['timedate'];
    if(is_object($timedate))
    {
      try {
        $date = SugarDateTime::createFromFormat($format, $date_string, new DateTimeZone($timedate->userTimezone()));
        $date->setTimezone(new DateTimeZone("UTC"));
      } catch (Exception $e) {
        $GLOBALS['log']->error("datetime_from_user_to_db_tz: Conversion of $date exception: {$e->getMessage()}");
      }
    }
    return $date;
  }
}

if (!function_exists('datetime_from_db_to_user_tz'))
{
  /**
   * @param string $date_string
   * @return SugarDateTime|null
   */
  function datetime_from_db_to_user_tz($date_string = '')
  {
    $date = null;
    /** @var TimeDate $timedate */
    $timedate =& $GLOBALS['timedate'];
    if(is_object($timedate))
    {
      try {
        $date = SugarDateTime::createFromFormat($timedate::DB_DATETIME_FORMAT, $date_string, new DateTimeZone("UTC"));
        $date->setTimezone(new DateTimeZone($timedate->userTimezone()));
      } catch (Exception $e) {
        $GLOBALS['log']->error("datetime_from_db_to_user_tz: Conversion of $date from DB format failed: {$e->getMessage()}");
        return null;
      }
    }
    return $date;
  }
}

if (!function_exists('gen_uuid'))
{
  function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }
}

if (!function_exists('get_request'))
{
  function get_request()
  {
    $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
    return [
      'method' => $_SERVER['REQUEST_METHOD'],
      'url' => get_site_url(),
      'uri' => str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']),
      'query' => $_SERVER['QUERY_STRING'],
      'script' => $_SERVER['SCRIPT_NAME'],
      'headers' => $headers,
      'body' => $_REQUEST,
      'files' => $_FILES
    ];
  }
}