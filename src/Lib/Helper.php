<?php

namespace Ilovepdf\Lib;

class Helper
{
    static function validateHexColor(string $hexFormat): bool
    {
        return preg_match("/^#[a-fA-F0-9]{6}$/", $hexFormat) === 1;
    }


    /**
     * namedSprintf
     *
     * @param string $str
     * @param array $args key-value array of strings
     * @return string
     * @link https://www.php.net/manual/es/function.vsprintf.php#119959
     * <code>
     *   $str = 'Hello %name!';
     *   $args = array(
     *    '%name' => 'John'
     *   );
     *  $formattedString = Helper::namedSprintf($str, $args);
     * </code>
     */
    static function namedSprintf(string $str, array $args): string
    {
        return str_replace(array_keys($args), array_values($args), $str);
    }

    static function isValidColor(string $str): bool
    {
        return $str === 'transparent' || self::validateHexColor($str);
    }
}