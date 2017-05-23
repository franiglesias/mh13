<?php

namespace Mh13\shared\web\twig\filter;

class Summarizer
{
    public static function summarizeText(string $text, int $words = 50)
    {
        $text = html_entity_decode(strip_tags($text));
        $abstractor = new Summarizer();
        $paragraph = $abstractor->extractFirstParagraph($text);
        if (str_word_count($paragraph) <= $words) {
            return $paragraph;
        }

        return $abstractor->extractFirstWords($words, $paragraph);
    }

    private function extractFirstParagraph($text)
    {
        $paragraphs = mb_split('\n', $text);

        return $paragraphs[0];
    }

    /**
     * @param $words
     * @param $paragraph
     *
     * @return string
     */
    protected function extractFirstWords($words, $paragraph): string
    {
        $result = [];
        mb_ereg("\b((?:[\w]+\W+){0,$words})\W+", $paragraph, $result);

        return mb_ereg_replace('\W$', '…', $result[1]);
    }

}
