<?php

namespace Mh13\shared\web\twig;

use Mh13\shared\web\twig\filter\Humanizer;
use Mh13\shared\web\twig\filter\Summarizer;
use Mh13\shared\web\twig\filter\YoutubeLinkParser;
use Twig_Extension;
use Twig_SimpleFilter;


class Twig_Extension_Media extends Twig_Extension
{
    private $environment;

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('readable_size', [Humanizer::class, 'humanizeFileSize']),

            new Twig_SimpleFilter('readable_playtime', [Humanizer::class, 'humanizePlayTime']),

            new Twig_SimpleFilter('humanize', [Humanizer::class, 'humanizeFileName']),

            new Twig_SimpleFilter('abstract', [Summarizer::class, 'summarizeText']),

            new Twig_SimpleFilter('parse', [YoutubeLinkParser::class, 'parse']),
        ];
    }


}
