<?php

namespace spec\Mh13\shared\web\twig\filter;

use Mh13\shared\web\twig\filter\Summarizer;
use PhpSpec\ObjectBehavior;


class SummarizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Summarizer::class);
    }

    public function it_uses_whole_first_paragraph_if_it_is_shorter_than_limit()
    {
        $text = $this->getTextWithShortParagraph();
        $this::getAbstract($text, 50)->shouldBe(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas, nulla quis dapibus vestibulum, lorem purus euismod diam, in sodales nibh libero vitae ligula. Sed ornare velit id arcu ultricies, ac pulvinar ipsum cursus. Sed varius bibendum nulla, non molestie.'
        )
        ;
    }

    public function getTextWithShortParagraph()
    {
        return <<< EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas, nulla quis dapibus vestibulum, lorem purus euismod diam, in sodales nibh libero vitae ligula. Sed ornare velit id arcu ultricies, ac pulvinar ipsum cursus. Sed varius bibendum nulla, non molestie.
Donec lacinia sed sem in volutpat. Fusce rutrum quam eget tortor mollis blandit. Integer ullamcorper diam sit amet elementum auctor. Morbi enim elit, volutpat non nisi sit amet, mattis dapibus odio. Nulla non dapibus risus, eu consectetur turpis. Cras risus libero, consequat vel leo a, interdum feugiat erat. Phasellus vitae fringilla diam, faucibus fermentum tortor. Donec malesuada, nulla ut lobortis mollis, tellus nulla consectetur libero, et gravida purus nibh vitae neque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque ultricies leo sit amet massa lobortis tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque ligula magna, malesuada id tempus ac, ullamcorper sed massa. Nam elit odio, aliquam ac massa vel, molestie viverra odio.
Aliquam quis sem non odio dictum vehicula. Pellentesque dapibus risus quis ante venenatis, sit amet fringilla nunc bibendum. Morbi ut viverra libero. Duis efficitur risus justo, et ultricies enim cursus non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque et convallis risus, ut ornare turpis. Aenean eu sem eros. Morbi viverra eleifend ante at dignissim. Phasellus in hendrerit purus. Nunc sit amet commodo nisi. Duis sit amet bibendum lacus, non pellentesque ante. Aenean ut sem in nulla pellentesque condimentum tempor et massa. Aenean aliquet, ipsum a pellentesque mollis, justo lorem rhoncus est, eget feugiat tellus nisi et est. Praesent auctor erat at neque venenatis pharetra. Aliquam malesuada aliquam elit et lacinia.
EOD;

    }

    public function it_cuts_first_paragraph_if_it_is_greater_than_limit()
    {
        $text = $this->getTextWithShortParagraph();
        $this::getAbstract($text, 30)->shouldBe(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas, nulla quis dapibus vestibulum, lorem purus euismod diam, in sodales nibh libero vitae ligula. Sed ornare velit id arcu ultricies…'
        )
        ;
    }

}
