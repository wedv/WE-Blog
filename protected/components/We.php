<?php
/**
 * 常用函数助手类
 */
class We {

    public static function curl($url, $postFields = null, $isSSL = true) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            foreach ($postFields as $k => $v) {
                $postBodyString .= "$k=" . urlencode($v) . "&";
            }
            unset($k, $v);
            if ($isSSL) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
        }
        $reponse = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($reponse, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }

    public static function mmkDir($newPath) {
        if (!is_dir($newPath)) {
            $old = umask(0);
            $ok = mkdir($newPath, 0777, true);
            umask($old);
        }
    }

    public static function judgeInServiceByIp($ip = '') {
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip;
        $res = We::curl($url);
        try {
            $res = json_decode($res, true);
        } catch (Exception $e) {
            $res = array();
        }
        $result = array('inService' => false, 'provinceName' => $res['data']['region']);
        if (isset($res['code']) && $res['code'] == 0) {
            $province = intval($res['data']['region_id']);
            $criteria = new CDbCriteria();
            $criteria->condition = 'province=:province';
            $criteria->params = array(':province' => $province);
            $hasHall = Hall::model()->count($criteria);
            if ($hasHall > 0) {
                $result['inService'] = true;
            }
        }
        return $result;
    }

    public static function makeThumb($srcFile, $dstFile, $dstW, $dstH, $rate = 100, $markwords = null, $markimage = null) {
        ini_set('memory_limit', '200M');
        $data = GetImageSize($srcFile);
        switch ($data[2]) {
            case 1:
                $im = ImageCreateFromGIF($srcFile);
                break;
            case 2:
                $im = ImageCreateFromJPEG($srcFile);
                break;
            case 3:
                $im = ImageCreateFromPNG($srcFile);
                break;
        }
        if (!$im)
            return False;
        $srcW = ImageSX($im);
        $srcH = ImageSY($im);
        $dstX = 0;
        $dstY = 0;
        //print "$srcW,$srcH\n";
        if ($srcW * $dstH > $srcH * $dstW) {
            $fdstH = round($srcH * $dstW / $srcW);
            $dstY = floor(($dstH - $fdstH) / 2);
            $fdstW = $dstW;
        } else {
            $fdstW = round($srcW * $dstH / $srcH);
            $dstX = floor(($dstW - $fdstW) / 2);
            $fdstH = $dstH;
        }
        $ni = ImageCreateTrueColor($fdstW, $fdstH);
        $dstX = ($dstX < 0) ? 0 : $dstX;
        $dstY = ($dstX < 0) ? 0 : $dstY;
        $dstX = ($dstX > ($dstW / 2)) ? floor($dstW / 2) : $dstX;
        $dstY = ($dstY > ($dstH / 2)) ? floor($dstH / s) : $dstY;
        $white = ImageColorAllocate($ni, 255, 255, 255);
        $black = ImageColorAllocate($ni, 0, 0, 0);
        imagefilledrectangle($ni, 0, 0, $fdstW, $fdstH, $white); // 填充背景色 
        imagecopyresampled($ni, $im, 0, 0, 0, 0, $fdstW, $fdstH, $srcW, $srcH); //重采样拷贝部分图像并调整大小 
        //ImageCopyResized($ni,$im,$dstX,$dstY,0,0,$fdstW,$fdstH,$srcW,$srcH); 
        if ($markwords != null) {
            $markwords = iconv("gb2312", "UTF-8", $markwords);
            //转换文字编码 
            ImageTTFText($ni, 20, 30, 450, 560, $black, "simhei.ttf", $markwords); //写入文字水印 
            //参数依次为，文字大小|偏转度|横坐标|纵坐标|文字颜色|文字类型|文字内容 
        } elseif ($markimage != null) {
            $wimage_data = GetImageSize($markimage);
            switch ($wimage_data[2]) {
                case 1:
                    $wimage = ImageCreateFromGIF($markimage);
                    break;
                case 2:
                    $wimage = ImageCreateFromJPEG($markimage);
                    break;
                case 3:
                    $wimage = ImageCreateFromPNG($markimage);
                    break;
            }
            imagecopy($ni, $wimage, 500, 560, 0, 0, 88, 31); //写入图片水印,水印图片大小默认为88*31 
            imagedestroy($wimage);
        }
        ImageJpeg($ni, $dstFile, $rate);
        //ImageJpeg($ni,$srcFile,$rate); 
        imagedestroy($im);
        imagedestroy($ni);
        return array($fdstW, $fdstH);
    }

    public static function utf8Len($str) {
        mb_internal_encoding("UTF-8");
        return mb_strlen($str);
    }

    public static function model2Array($model, $fields = false) {
        $result = array();
        if (!$fields) {
            $fields = array_keys($model->attributes);
        }
        foreach ($fields as $aField) {
            if (isset($model[$aField])) {
                $result[$aField] = $model[$aField];
            }
        }
        return $result;
    }

    public static function models2Array($models) {
        $result = array();
        foreach ($models as $aModel) {
            $arr = self::model2array($aModel);
            $result[] = $arr;
        }
        return $result;
    }

    public static function models2Map($models, $pk = "id") {
        $result = array();
        foreach ($models as $aModel) {
            $arr = self::model2array($aModel);
            $id = $arr[$pk];
            $result[$id] = $arr;
        }
        return $result;
    }

    public static function selectField2Array($items, $field) {
        $result = array();
        foreach ($items as $aItem) {
            $result[] = $aItem[$field];
        }
        return $result;
    }

    /**
     * 用 mb_strimwidth 来截取字符，使中英尽量对齐。
     */
    public static function wsubstr($str, $start, $width, $trimmarker = '...') {
        $_encoding = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        return mb_strimwidth($str, $start, $width, $trimmarker, $_encoding);
    }

}