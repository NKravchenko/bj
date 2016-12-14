<?php
namespace Jimm\lib;

use Imagick;

class ImageHandler
{
    private $pathToImages;
    private $pathToThumbs;

    function __construct($pathToImages, $pathToThumbs)
    {
        $this->pathToImages = $pathToImages;
        $this->pathToThumbs = $pathToThumbs;
    }

    /**
     * @param array $uploadedFile
     * @param array $params ['image'=>['width' => 320, 'height' =>200], 'thumb'=>['width' => 50, 'height' =>50]]
     *
     * @return string
     */
    public function uploadHandle(
        array $uploadedFile, array $params
    ) {
        $uplExt = pathinfo($uploadedFile["name"], PATHINFO_EXTENSION);

        //сгенерим имя для хранения
        $fileName = md5($uploadedFile['tmp_name'] . uniqid());

        $im = new Imagick();
        $im->readImage($uploadedFile['tmp_name']);

        $geometry = $im->getimagegeometry();
        if ($params['image']['width'] < $geometry['width'] || $params['image']['height'] < $geometry['height']
        ) {
            //resize
            $im->adaptiveResizeImage(
               $params['image']['width'],
               $params['image']['height'],
               true //bestfit
            );
        }

        $im->writeimage("{$this->pathToImages}/{$fileName}.{$uplExt}");

        //сделаем тумбочку нужного размера
        $im->cropThumbnailImage($params['thumb']['width'], $params['thumb']['height']);

        $im->writeImage("{$this->pathToThumbs}/{$fileName}.{$uplExt}");
        $im->destroy();

        return "{$fileName}.{$uplExt}";
    }
}
