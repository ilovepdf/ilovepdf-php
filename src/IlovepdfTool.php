<?php
/**
 * Created by PhpStorm.
 * User: aleixcabistany
 * Date: 17/3/17
 * Time: 11:46
 */

namespace Ilovepdf;


class IlovepdfTool
{
    public static function rand_sha1(int $length): string
    {
        $max = ceil($length / 40);
        $random = '';
        for ($i = 0; $i < $max; $i++) {
            $random .= sha1(microtime(true) . mt_rand(10000, 90000));
        }
        return substr($random, 0, $length);
    }

    public static function rand_md5(int $length): string
    {
        $max = ceil($length / 32);
        $random = '';
        for ($i = 0; $i < $max; $i++) {
            $random .= md5(microtime(true) . mt_rand(10000, 90000));
        }
        return substr($random, 0, $length);
    }
}