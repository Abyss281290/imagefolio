<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yiqing
 * Date: 11-11-23
 * Time: 下午1:48
 * To change this template use File | Settings | File Templates.
 */

class CropZoomHandler
{

    /**
     * @param null|string $saveToFilePath  where should the cropped image save  ,
     *         if you didn't assigned the means the image will output to the browser
     * @param bool $retainFileExt whether  use the original file extension ,
     *           this means you can give file name any extension,default will use your extension
     *          but you can set it to true then will use the original one as ext and you just give the
     *        file path:  ->process('/xxx/myImg.jpg);  or  ->process('/xxx/myImg',true);
     *
     * @return CropZoomHandler  this make you call in chain : $cropZoomHandler->process('someFile.jpg')->
     */
    public function process($data = null, $saveToFilePath = null, $retainFileExt = false)
    {
		if($data === null)
			$data = $_POST;
        // list($width, $height) = getimagesize($data["imageSource"]);
        // $viewPortW = $data["viewPortW"];
        //$viewPortH = $data["viewPortH"];
        $pWidth = (int)$data["imageW"];
        $pHeight = (int)$data["imageH"];
        $ext = strtolower(end(explode(".", $data["imageSource"])));
        $function = $this->returnCorrectFunction($ext);
        $image = $function($data["imageSource"]);
        $width = imagesx($image);
        $height = imagesy($image);
        // Resample
        $image_p = imagecreatetruecolor($pWidth, $pHeight);
        $this->setTransparency($image, $image_p, $ext);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $pWidth, $pHeight, $width, $height);
        imagedestroy($image);
        $widthR = imagesx($image_p);
        $hegihtR = imagesy($image_p);

        $selectorX = (int)$data["selectorX"];
        $selectorY = (int)$data["selectorY"];

        if ($data["imageRotate"]) {
            $angle = 360 - (int)$data["imageRotate"];
            $image_p = imagerotate($image_p, $angle, 0);

            $pWidth = imagesx($image_p);
            $pHeight = imagesy($image_p);

            //print $pWidth."---".$pHeight;

            $diffW = abs($pWidth - $widthR) / 2;
            $diffH = abs($pHeight - $hegihtR) / 2;

            $data["imageX"] = (int)($pWidth > $widthR ? $data["imageX"] - $diffW : $data["imageX"] + $diffW);
            $data["imageY"] = (int)($pHeight > $hegihtR ? $data["imageY"] - $diffH : $data["imageY"] + $diffH);


        }

        $dst_x = $src_x = $dst_y = $src_y = 0;

        if ($data["imageX"] > 0) {
            $dst_x = abs($data["imageX"]);
        } else {
            $src_x = abs($data["imageX"]);
        }
        if ($data["imageY"] > 0) {
            $dst_y = abs($data["imageY"]);
        } else {
            $src_y = abs($data["imageY"]);
        }

        $viewport = imagecreatetruecolor($data["viewPortW"], $data["viewPortH"]);
        $this->setTransparency($image_p, $viewport, $ext);

        imagecopy($viewport, $image_p, $dst_x, $dst_y, $src_x, $src_y, $pWidth, $pHeight);
        imagedestroy($image_p);


        $selector = imagecreatetruecolor($data["selectorW"], $data["selectorH"]);
        $this->setTransparency($viewport, $selector, $ext);
        imagecopy($selector, $viewport, 0, 0, $selectorX, $selectorY, $data["viewPortW"], $data["viewPortH"]);

        $saveToFilePath = ($retainFileExt == true) ? $saveToFilePath . '.' . $ext : $saveToFilePath;
        $this->parseImage($ext, $selector, $saveToFilePath);
        imagedestroy($viewport);
        //Return value
        return $this;
        /* Functions */

    }

    /**
     * @param $sourceWidth
     * @param $sourceHeight
     * @param $targetWidth
     * @param $targetHeight
     * @return mixed
     */
    protected function determineImageScale($sourceWidth, $sourceHeight, $targetWidth, $targetHeight)
    {
        $scalex = $targetWidth / $sourceWidth;
        $scaley = $targetHeight / $sourceHeight;
        return min($scalex, $scaley);
    }

    /**
     * @param $ext
     * @return string
     */
    protected function returnCorrectFunction($ext)
    {
		$ext = strtolower($ext);
        $function = "";
        switch ($ext) {
            case "png":
                $function = "imagecreatefrompng";
                break;
            case "jpeg":
                $function = "imagecreatefromjpeg";
                break;
            case "jpg":
                $function = "imagecreatefromjpeg";
                break;
            case "gif":
                $function = "imagecreatefromgif";
                break;
        }
        return $function;
    }

    /**
     * @param $ext
     * @param $img
     * @param null $file
     * @return void
     */
    protected function parseImage($ext, $img, $file = null)
    {
		$ext = strtolower($ext);
        switch ($ext) {
            case "png":
                imagepng($img, ($file != null ? $file : ''));
                break;
            case "jpeg":
                imagejpeg($img, ($file ? $file : ''), 90);
                break;
            case "jpg":
                imagejpeg($img, ($file ? $file : ''), 90);
                break;
            case "gif":
                imagegif($img, ($file ? $file : ''));
                break;
        }
    }

    /**
     * @param $imgSrc
     * @param $imgDest
     * @param $ext
     * @return void
     */
    protected function setTransparency($imgSrc, $imgDest, $ext)
    {
        if ($ext == "png" || $ext == "gif") {
            $trnprt_indx = imagecolortransparent($imgSrc);
            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {
                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($imgSrc, $trnprt_indx);
                // Allocate the same color in the new image resource
                $trnprt_indx = imagecolorallocate($imgDest, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                // Completely fill the background of the new image with allocated color.
                imagefill($imgDest, 0, 0, $trnprt_indx);
                // Set the background color for new image to transparent
                imagecolortransparent($imgDest, $trnprt_indx);
            }
                // Always make a transparent background color for PNGs that don't have one allocated already
            elseif ($ext == "png") {
                // Turn off transparency blending (temporarily)
                imagealphablending($imgDest, true);
                // Create a new transparent color for image
                $color = imagecolorallocatealpha($imgDest, 0, 0, 0, 127);
                // Completely fill the background of the new image with allocated color.
                imagefill($imgDest, 0, 0, $color);
                // Restore transparency blending
                imagesavealpha($imgDest, true);
            }

        }
    }
}
