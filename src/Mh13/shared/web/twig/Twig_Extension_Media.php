<?php

namespace Mh13\shared\web\twig;

use Twig_Extension;
use Twig_SimpleFilter;


class Twig_Extension_Media extends Twig_Extension
{
    private $environment;

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter(
                'readable_size', function ($size) {
                if ($size > 1048576) {
                    return round(1048576 / $size, 2).' MB';
                }
                if ($size > 1024) {
                    return round(1024 / $size, 2).' KB';
                }

                return $size.' bytes';
            }
            ),

            new Twig_SimpleFilter(
                'readable_playtime', function ($playtime) {
                $seconds = $playtime % 60;
                $minutes = floor($playtime / 60);

                return sprintf('%d:%d', $minutes, $seconds);
            }
            ),

            new Twig_SimpleFilter(
                'humanize', function ($name) {
                $name = str_replace('_', ' ', $name);

                return ucfirst($name);
            }
            ),

            new Twig_SimpleFilter(
                'parse', function ($environment, $text) {
                $this->environment = $environment;
                $buildYoutubePlayer = function ($videoId) {
                    return $this->environment->render('plugins/media/youtube.twig', ['videoid' => $videoId[1]]);
                };
                $patterns = [
                    '/https?:\/\/(?:www)?\.youtube\.com\/watch\?v=([^<&]*)(&\S*)?/',
                    '/https?:\/\/youtu\.be\/([a-zA-Z0-9\-]*)/',
                ];
                $text = preg_replace_callback($patterns, $buildYoutubePlayer, $text);

                return $text;
            }, array('needs_environment' => true)
            ),
        );
    }


}
