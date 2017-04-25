<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/5
 * Time: 下午 05:25
 */

//namespace Libreoffice;

class Libreoffice
{

    public static function convert($formatType, $outputPath, $inputFile)
    {
        $command = 'soffice --headless --convert-to %s --outdir %s %s';
        $command = sprintf($command, $formatType, $outputPath, $inputFile);
        system($command, $output);

        return $output;
    }

    public static function convertToJPG($outputPath, $inputFile)
    {
        return self::convert('jpg', $outputPath, $inputFile);
    }

    public static function convertToPDF($outputPath, $inputFile)
    {
        return self::convert('pdf', $outputPath, $inputFile);
    }

}