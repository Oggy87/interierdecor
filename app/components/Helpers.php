<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author oggy
 */
class Helpers {
    
        /**
         * Static class - cannot be instantiated.
         */
        final public function __construct()
        {
            throw new LogicException("Cannot instantiate static class " . get_class($this));
        }

        public static function timeAgo($time)
	{
		if (!$time) {
			return FALSE;
		} elseif (is_numeric($time)) {
			$time = (int) $time;
		} elseif ($time instanceof DateTime) {
			$time = $time->format('U');
		} else {
			$time = strtotime($time);
		}

		$delta = time() - $time;

		if ($delta < 0) {
			$delta = round(abs($delta) / 60);
			if ($delta == 0) return 'za okamžik';
			if ($delta == 1) return 'za minutu';
			if ($delta < 45) return 'za ' . $delta . ' ' . self::plural($delta, 'minuta', 'minuty', 'minut');
			if ($delta < 90) return 'za hodinu';
			if ($delta < 1440) return 'za ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hodina', 'hodiny', 'hodin');
			if ($delta < 2880) return 'zítra';
			if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dní');
			if ($delta < 86400) return 'za měsíc';
			if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'měsíc', 'měsíce', 'měsíců');
			if ($delta < 1051920) return 'za rok';
			return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let');
		}

		$delta = round($delta / 60);
		if ($delta == 0) return 'před okamžikem';
		if ($delta == 1) return 'před minutou';
		if ($delta < 45) return "před $delta minutami";
		if ($delta < 90) return 'před hodinou';
		if ($delta < 1440) return 'před ' . round($delta / 60) . ' hodinami';
		if ($delta < 2880) return 'včera';
		if ($delta < 43200) return 'před ' . round($delta / 1440) . ' dny';
		if ($delta < 86400) return 'před měsícem';
		if ($delta < 525960) return 'před ' . round($delta / 43200) . ' měsíci';
		if ($delta < 1051920) return 'před rokem';
		return 'před ' . round($delta / 525960) . ' lety';
	}
        
        public static function productPhotoGrid($id) {
            if(!$id)  return NULL;
            
            $productPhoto = BaseModel::fetchRow('productPhoto', $id);
            if(!$productPhoto) return NULL;
            else {
                return self::image($productPhoto['image_path'], 50, 50, 'produkt', FALSE, TRUE, FALSE);
            }
        }
        
        public static function tagImage($picture_path) {
            if($picture_path == '')  return NULL;
            
            return self::image($picture_path, NULL, 32, 'šítek', FALSE, FALSE, FALSE);
        }
        
        public static function thumb($tmpname,$width,$height) {
        
        $file = WWW_DIR  . $tmpname;

        if(!$width AND !$height) return NULL;
        
        if($width AND $height) {
            $thumb = Image::fromFile($file)->resize($width, $height, Image::FILL | Image::ENLARGE)
                ->crop('50%', '50%', $width, $height);
        }
        elseif($width) {
            $thumb = Image::fromFile($file)->resize($width, NULL);
        }
        elseif($height) {
            $thumb = Image::fromFile($file)->resize(NULL, $height);
        }

        $dateTime = new DateTime53();

        $maxFileAge = 60 * 60; // Temp file age in seconds
        $fileName = basename($tmpname).'-'.$dateTime->getTimestamp(). '.tmp';
        $tmpdir = WWW_DIR . '/static/temp/';

        // Create target dir
        if (!file_exists($tmpdir))
            @mkdir($tmpdir);

        $thumb->save($tmpdir . $fileName, 100, Image::JPEG);

        $img = Html::el('img');
        $img->src = Environment::getVariable('baseUri') . 'static/temp/' . $fileName;
        $img->width = $thumb->width;
        $img->height = $thumb->height;
        
        // Remove old temp files
        if (is_dir($tmpdir) && ($dir = opendir($tmpdir))) {
            while (($file = readdir($dir)) !== false) {
                $filePath = $tmpdir . DIRECTORY_SEPARATOR . $file;

                // Remove temp files if they are older than the max age
                if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
                    @unlink($filePath);
            }
            closedir($dir);
        }
        
        return array('thumb' => $img, 'file' => '/static/temp/'.$fileName);
    }


        public static function image($image,$width,$height,$alt,$watermark = TRUE, $crop = FALSE, $enlarge = FALSE, $dateMark = TRUE,$class = NULL, $id = NULL,$title = NULL,$format = NULL) {

            $static = 'static/';
            $image = $static.$image;
            if (!file_exists(WWW_DIR.'/'.$image)) {
                return 'Image not found.';
            }
            $staticTemp = $static.'temp';
            $staticUri = WWW_DIR.'/'.$static;
            $staticUriTemp = WWW_DIR.'/'.$staticTemp;

            if ($watermark == 'true' OR $watermark == 'TRUE') $watermark = TRUE;
            elseif ($watermark == 'false' OR $watermark == 'FALSE') $watermark = FALSE;

            if ($dateMark == 'true' OR $dateMark == 'TRUE') $dateMark = TRUE;
            elseif ($dateMark == 'false' OR $dateMark == 'FALSE') $dateMark = FALSE;

            if ($crop == 'true' OR $crop == 'TRUE') $crop = TRUE;
            elseif ($crop == 'false' OR $crop == 'FALSE') $crop = FALSE;

            if ($enlarge == 'true' OR $enlarge == 'TRUE') $enlarge = TRUE;
            elseif ($enlarge == 'false' OR $enlarge == 'FALSE') $enlarge = FALSE;

            if ($class == 'NULL') $class = NULL;
            if ($id == 'NULL') $id = NULL;

            $dirName = dirname($image).'/';
            list($name, $suffix) = explode('.',basename($image),2);
            $suffix = '.'.$suffix;

            $nameSuffix = $width.'x'.$height;
            if ($watermark) $nameSuffix = $nameSuffix.'_w';
            if ($crop) $nameSuffix = $nameSuffix.'_c';

            $newImage = $name.'_'.$nameSuffix.$suffix;

            if (!is_dir(WWW_DIR.'/'.$dirName) || !is_writable($staticUriTemp)) {
                throw new InvalidStateException('Thumbnail path ' . WWW_DIR.'/'.$dirName . ' does not exists or '.$staticUriTemp.' is not writable.');
            }

            if (!file_exists($staticUriTemp.'/'.$newImage)) {
                if ($crop) {
                    if($enlarge) {
                        $thumb = Image::fromFile(WWW_DIR.'/'.$image)->resize($width, $height,Image::FILL | Image::ENLARGE)
                                    ->crop('50%', '50%', $width, $height);
                    }
                    else {
                        $thumb = Image::fromFile(WWW_DIR.'/'.$image)->resize($width, $height,Image::FILL)
                                    ->crop('50%', '50%', $width, $height);
                    }
                }
                else {
                    if($enlarge) {
                        $thumb = Image::fromFile(WWW_DIR.'/'.$image)->resize($width, $height, Image::ENLARGE);
                    }
                    else {
                        if($width OR $height) {
                            $thumb = Image::fromFile(WWW_DIR.'/'.$image)->resize($width, $height);
                        }
                        else {
                            $thumb = Image::fromFile(WWW_DIR.'/'.$image);
                        }
                    }
                }

                if ($watermark) {
                    $watermarkImage = Image::fromFile($staticUri."images/watermark.png");
                    $watermarkImage->resize($thumb->width * 0.225,$thumb->height * 0.1875);

                    $thumb->place($watermarkImage, '97%', '97%');
                }
                $thumb->sharpen();
                $thumb->saveAlpha(true);

                if($format) {
                    $thumb->save($staticUriTemp.'/'.$newImage, 100,$format);
                }
                else {
                    $thumb->save($staticUriTemp.'/'.$newImage, 100);
                }
            }
            else {
                $thumb = Image::fromFile($staticUriTemp.'/'.$newImage);
            }

            $dateTime = new DateTime53();

            $img = Html::el('img');
            if ($dateMark) $src = Environment::getVariable("baseUri").$staticTemp.'/'.$newImage.'?'.$dateTime->getTimestamp();
            else $src = Environment::getVariable("baseUri").$staticTemp.'/'.$newImage;
            $img->src =  $src;
            $img->width = $thumb->width;
            $img->height = $thumb->height;
            $img->alt = $alt;
            $img->title = $title;
            if ($class) $img->class = $class;
            if ($id) $img->id = $id;

            return $img;
        }

        public static function imageDb($image,$name,$modified,$width,$height,$alt,$watermark = TRUE, $crop = FALSE, $dateMark = TRUE,$class = NULL, $id = NULL) {

            $static = 'static/';

            $staticTemp = $static.'temp';
            $staticUri = WWW_DIR.'/'.$static;
            $staticUriTemp = WWW_DIR.'/'.$staticTemp;

            if ($watermark == 'true' OR $watermark == 'TRUE') $watermark = TRUE;
            elseif ($watermark == 'false' OR $watermark == 'FALSE') $watermark = FALSE;

            if ($dateMark == 'true' OR $dateMark == 'TRUE') $dateMark = TRUE;
            elseif ($dateMark == 'false' OR $dateMark == 'FALSE') $dateMark = FALSE;

            if ($crop == 'true' OR $crop == 'TRUE') $crop = TRUE;
            elseif ($crop == 'false' OR $crop == 'FALSE') $crop = FALSE;

            if ($class == 'NULL') $class = NULL;
            if ($id == 'NULL') $id = NULL;

          /*  $dirName = dirname($image).'/';
            list($name, $suffix) = explode('.',basename($image),2);
            $suffix = '.'.$suffix;*/

            $nameSuffix = $width.'x'.$height;
            if ($watermark) $nameSuffix = $nameSuffix.'_w';
            if ($crop) $nameSuffix = $nameSuffix.'_c';

            $format = Image::getFormatFromString($image);
            switch ($format) {
                case Image::GIF:
                    $suffix = '.gif';
                    break;
                case Image::JPEG;
                    $suffix = '.jpg';
                    break;
                default:
                    $suffix = '.png';
                    break;
            };

            $newImage = $name.'_'.$nameSuffix;//.$suffix;

            if (!is_writable($staticUriTemp)) {
                throw new InvalidStateException($staticUriTemp.' is not writable.');
            }

            foreach (Finder::findFiles($newImage.'.*')->date('<', new DateTime($modified))->in($staticTemp) as $key => $file) {
                unlink($key);
            }

            $newImage .= $suffix;

            if (!file_exists($staticUriTemp.'/'.$newImage)) {
                if ($crop) {
                    $thumb = Image::fromString($image)->resize($width, $height,Image::FILL)
                                    ->crop('50%', '50%', $width, $height);
                }
                else {
                    $thumb = Image::fromString($image)->resize($width, $height);
                }

                if ($watermark) {
                    $watermarkImage = Image::fromFile($staticUri."images/watermark.png");
                    $watermarkImage->resize($thumb->width * 0.225,$thumb->height * 0.1875);

                    $thumb->place($watermarkImage, '97%', '97%');
                }
                $thumb->sharpen();
                $thumb->saveAlpha(true);
                $thumb->save($staticUriTemp.'/'.$newImage, 100);
            }
            else {
                $thumb = Image::fromFile($staticUriTemp.'/'.$newImage);
            }
            $dateTime = new DateTime53();

            $img = Html::el('img');
            if ($dateMark) $src = Environment::getVariable("baseUri").$staticTemp.'/'.$newImage.'?'.$dateTime->getTimestamp();
            else $src = Environment::getVariable("baseUri").$staticTemp.'/'.$newImage;
            $img->src =  $src;
            $img->width = $thumb->width;
            $img->height = $thumb->height;
            $img->alt = $alt;
            if ($class) $img->class = $class;
            if ($id) $img->id = $id;

            return $img;
        }
        
        public static function uploadFile($targetDir, $name, $tmpname) {
        // Create target dir
        if (!file_exists(WWW_DIR . '/' . $targetDir))
            @mkdir(WWW_DIR . '/' . $targetDir);

        list($file, $suffix) = explode('.', basename(String::webalize($name, '.')), 2);
        $suffix = '.' . $suffix;

        $dateTime = new DateTime53();
        $file = $file . '-' . $dateTime->getTimestamp() . $suffix;

        $imageTemp = TEMP_DIR . "/plupload/" . $tmpname;

        $imageName = WWW_DIR . '/static/' . $targetDir . $file;

        $image = Image::fromFile($imageTemp);

        if (!file_exists($imageName)) {
            $move = rename($imageTemp, $imageName);
            if (!$move) {
                return FALSE;
            }
        }

        return $targetDir . $file;
    }

    public static function removeTempImages($file) {
        //temp adresar
        $tmpdir = WWW_DIR . '/static/temp/';
        //rozdelit nazev souboru pro filtraci
        list($name, $suffix) = explode('.', $file, 2);
        //najit a smazt vsechny ktere zacinaji stejne jako soubor
        foreach (Finder::findFiles(basename($name) . '_*.*')->from($tmpdir) as $key => $file) {
            @unlink($key);
        }
    }
        
        public static function roundUp($value)
	{
		return str_replace(" ", "", number_format($value, 0, "", " ")) . "";
	}

        public static function currency($value)
	{
		return str_replace(" ", "\xc2\xa0", number_format($value, 0, "", " ")) . "\xc2\xa0Kč";
	}

        public static function currencyKc($value)
	{
            if ($value == NULL) return '';
	    else return str_replace(" ", "\xc2\xa0", number_format($value, 2, ",", " ")) . "\xc2\xa0Kč";
	}

        public static function dph($price,$dph) {
            return $price * (1+$dph);
        }

        /**
	 * Plural: three forms, special cases for 1 and 2, 3, 4.
	 * (Slavic family: Slovak, Czech)
	 * @param  int
	 * @return mixed
	 */
	private static function plural($n)
	{
		$args = func_get_args();
		return $args[($n == 1) ? 1 : ($n >= 2 && $n <= 4) ? 2 : 3];
	}
        
        public static function padLeft($s, $length, $pad = ' ') {
            $length = max(0, $length - self::length($s));
            $padLen = self::length($pad);
            return str_repeat($pad, $length / $padLen) . self::substring($pad, 0, $length % $padLen) . $s;
        }
        
        public static function substring($s, $start, $length = NULL)
         {
             if ($length === NULL) {
                 $length = self::length($s);
             }
             return function_exists('mb_substr') ? mb_substr($s, $start, $length, 'UTF-8') : iconv_substr($s, $start, $length, 'UTF-8'); // MB is much faster
         }
         
        public static function length($s)
        {
            return strlen(utf8_decode($s)); // fastest way
        }
}
?>
