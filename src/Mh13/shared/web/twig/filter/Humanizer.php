<?php

namespace Mh13\shared\web\twig\filter;

class Humanizer
{

    public static function humanizeFileSize($size)
    {
        $convert = [
            30 => 'GB',
            20 => 'MB',
            10 => 'KB',
        ];
        foreach ($convert as $exp => $unit) {
            $limit = pow(2, $exp);
            if ($size >= $limit) {
                return number_format($size / $limit, 2).' '.$unit;
            }
        }

        return number_format($size, 0).' B';
    }

    public static function humanizePlayTime($playtimeInSeconds)
    {
        $seconds = $playtimeInSeconds % 60;
        $minutes = floor($playtimeInSeconds / 60);

        if ($minutes < 60) {
            return sprintf('%02d:%02d', $minutes, $seconds);
        }

        $playtime = $minutes;
        $minutes = $playtime % 60;
        $hours = floor($playtime / 60);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function humanizeFileName($name)
    {
        $name = str_replace('_', ' ', $name);

        return ucfirst($name);
    }

}
