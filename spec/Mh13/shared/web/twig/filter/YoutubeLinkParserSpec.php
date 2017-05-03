<?php

namespace spec\Mh13\shared\web\twig\filter;

use Mh13\shared\web\twig\filter\YoutubeLinkParser;
use PhpSpec\ObjectBehavior;


class YoutubeLinkParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(YoutubeLinkParser::class);
    }

    public function it_can_say_if_text_has_youtube_links()
    {
        $standard = 'https://www.youtube.com/watch?v=BdJ-WIzl6is';
        $this::shouldHaveLinks($standard);
    }

    public function it_parses_youtube_standard_links()
    {
        $standard = 'https://www.youtube.com/watch?v=BdJ-WIzl6is';
        $this::parse($standard)->shouldBe($this->getYoutubeCode('BdJ-WIzl6is'));

    }

    public function getYoutubeCode($code)
    {
        return '<iframe width="770" height="578" src="https://www.youtube.com/embed/'.$code.'?rel=0&autoplay=0" frameborder="0" allowfullscreen></iframe>';
    }

    public function it_parses_youtube_short_links()
    {
        $short = 'https://youtu.be/BdJ-WIzl6is';
        $this::parse($short)->shouldBe($this->getYoutubeCode('BdJ-WIzl6is'));

    }

    public function it_parses_a_complex_text_with_youtube_links()
    {
        $text = <<<EOD
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempor faucibus erat. Morbi consequat metus leo, vel convallis felis dapibus ut. Nam bibendum tortor odio, vitae ullamcorper urna feugiat id. Quisque eleifend ullamcorper orci, quis posuere ante aliquam at. Maecenas id sollicitudin sapien. Morbi eget urna elit. Proin consequat neque sit amet felis venenatis gravida. Donec a dapibus eros, vel sollicitudin felis.</p>
<p>https://www.youtube.com/watch?v=BdJ-WIzl6is</p>
<p>Nunc ac tincidunt justo. Fusce vel metus faucibus enim posuere vehicula in ut lectus. Duis euismod turpis vel pellentesque tristique. Nunc ligula nulla, blandit sed faucibus ut, cursus ut augue. Etiam efficitur tellus quis laoreet cursus. Proin varius mi posuere leo pellentesque, sit amet euismod diam facilisis. Nulla bibendum egestas risus, quis commodo nunc lacinia ut. Sed vitae auctor magna. Morbi sagittis blandit tempor. Duis sem orci, pretium sit amet urna vitae, pretium lobortis sem.</p>
EOD;
        $expected = <<<EOD
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempor faucibus erat. Morbi consequat metus leo, vel convallis felis dapibus ut. Nam bibendum tortor odio, vitae ullamcorper urna feugiat id. Quisque eleifend ullamcorper orci, quis posuere ante aliquam at. Maecenas id sollicitudin sapien. Morbi eget urna elit. Proin consequat neque sit amet felis venenatis gravida. Donec a dapibus eros, vel sollicitudin felis.</p>
<p><iframe width="770" height="578" src="https://www.youtube.com/embed/BdJ-WIzl6is?rel=0&autoplay=0" frameborder="0" allowfullscreen></iframe></p>
<p>Nunc ac tincidunt justo. Fusce vel metus faucibus enim posuere vehicula in ut lectus. Duis euismod turpis vel pellentesque tristique. Nunc ligula nulla, blandit sed faucibus ut, cursus ut augue. Etiam efficitur tellus quis laoreet cursus. Proin varius mi posuere leo pellentesque, sit amet euismod diam facilisis. Nulla bibendum egestas risus, quis commodo nunc lacinia ut. Sed vitae auctor magna. Morbi sagittis blandit tempor. Duis sem orci, pretium sit amet urna vitae, pretium lobortis sem.</p>
EOD;
        $this::parse($text)->shouldBe($expected);
    }

}
