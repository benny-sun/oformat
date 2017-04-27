<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/27
 * Time: 下午 01:21
 */
class Rotate
{

    private static $image, $mime, $filename;

    private static $path = '.';

    private static $_instance = null;

    /* 1 => file not exists, 2 => not jpeg file, 3 => file path not exists */
    private static $error_code = null;

    const orien_map = [
        1 => 0,
        3 => 180,
        6 => 90,
        8 => 270,
    ];

    const pattern = '/"|\\\\|<|>|\*|\/|:|\?|\|/';

    function __construct()
    {

        self::$filename = self::$image;

        if (! file_exists(self::$image)) {

            self::$error_code = 1;

        } else {

            self::$mime = self::getMIME(self::$image);

            if (self::$mime != 'image/jpeg') self::$error_code = 2;

        }

    }

    public static function Image($image)
    {

        self::$image = $image;

        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    private static function getMIME($image)
    {

        $mime = mime_content_type($image);

        return $mime;

    }

    private static function getOrientation()
    {

        $ifd0 = @read_exif_data(self::$image ,'IFD0' ,0);

        $orientation = $ifd0['Orientation'];

        return $orientation;

    }

    private static function getAngle() {

        $angle = null;

        if (! is_null(self::getOrientation()))
            $angle = self::orien_map[self::getOrientation()];

        return $angle;

    }

    private static function makeRotate()
    {

        $src = imagecreatefromjpeg(self::$image);

        $angle = self::getAngle() * (-1);

        $rotate = imagerotate($src, $angle, 0);

        $path = self::getPath(self::$filename);

        $filename = self::getFileName(self::$filename);

        imagejpeg($rotate, $path.'/'.$filename, 90);

        imagedestroy($rotate);

    }

    private static function getPath($filename)
    {

        $str = $filename;

        $last_slash = (strrpos($str, '/'));

        $path = '.';

        if (! $last_slash == 0) $path = substr($str, 0, $last_slash);

        return $path;

    }

    private static function getFileName($filename)
    {

        $str = $filename;

        $last_slash = (strrpos($str, '/'));

        $filename = substr($str, $last_slash);

        $filename = preg_replace(self::pattern, ' ', $filename);

        $filename = ltrim($filename, ' ');

        return $filename;

    }

    public function save($filename = null)
    {

        if (! is_null($filename)) {

            self::$filename = $filename;

            if (! is_dir(self::getPath($filename))) self::$error_code = 3;

        }

        if (is_null(self::$error_code)) {
            self::makeRotate();
        } else {
            return self::$error_code;
        }

    }

}