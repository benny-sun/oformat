<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/21
 * Time: 上午 10:17
 */

class Image
{

    protected $width_orig, $height_orig, $ratio_orig, $image_orig, $image_new, $mime, $src, $dir;

    protected $filename = 'default.jpg';

    protected static $pattern = '/"|\\\\|<|>|\*|\/|:|\?|\|/';

    public function __construct($image)
    {

        if ($this->isImage($image)) {

            $this->image_orig = $image;

            $this->getImageInfo();

        } else {

            throw new Exception('限 jpeg, png, gif 格式');

        }

    }

    private function isImage($image)
    {

        if (! file_exists($image)) throw new Exception('圖片不存在');

        $this->mime = mime_content_type($image);

        $mime_image = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($this->mime, $mime_image)) {
            return true;
        }

        return false;

    }

    private function getImageInfo()
    {

        $info = getimagesize($this->image_orig);

        list($width_orig, $height_orig, $type) = $info;

        $type =  image_type_to_extension($type, false);

        $data = "imagecreatefrom{$type}";

        $this->src = $data($this->image_orig);

        $this->width_orig = $width_orig;

        $this->height_orig = $height_orig;

        $this->ratio_orig = $width_orig / $height_orig;

    }

    public function resize($width, $height)
    {

        $this->image_new = imagecreatetruecolor($width, $height);

        imagecopyresampled($this->image_new, $this->src, 0, 0, 0, 0, $width, $height, $this->width_orig, $this->height_orig);

        return $this;
        
    }

    public function ratio_resize($width, $height)
    {

        if ($width/$height > $this->ratio_orig) {
            $width = $height * $this->ratio_orig;
        } else {
            $height = $width / $this->ratio_orig;
        }

        $this->image_new = imagecreatetruecolor($width, $height);

        imagecopyresampled($this->image_new, $this->src, 0, 0, 0, 0, $width, $height, $this->width_orig, $this->height_orig);

        return $this;

    }

    public function setDir($dir)
    {
        $this->dir = '';
        $parts = explode('/', $dir);
        foreach($parts as $part){
            $this->dir .= "$part/";
            if(!is_dir($this->dir)) mkdir($this->dir);
        }

        return $this;
    }

    public function setName($name)
    {

        $this->filename = preg_replace(static::$pattern, ' ', $name);

        return $this;

    }

    private function getFinalOutput()
    {
        return $this->dir . $this->filename;
    }

    public function saveJPG()
    {
        return imagejpeg($this->image_new, $this->getFinalOutput(), '100');
    }

    public function savePNG()
    {
        return imagepng($this->image_new, 'small3.png');
    }

    function __destruct()
    {
        imagedestroy($this->image_new);
    }
}