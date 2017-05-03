<?php

namespace spec\Mh13\shared\web\twig\filter;

use Mh13\shared\web\twig\filter\Humanizer;
use PhpSpec\ObjectBehavior;


class HumanizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Humanizer::class);
    }

    public function it_humanizes_file_sizes_of_whole_gigabytes()
    {
        $size = 3 * pow(2, 30);
        $this::humanizeFileSize($size)->shouldBe('3.00 GB');
    }

    public function it_humanizes_file_sizes_of_float_gigabytes()
    {
        $size = 3.25 * pow(2, 30);
        $this::humanizeFileSize($size)->shouldBe('3.25 GB');
    }

    public function it_humanizes_file_sizes_of_whole_megabytes()
    {
        $size = 3 * pow(2, 20);
        $this::humanizeFileSize($size)->shouldBe('3.00 MB');
    }

    public function it_humanizes_file_sizes_of_float_megabytes()
    {
        $size = 3.45 * pow(2, 20);
        $this::humanizeFileSize($size)->shouldBe('3.45 MB');
    }

    public function it_humanizes_file_sizes_of_whole_kilobytes()
    {
        $size = 3 * pow(2, 10);
        $this::humanizeFileSize($size)->shouldBe('3.00 KB');
    }

    public function it_humanizes_file_sizes_of_float_kilobytes()
    {
        $size = 3.45 * pow(2, 10);
        $this::humanizeFileSize($size)->shouldBe('3.45 KB');
    }

    public function it_humanizes_file_sizes_of_sizes_under_kb()
    {
        $size = 974;
        $this::humanizeFileSize($size)->shouldBe('974 B');
    }

    public function it_humanizes_play_times_under_one_minute()
    {
        $playtime = 47;
        $this::humanizePlayTime($playtime)->shouldBe('00:47');

    }

    public function it_humanizes_play_times_under_one_hour()
    {
        $playtime = 2594;
        $this::humanizePlayTime($playtime)->shouldBe('43:14');

    }

    public function it_humanizes_play_times_over_one_hour()
    {
        $playtime = 4581;
        $this::humanizePlayTime($playtime)->shouldBe('01:16:21');

    }

    public function it_humanizes_file_names()
    {
        $file = 'example_of_file_name';
        $this::humanizeFileName($file)->shouldBe('Example of file name');
    }
}
