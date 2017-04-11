<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/11
 * Time: 下午 01:38
 */

namespace GenerateHTML;


class GenerateHTML
{
    protected $php_page = '';

    protected $file_name = 'default.html';

    public function __construct($php_page)
    {
        $this->php_page = $php_page;
    }

    public function setFileName($file_name)
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function saveHTML()
    {
        $content = file_get_contents($this->php_page);

        $fp = fopen($this->file_name,'w');

        fwrite($fp, $content);

        fclose($fp);
    }

    public function savePHPFile()
    {
        ob_start();

        include "$this->php_page";

        $content = ob_get_contents();

        $fp = fopen($this->file_name,'w');

        fwrite($fp, $content);

        fclose($fp);
    }
}