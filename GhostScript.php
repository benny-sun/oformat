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
    public static function convert($outputDir, $formatType, $dpi, $quality, $input)
    {
        $command = 'gs -o %spage_%%03d.jpg -sDEVICE=%s -r%s -dJPEGQ=%d %s';
        $command = sprintf($command, $outputDir, $formatType, $dpi, $quality, $input);
        system($command, $output);

        return $output;
    }

    public static function convertToJPG($outputDir, $dpi, $quality, $input)
    {
        return self::convert($outputDir,'jpeg', $dpi, $quality, $input);
    }
}