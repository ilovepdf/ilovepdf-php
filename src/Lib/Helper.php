<?php
namespace Ilovepdf;

class Helper{
  static function validateHexColor($hexFormat){
    return preg_match("^#[a-fA-F0-9]{6}$") === 1;
  }

    
  /**
   * namedSprintf
   *
   * @param string $str
   * @param array $args key-value array of strings
   * @return string
   * @link https://www.php.net/manual/es/function.vsprintf.php#119959
   * <code>
   *   $string = 'Hello %name!';
   *   $data = array(
   *    '%name' => 'John'
   *   ); 
   *  $formattedString = Helper::namedSprintf($string, $data);
   * </code>
   */
  static function namedSprintf($str, $args){
    return str_replace(array_keys($data), array_values($data), $string);
  }
}