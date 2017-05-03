<?php

namespace Mh13\shared\web\twig\filter;

class YoutubeLinkParser
{
    static private $patterns = [
        '/https?:\/\/(?:www)?\.youtube\.com\/watch\?v=([^<&]*)(&\S*)?/',
        '/https?:\/\/youtu\.be\/([a-zA-Z0-9\-]*)/',
    ];

    static private $template = '<iframe width="770" height="578" src="https://www.youtube.com/embed/$1?rel=0&autoplay=0" frameborder="0" allowfullscreen></iframe>';

    public static function parse($text)
    {
        return preg_replace(static::$patterns, static::$template, $text);

    }

    public static function hasLinks($text)
    {
        return array_reduce(
            static::$patterns,
            function ($carried, $pattern) use ($text) {
                return $carried ? $carried : preg_match($pattern, $text) > 0;
            },
            false
        );
    }
}
