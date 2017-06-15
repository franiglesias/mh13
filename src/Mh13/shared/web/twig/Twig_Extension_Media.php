<?php

namespace Mh13\shared\web\twig;

use Mh13\shared\web\twig\filter\Humanizer;
use Mh13\shared\web\twig\filter\Summarizer;
use Mh13\shared\web\twig\filter\YoutubeLinkParser;
use Twig_Extension;
use Twig_Filter;


class Twig_Extension_Media extends Twig_Extension
{
    private $environment;

    public function getFilters()
    {
        return [
            new Twig_Filter('readable_size', [Humanizer::class, 'humanizeFileSize']),

            new Twig_Filter('readable_playtime', [Humanizer::class, 'humanizePlayTime']),

            new Twig_Filter('humanize', [Humanizer::class, 'humanizeFileName']),

            new Twig_Filter('abstract', [Summarizer::class, 'summarizeText']),

            new Twig_Filter('parse', [YoutubeLinkParser::class, 'parse']),
        ];
    }


}
