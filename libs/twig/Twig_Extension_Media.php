<?php

class Twig_Extension_Media extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('readable_size', function ($size) {
                if ($size > 1048576) {
                    return round(1048576 / $size, 2).' MB';
                }
                if ($size > 1024) {
                    return round(1024 / $size, 2).' KB';
                }

                return $size.' bytes';
            }),

            new Twig_SimpleFilter('readable_playtime', function ($playtime) {
                $seconds = fmod($playtime, 60);
                $minutes = floor($playtime / 60);

                return sprintf('%d:%d', $minutes, $seconds);
            }),

            new Twig_SimpleFilter('humanize', function ($name) {
                $name = str_replace('_', ' ', $name);

                return ucfirst($name);
            }),

            new Twig_SimpleFilter('parse', function ($environment, $text) {
                $text = preg_replace_callback('/https?:\/\/(?:www)?\.youtube\.com\/watch\?v=([^<&]*)(&\S*)?/', function ($videoId) use ($environment) {
                    return $environment->render('plugins/media/youtube.twig', ['videoid' => $videoId[1]]);
                }, $text);
                $text = preg_replace_callback('/https?:\/\/youtu\.be\/([a-zA-Z0-9\-]*)/', function ($videoId) use ($environment) {
                    return $environment->render('plugins/media/youtube.twig', ['videoid' => $videoId[1]]);
                }, $text);

                return $text;
            }, array('needs_environment' => true)),
        );
    }
}
