<?php

namespace App\Libraries;

use Storage;
use InvalidArgumentException;
use Intervention\Image\ImageManagerStatic as Image;

class QrcodeRuang
{

    const EXTENSION = 'jpg';

    protected static $default_path = 'qrcodes';

    public static function make($code, array $options)
    {
        return new static($code, $options);
    }

    public static function getDefaultPath()
    {
        $path = public_path(static::$default_path);
        return rtrim($path, '/');
    }

    public static function setDefaultPath($path)
    {
        static::$default_path = str_replace(public_path(), '', $path);
    }

    public function __construct($code, array $options = [])
    {
        $this->options = array_merge([
            'disk' => 'qrcodes',
            'width' => 15,
            'height' => 15,
            'type' => 'QRCODE',
        ], $options);
        $this->code = $code;
        $this->makeSureDiskDefined();
    }

    public function generateIfNotExists()
    {
        if (!$this->qrcodeExists()) {
            return $this->generate();
        } else {
            return $this;
        }
    }

    public function generate()
    {
        $this->generateQrcode();
        $this->insertQrcodeTexts();
        return $this;
    }

    public function getFilename()
    {
        return $this->code.'.'.static::EXTENSION;
    }

    public function getFilepath($generateIfNotExists = true)
    {
        if ($generateIfNotExists) $this->generateIfNotExists();

        $relativePath = $this->getRelativePath();
        return $this->getStorageDisk()->path($relativePath);
    }

    public function getUrl($generateIfNotExists = true)
    {
        if ($generateIfNotExists) $this->generateIfNotExists();

        $relativePath = $this->getRelativePath();
        return $this->getStorageDisk()->url($relativePath);
    }

    public function getRelativePath()
    {
        $directory = rtrim($this->getOption('directory'), '/');
        return $directory.'/'.$this->getFilename();
    }

    public function getStorageDisk()
    {
        $disk = $this->getOption('disk');
        return Storage::disk($disk);
    }

    public function qrcodeExists()
    {
        return $this->getStorageDisk()->has($this->getRelativePath());
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($key)
    {
        return array_get($this->options, $key) ?: null;
    }

    protected function generateQrcode()
    {
        $width = $this->getOption('width');
        $height = $this->getOption('height');
        $type = $this->getOption('type');

        $image = base64_decode(\DNS2D::getBarcodePNG($this->code, $type, $width, $height));
        $this->save($image);
    }

    protected function insertQrcodeTexts()
    {
        $code = $this->code;
        $name = $this->getOption('name');
        $fontNormal = __DIR__.'/fonts/arial.ttf';
        $fontBold = __DIR__.'/fonts/arialbd.ttf';
        $fontSize = 96;
        $texts = [];
        $texts[$code] = [
            'file' => $fontBold,
            'size' => $fontSize
        ];
        if ($name) {
            $texts[$name] = [
                'file' => $fontNormal,
                'size' => round($fontSize * .8),
            ];
        }
        if (!$this->qrcodeExists()) {
            $this->generateQrcode();
        }

        $qrcode = Image::make($this->getFilepath());
        $width = $qrcode->width();
        $height = $qrcode->height();
        $padding = 50;
        $hSpacing = 5;
        $y = $padding * 3;
        $paperWidth = $width;

        foreach ($texts as $text => $opts) {
            $texts[$text]['box'] = $boxSize = $this->getTextBoxSize($text, $opts);
            // $height += $boxSize['height'] + $hSpacing;
            if ($width + $boxSize['width'] > $paperWidth) {
                $paperWidth = $width + $boxSize['width'];
            }
        }

        $canvas = Image::canvas($paperWidth + ($padding * 3), $height + 5 + ($padding * 2));
        $canvas->insert($qrcode, 'top-left', $padding, $padding);
        $xText = $width + ($padding * 2);
        foreach ($texts as $text => $opts) {
            $h = $opts['box']['height'];
            unset($opts['box']);
            if ($text) {
                $this->insertText($canvas, $text, $xText, $y, null, 'left', $opts);
            }
            $y += $h + $hSpacing;
        }

        $img = $canvas->encode(static::EXTENSION, 100);
        $this->save((string) $img);
    }

    protected function save($content)
    {
        $relativePath = $this->getRelativePath();
        $this->getStorageDisk()->put($relativePath, $content);
    }

    protected function makeSureDiskDefined()
    {
        $disk = $this->getOption('disk');
        if (!config("filesystems.disks.{$disk}")) {
            throw new InvalidArgumentException("Storage disk '{$disk}' is not defined. Define it in 'config/filesystems.php'.");
        }
    }

    protected function getTextBoxSize($text, array $options = [])
    {
        $canvas = Image::canvas(10, 10);
        $box = null;
        $canvas->text($text, 0, 0, function($font) use ($options, &$box) {
            foreach ($options as $method => $params) {
                call_user_func_array([$font, $method], is_array($params) ? $params : [$params]);
            }
            $box = $font->getBoxSize();
        });
        return $box;
    }

    protected function insertText($image, $text, $x, $y, $width = null, $align = 'left', array $options = [])
    {
        if (!$width) $width = $image->width();
        if ($align != 'left') {
            $textBoxSize = $this->getTextBoxSize($text, $options);
            $textWidth = $textBoxSize['width'];
            $textHeight = $textBoxSize['height'];
            switch ($align) {
                case 'right': $x = ($x + $width) - $textWidth; break;
                case 'center': $x += ((($x + $width) - $x) - $textWidth) / 2; break;
            }
        }

        $image->text($text, $x, $y, function($font) use ($options) {
            foreach ($options as $method => $params) {
                call_user_func_array([$font, $method], is_array($params) ? $params : [$params]);
            }
        });
    }

    protected function getCenter($x1, $x2, $width)
    {
        return $x1 + ((($x2 - $x1) - $width) / 2);
    }

}
