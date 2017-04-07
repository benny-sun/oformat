<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/7
 * Time: 下午 05:15
 */

namespace GhostScript;

class GhostScript
{
    public static function convert($outputDir, $formatType, $quality, $input)
    {
        $command = 'gs -o %spage_%%03d.jpg -sDEVICE=%s -dJPEGQ=%d %s';
        $command = sprintf($command, $outputDir, $formatType, $quality, $input);
        system($command, $output);

        return $output;
    }

    public static function convertToJPG($outputDir, $quality, $input)
    {
        return self::convert($outputDir,'jpeg', $quality, $input);
    }
}