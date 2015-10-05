<?php

class CaptchaController extends Controller
{

    /**
     * Currently used image library
     * @var string
     */
    public $library = 'imagick';

    /**
     * Render captcha image
     * @param int $width
     * @param int $height
     * @param int $padding
     * @param int $background
     * @param int $color
     * @param int $transparent
     * @param int $offset
     * @param string $font
     */
    public function actionRender($width = 120, $height = 50, $padding = 2, $background = 0xFFFFFF, $color = 0x2040A0, $transparent = 0, $offset = -2, $font = 'captcha.ttf')
    {
        $code = Yii::app()->getSession()->get('captcha_code','NONE');

        if($this->library == 'imagick'){
            $this->renderImageImagick($code,$width,$height,$padding,$background,$color,$transparent,$offset,$font);
        }else{
            $this->renderImageGD($code,$width,$height,$padding,$background,$color,$transparent,$offset,$font);
        }
    }


    /**
     * Renders the CAPTCHA image based on the code using GD library.
     * @param string $code
     * @param int $width
     * @param int $height
     * @param int $padding
     * @param int $background
     * @param int $fore
     * @param int $transparent
     * @param int $offset
     * @param string $font
     */
    protected function renderImageGD($code, $width, $height, $padding, $background, $fore, $transparent, $offset, $font)
    {
        $image = imagecreatetruecolor($width,$height);

        $backColor = imagecolorallocate($image,
            (int)($background % 0x1000000 / 0x10000),
            (int)($background % 0x10000 / 0x100),
            $background % 0x100);
        imagefilledrectangle($image,0,0,$width,$height,$backColor);
        imagecolordeallocate($image,$backColor);

        if($transparent)
            imagecolortransparent($image,$backColor);

        $foreColor = imagecolorallocate($image,
            (int)($fore % 0x1000000 / 0x10000),
            (int)($fore % 0x10000 / 0x100),
            $fore % 0x100);
        
        $fontFile = dirname(__FILE__).DS.'/../design/fonts/'.$font;

        $length = strlen($code);
        $box = imagettfbbox(30,0,$fontFile,$code);
        $w = $box[4] - $box[0] + $offset * ($length - 1);
        $h = $box[1] - $box[5];
        $scale = min(($width - $padding * 2) / $w,($height - $padding * 2) / $h);
        $x = 10;
        $y = round($height * 27 / 40);
        for($i = 0; $i < $length; ++$i)
        {
            $fontSize = (int)(rand(26,32) * $scale * 0.8);
            $angle = rand(-10,10);
            $letter = $code[$i];
            $box = imagettftext($image,$fontSize,$angle,$x,$y,$foreColor,$fontFile,$letter);
            $x = $box[2] + $offset;
        }

        imagecolordeallocate($image,$foreColor);

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header("Content-Type: image/png");
        imagepng($image);
        imagedestroy($image);
    }

    /**
     * Renders the CAPTCHA image based on the code using ImageMagick library.
     * @param string $code
     * @param int $width
     * @param int $height
     * @param int $padding
     * @param int $background
     * @param int $fore
     * @param int $transparent
     * @param int $offset
     * @param string $font
     */
    protected function renderImageImagick($code, $width, $height, $padding, $background, $fore, $transparent, $offset, $font)
    {
        $backColor=$transparent ? new ImagickPixel('transparent') : new ImagickPixel(sprintf('#%06x',$background));
        $foreColor=new ImagickPixel(sprintf('#%06x',$fore));

        $image=new Imagick();
        $image->newImage($width,$height,$backColor);

        $fontFile = dirname(__FILE__).DS.'/../design/fonts/'.$font;

        $draw=new ImagickDraw();
        $draw->setFont($fontFile);
        $draw->setFontSize(30);
        $fontMetrics=$image->queryFontMetrics($draw,$code);

        $length=strlen($code);
        $w=(int)($fontMetrics['textWidth'])-8+$offset*($length-1);
        $h=(int)($fontMetrics['textHeight'])-8;
        $scale=min(($width-$padding*2)/$w,($height-$padding*2)/$h);
        $x=10;
        $y=round($height*27/40);
        for($i=0; $i<$length; ++$i)
        {
            $draw=new ImagickDraw();
            $draw->setFont($fontFile);
            $draw->setFontSize((int)(rand(26,32)*$scale*0.8));
            $draw->setFillColor($foreColor);
            $image->annotateImage($draw,$x,$y,rand(-10,10),$code[$i]);
            $fontMetrics=$image->queryFontMetrics($draw,$code[$i]);
            $x+=(int)($fontMetrics['textWidth'])+$offset;
        }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header("Content-Type: image/png");
        $image->setImageFormat('png');
        echo $image->getImageBlob();
    }
}