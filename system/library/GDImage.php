<?php

define('TOP_LEFT', 0);
define('TOP_RIGHT', 1);
define('BOTTOM_LEFT', 3);
define('BOTTOM_RIGHT', 2);
define('CENTER', 4);

class GDImage
{

    private $image;
    private $raw;
    private $type;


    function __construct($src)
    {
        $data = getimagesize($src);
        $this->raw = $data;
        $this->type = explode('/', $data['mime'])[1];
        $fun = 'imagecreatefrom' . $this->type;
        if (function_exists($fun)) {
            $fun = new ReflectionFunction($fun);
            $this->image = $fun->invokeArgs(array($src));

        } else {
            throw new Exception('Image loading Failed at path '.$src);
        }


    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function getWidth()
    {
        return $this->raw[0];
    }

    public function getHeight()
    {
        return $this->raw[1];
    }

    public function getImage()
    {
        return $this->image;
    }


    public function resize($width_n = null, $height_n = null)
    {
        $wh_ratio = $this->getWidth() / $this->getHeight();                // ratio will use when one of above arg is null.

        $width_n = ($width_n == null) ? $height_n * $wh_ratio : $width_n;        //If new width is null
        $height_n = ($height_n == null) ? $width_n / $wh_ratio : $height_n;        // If new height is null

        $canves = imagecreatetruecolor($width_n, $height_n);
        imagecopyresampled($canves, $this->image, 0, 0, 0, 0, $width_n, $height_n, $this->getWidth(), $this->getHeight());

        $this->raw[1] = $height_n;
        $this->raw[0] = $width_n;

        $this->image = $canves;

    }

    public function insert(GDImage $image, $position = TOP_LEFT, $offx = 0, $offy = 0)
    {
        // Watermark position calculation
        $wh = $image->getHeight();
        $ww = $image->getWidth();

        $ch = $this->getHeight();
        $cw = $this->getWidth();

        $px = 0;
        $py = 0;

        switch ($position) {
            case TOP_LEFT:
                $px += $offx;
                $py += $offy;
                break;
            case TOP_RIGHT:
                $px += $cw - $ww - $offx;
                $py += $offy;
                break;
            case BOTTOM_LEFT:
                $px += $offx;
                $py += $ch - $wh - $offy;
                break;
            case BOTTOM_RIGHT:
                $px += $cw - $ww - $offx;
                $py += $ch - $wh - $offy;
                break;
            case CENTER:
                $px += $cw / 2 - $ww / 2 + $offx;
                $py += $ch / 2 - $wh / 2 + $offy;
                break;

            default:
                $px = 0;
                $py = 0;
                break;
        }

        $canves = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagecopy($canves, $this->image, 0, 0, 0, 0, $this->getWidth(), $this->getHeight());
        imagecopy($canves, $image->getImage(), $px, $py, 0, 0, $image->getWidth(), $image->getHeight());
        $this->image = $canves;

    }

    public function save($save_to)
    {
        $arg = array($this->image, $save_to);
        $func = 'image' . $this->type;
        if (function_exists($func)) {
            $fun = new ReflectionFunction($func);
            $fun->invokeArgs($arg);
        } else {
            throw new Exception("Image Save Failed");
        }
    }

}


?>