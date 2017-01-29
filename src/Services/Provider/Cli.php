<?php
/**
 * Created by PhpStorm.
 * User: tgostomski
 * Date: 29.01.17
 * Time: 07:43
 */

namespace Neusta\Hosts\Services\Provider;

/**
 * Class Cli
 * Passing by a php method for testing purposes.
 *
 * @codeCoverageIgnore
 * @package Neusta\Hosts\Services\Provider
 */
class Cli
{
    public static function passthruSsh($string)
    {
        return passthru("ssh " . $string);
    }
}