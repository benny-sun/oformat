<?php
/**
 * Created by PhpStorm.
 * User: Haogood
 * Date: 2017/4/11
 * Time: 下午 01:38
 */

//namespace HTML;

class HTML
{
    protected $dir = '';

    protected $file_name = 'default';

    protected $url, $http_code, $http_contents;

    protected $file_name_array = array();

    protected $isError = true;

    protected static $pattern = '/"|\\\\|<|>|\*|\/|:|\?|\|/';

    private $curl_options = [
        CURLOPT_HEADER => false,
        CURLOPT_NOBODY => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ];

    protected static $code_array = [
        0 => 'net::ERR_NAME_NOT_RESOLVED',
        //Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        //Successful 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        //Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        //Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        451 => 'Unavailable For Legal Reasons',
        499 => 'Client Closed Request',
        //Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];

    public function __construct($url)
    {
        $this->url = $url;

        if (is_array($url)) {
            if ($this->validArray($url)) $this->getUrlInfoBatch($this->url);
        } else {
            $this->getUrlInfo($url);
        }

//        $this->writeLog($this->http_code);
    }

    private function validArray($url)   //for batch
    {

        switch ($this->get_array_depth($url)) {
            case 1:
                return true;
            case 2:
                if (sizeof($url[0]) != sizeof($url[1])) {
                    throw new Exception('陣列長度不一致');
                }
                list($this->url, $this->file_name_array) = $url;

                return true;
            default:
                throw new Exception('上限為二維陣列');
        }

    }

    private function get_array_depth(array $array)  //for batch
    {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->get_array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
    
    private function getUrlInfo($url)
    {
        $this->http_code = $this->getHttpCode($url);
        if ($this->checkUrlCorrect($this->http_code)) $this->isError = false;
    }

    private function getUrlInfoBatch($url_array)    //for batch
    {

        list($this->http_code, $this->http_contents) = $this->getHttpCodeBatch($url_array);

        if (sizeof($this->file_name_array) > 0) $this->replace_array_key($this->http_code);

        $this->checkUrlCorrectBatch($this->http_code);

    }

    private function checkUrlCorrect($http_code)
    {
        switch ($http_code) {
            case 200:
                return true;
            default:
                return false;
        }
    }

    private function checkUrlCorrectBatch($http_code_arr)   //for batch
    {

        foreach ($http_code_arr as $key => $value) {

            $this->url = $key;

            if ($value != 200) {
                unset($this->http_contents[$key], $this->file_name_array[$key]);
            }

        }

    }

    private function replace_array_key(array $http_code_arr)    //for batch
    {
        $i=0;
        foreach ($http_code_arr as $key => $value) {
            $this->file_name_array[$key] = preg_replace(static::$pattern, ' ',$this->file_name_array[$i]);
            unset($this->file_name_array[$i]);
            $i++;
        }
    }

    private function getHttpCode($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, $this->curl_options);
        $output = curl_exec($ch);
        $this->http_contents = $output;
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code;
    }

    private function getHttpCodeBatch($url_arr)    //for batch
    {
        $mh = curl_multi_init();
        $ch_array = array();
        foreach ($url_arr as $i => $row) {
            $ch_array[$i] = curl_init($row);
            curl_setopt_array($ch_array[$i], $this->curl_options);
            curl_multi_add_handle($mh, $ch_array[$i]);
        }

        $running = NULL;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = array();
        $code = array();
        foreach ($url_arr as $i => $row) {
            $code[$row] = curl_getinfo($ch_array[$i],CURLINFO_HTTP_CODE);
            $res[$row] = curl_multi_getcontent($ch_array[$i]);
            curl_multi_remove_handle($mh, $ch_array[$i]);
        }
        curl_multi_close($mh);

        return [$code, $res];
    }

    private function writeLog($http_code) {
        if (is_array($http_code)) {
            foreach ($http_code as $key => $value) {
                $status = 'OK';
                if ($value != 200) $status = 'ER';
                $this->setErrorLog($status, $value, static::$code_array[$value], $key);
            }
        } else {
            $status = 'OK';
            if ($http_code != 200) $status = 'ER';
            $this->setErrorLog($status, $http_code, static::$code_array[$http_code], $this->url);
        }
    }

    private function setErrorLog($status, $code, $msg, $url)
    {
        $time = date("Y-m-d H:i:s");
        $txt = sprintf("[%s] [%s] [%d %s] %s\n", $status, $time, $code, $msg, $url);
        file_put_contents('log.txt', $txt, FILE_APPEND);
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

    public function setFileName($file_name)
    {
        $this->file_name = preg_replace(static::$pattern, ' ',$file_name);

        return $this;
    }

    private function saveBatch()
    {
        $i = 1;
        if (sizeof($this->file_name_array) > 0) {   //用自訂檔名
            foreach ($this->http_contents as $key => $content) {
                $path = sprintf('%s(%004d)%s', $this->dir, $i, $this->file_name_array[$key]);
                file_put_contents($path, $content);
                $i++;
            }
        } else {
            foreach ($this->http_contents as $key => $content) {    //用預設檔名
                $path = sprintf('%s%004d-%s', $this->dir, $i, $this->file_name);
                file_put_contents($path, $content);
                $i++;
            }
        }
    }

    private function saveSingle()
    {
        $path = sprintf('%s%s', $this->dir, $this->file_name);
        file_put_contents($path, $this->http_contents);

        return $this->http_code;
    }

    public function save()
    {
        if (is_array($this->http_contents)) {
            $this->saveBatch();
        } else {
            return $this->saveSingle();
        }
    }
}