<?php

include_once( dirname(__FILE__) . '/../Interfaces/ImagePrepareInterface.php');

class SetupPngImageService implements ImagePrepareInterface {
    private $dir;
    private $file;
    const EXT = '.png';

    public function __construct($file) {
        $this->dir = sys_get_temp_dir() . '/' . uniqid();
        $this->file = $file;
    }

    public function doPrepare() : string {
        $path = $this->dir. self::EXT;
        $image = imagecreatefrompng($this->file);
        imageinterlace($image,false);
        imagesavealpha($image,true);
        imagepng($image, $path);
        imagedestroy($image);
        
        return $path;
    }
}