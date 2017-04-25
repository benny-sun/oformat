<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/7
 * Time: 下午 03:43
 */

namespace PDF2Image;

use PDF2Image\Exceptions\InvalidFormat;
use PDF2Image\Exceptions\PdfDoesNotExist;
use PDF2Image\Exceptions\PageDoesNotExist;

class PDF2Image
{
    protected $pdfFile;

    protected $resolution = 144;

    protected $width, $height;

    protected $outputFormat = '';

    protected $page = 1;

    protected $validOutputFormats = ['jpg', 'jpeg', 'png'];

    /**
     * @param string $pdfFile The path or url to the pdffile.
     *
     * @throws \PDF2Image\Exceptions\PdfDoesNotExist
     */
    public function __construct($pdfFile)
    {
        if (! filter_var($pdfFile, FILTER_VALIDATE_URL) && ! file_exists($pdfFile)) {
            throw new PdfDoesNotExist();
        }

        $this->pdfFile = $pdfFile;
    }

    /**
     * Set the raster resolution.
     *
     * @param int $resolution
     *
     * @return $this
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function resizeImage($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * Set the output format.
     *
     * @param string $outputFormat
     *
     * @return $this
     *
     * @throws \PDF2Image\Exceptions\InvalidFormat
     */
    public function setOutputFormat($outputFormat)
    {
        if (! $this->isValidOutputFormat($outputFormat)) {
            throw new InvalidFormat('Format '.$outputFormat.' is not supported');
        }

        $this->outputFormat = $outputFormat;

        return $this;
    }

    /**
     * Determine if the given format is a valid output format.
     *
     * @param $outputFormat
     *
     * @return bool
     */
    public function isValidOutputFormat($outputFormat)
    {
        return in_array($outputFormat, $this->validOutputFormats);
    }

    /**
     * Set the page number that should be rendered.
     *
     * @param int $page
     *
     * @return $this
     *
     * @throws \PDF2Image\Exceptions\PageDoesNotExist
     */
    public function setPage($page)
    {
        if ($page > $this->getNumberOfPages()) {
            throw new PageDoesNotExist('Page '.$page.' does not exist');
        }

        $this->page = $page;

        return $this;
    }

    /**
     * Get the number of pages in the pdf file.
     *
     * @return int
     */
    public function getNumberOfPages()
    {
        return (new \Imagick($this->pdfFile))->getNumberImages();
    }

    /**
     * Save the image to the given path.
     *
     * @param string $pathToImage
     *
     * @return bool
     */
    public function saveImage($pathToImage)
    {
        $imageData = $this->getImageData($pathToImage);

        return file_put_contents($pathToImage, $imageData) === false ? false : true;
    }

    /**
     * Save the file as images to the given directory.
     *
     * @param string $directory
     * @param string $prefix
     *
     * @return array $files the paths to the created images
     */
    public function saveAllPagesAsImages($directory, $prefix = '')
    {
        $numberOfPages = $this->getNumberOfPages();

        if ($numberOfPages === 0) {
            return [];
        }

        return array_map(function ($pageNumber) use ($directory, $prefix) {
            $this->setPage($pageNumber);

            $destination = "{$directory}/{$prefix}{$pageNumber}.{$this->outputFormat}";

            $this->saveImage($destination);

            return $destination;
        }, range(1, $numberOfPages));
    }

    /**
     * Return raw image data.
     *
     * @param string $pathToImage
     *
     * @return \Imagick
     */
    public function getImageData($pathToImage)
    {
        $imagick = new \Imagick();

        $imagick->setResolution($this->resolution, $this->resolution);

        $imagick->readImage(sprintf('%s[%s]', $this->pdfFile, $this->page - 1));

        if ($this->width == 0 || $this->height == 0) {
            $this->width = $imagick->getImageWidth();
            $this->height = $imagick->getImageHeight();
        }
        $imagick->resizeImage($this->width, $this->height,\Imagick::FILTER_LANCZOS, 1);

        $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);

        $imagick->setFormat($this->determineOutputFormat($pathToImage));

        return $imagick;
    }

    /**
     * Determine in which format the image must be rendered.
     *
     * @param $pathToImage
     *
     * @return string
     */
    protected function determineOutputFormat($pathToImage)
    {
        $outputFormat = pathinfo($pathToImage, PATHINFO_EXTENSION);

        if ($this->outputFormat != '') {
            $outputFormat = $this->outputFormat;
        }

        $outputFormat = strtolower($outputFormat);

        if (! $this->isValidOutputFormat($outputFormat)) {
            $outputFormat = 'jpg';
        }

        return $outputFormat;
    }
}