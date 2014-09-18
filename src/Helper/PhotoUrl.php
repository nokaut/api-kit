<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.06.2014
 * Time: 13:56
 */

namespace Nokaut\ApiKit\Helper;


class PhotoUrl
{

    public static function prepare($photoId, $size = '90x90', $additionalUrlPart = '')
    {
        if(empty($photoId)) {
            return "/noimg_{$size}.png";
        }
        return '/p-' . substr($photoId, 0, 2) . '-' . substr($photoId, 2, 2) . '-' . $photoId . $size . '/' . Text::urlize($additionalUrlPart) . '.jpg';
    }
} 