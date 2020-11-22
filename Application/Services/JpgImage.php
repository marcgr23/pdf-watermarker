<?php

class JpgImage implements ImagePrepareInterface {
    private $dir;
    private $file;
    const EXT = '.jpg';

    public function __construct($file) {
        $this->dir = sys_get_temp_dir() . '/' . uniqid();
        $this->file = $file;
    }

    public function doPrepare() : string {
        $path =   $this->dir. self::EXT;
        $image = imagecreatefromjpeg($this->file);
        imageinterlace($image,false);
        imagejpeg($image, $path);
        imagedestroy($image);

        return $path;
    }
}