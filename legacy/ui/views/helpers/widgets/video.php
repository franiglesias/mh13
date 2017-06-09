<?php
/**
 * Video for EveryBody Widget.
 *
 * http://camendesign.com/code/video_for_everybody
 *
 * @version $Rev: 441 $
 *
 * @license MIT License
 *
 * $Id: video.php 441 2010-03-04 11:58:45Z franiglesias $
 *
 * $HeadURL: http://franiglesias@subversion.assembla.com/svn/milhojas/trunk/views/helpers/video.php $
 **/
class Video
{
    public $defaults = array(
        'width' => '400',
        'height' => '300',
        'ieHeight' => 0,
        'flashHeight' => 0,
        'poster' => '',
        'oggFile' => '',
        'mpFile' => '',
        'player' => '/mh13/js/flowplayer/flowplayer.swf',
        'title' => '',
        'download' => false,
        'videoPath' => '',
        'posterExtension' => 'png',
        );

    public $options = array();

    public $Widget;

    public function Video($widget)
    {
        $this->Widget = &$widget;
    }

    public function code($options = array())
    {
        list($type, $subtype) = explode('/', $options['type']);
        if (!in_array($type, array('audio', 'video'))) {
            return false;
        }
        $method = $type.'Template';
        $this->mergeOptions($options);
        $code = $this->$method();
        foreach ($this->options as $key => $value) {
            $placeholder = '__'.strtoupper($key).'__';
            $code = str_replace($placeholder, $value, $code);
        }

        return $code;
    }

    protected function mergeOptions($options)
    {
        // Conventions: video is the file name for both mp4 and ogv video
        // Poster image is named after video and file image extension, by default, png
        // Poster image can be located in the same path as the video or in the img path
        $path = str_replace(env('DOCUMENT_ROOT'), '', WWW_ROOT);
        $file = $options['path'];
        if ($path[strlen($path) - 1] !== '/') {
            $path .= '/';
        }
        $this->defaults['videoPath'] = $path;

        $this->options = array_merge($this->defaults, $options);
        if (empty($this->options['title'])) {
            if (!empty($this->options['name'])) {
                $this->options['title'] = $this->options['name'];
            } else {
                $this->options['title'] = preg_replace('/^.*\/([^.]+)\..*$/', '$1', $file);
            }
        }

        $this->options['title'] .= ' ('.date('i:s', $this->options['playtime']).')';

        if (empty($this->options['mpFile'])) {
            $this->options['mpFile'] = $this->options['videoPath'].$file;
        }

        if (empty($this->options['oggFile'])) {
            $this->options['oggFile'] = $this->options['videoPath'].$file.'.ogg';
        }

        if (empty($this->options['poster'])) {
            $this->options['poster'] = $this->options['videoPath'].$file.'.'.$this->options['posterExtension'];
        }

        $this->options['player'] = JS_URL.'flowplayer/flowplayer.swf';
        $this->options['ieHeight'] = $this->options['height'] + 15;
        $this->options['flashHeight'] = $this->options['height'] + 20;
    }

    /**
     * http://seanooi.net/audio-for-everybody/.
     */
    public function audioTemplate()
    {
        $code = <<<'HTML'
<p class="mh-multimedia-header">__TITLE__</p>
<div class="mh-multimedia">
<audio controls="controls" width="__WIDTH__" height="__HEIGHT__" preload poster="__POSTER__">
	<source src="__MPFILE__" type="audio/mpeg" />
	<source src="__OGGFILE__" type="audio/ogg" />
	<!--[if gt IE 6]>
	<object classid="clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6" width="320" height="45"><!
	[endif]--><!--[if !IE]><!-->
	<object type="audio/mpeg" data="__MPFILE__">
	<!--<![endif]-->
	<param name="url" value="__MPFILE__" />
	<param name="autostart" value="false" />
	<param name="uiMode" value="full" />
	<object height="24" width="100%" type="application/x-shockwave-flash" data="__PLAYER__" id="audioplayer">
	<param name="movie" value="__PLAYER__" />
	<param name="FlashVars" value="playerID=audioplayer&amp;soundFile=__MPFILE__" />
	<img class src="__POSTER__" width="128" height="135" alt="Title" title="No audio playback capabilities, please download the audio below" />
	</object><!--[if gt IE 6]><!-->
	</object><!--<![endif]-->
</audio>
</div>
<!-- <p>Download Audio: <a href="__MPFILE__">Audio Format "MP3"</a> | <a href="__OGGFILE__">Audio Format "OGG"</a></p> -->
HTML;

        return $code;
    }

    public function videoTemplate()
    {
        $code = <<<'HTML'
{<!-- “Video For Everybody” v0.3  http://camendesign.com/code/video_for_everybody
     =================================================================================================================== -->
<!-- first try HTML5 playback. if serving as XML, expand `controls` to `controls="controls"` and autoplay likewise -->
<p class="mh-multimedia-header">__TITLE__</p>
<div class="mh-multimedia">
<video width="__WIDTH__" height="auto" controls preload="preload">
	<source src="__MPFILE__" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
	<source src="__OGGFILE__" type='video/ogg; codecs="theora, vorbis"' />
	<!-- IE only QuickTime embed: IE6 is ignored as it does not support `<object>` in `<object>` so we skip QuickTime
	     and go straight to Flash further down. the line break after the `classid` is required due to a bug in IE -->
	<!--[if gt IE 6]>
	<object width="__WIDTH__" height="__IEHEIGHT__" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" scale="aspect"><!
	[endif]-->
	<!-- non-IE QuickTime embed (hidden from IE): the self-closing comment tag allows non-IE browsers to
	     see the HTML whilst being compatible with serving as XML -->
	<!--[if !IE]><!-->
	<object width="__WIDTH__" height="__IEHEIGHT__" type="video/quicktime" data="__MPFILE__" scale="aspect">
	<!--<![endif]-->
	<param name="src" value="__MPFILE__" />
	<param name="showlogo" value="false" />
	<!-- fallback to Flash -->
	<object width="__WIDTH__" height="__FLASHHEIGHT__" type="application/x-shockwave-flash"
		data="__PLAYER__?image=__POSTER__&amp;file=__MPFILE__">
		<!-- Firefox uses the `data` attribute above, IE/Safari uses the param below -->
		<param name="movie" value="__PLAYER__?image=__POSTER__&amp;file=__MPFILE__&amp;stretching=uniform" />
		<!-- fallback image. download links are below the video. warning: putting anything more than
		     the fallback image in the fallback may trigger an iPhone OS3+ bug where the video will not play -->
		<img src="__POSTER__" width="__WIDTH__" height="__HEIGHT__" alt="Title of video"
		     title="No video playback capabilities, please download the video below"
		/>
	</object><!--[if gt IE 6]><!-->
	</object><!--<![endif]-->

</video>
<!-- you *must* offer a download link as they may be able to play the file locally -->
<!-- <p>Download Video: <a href="__MPFILE__">High Quality “MP4”</a> | <a href="__OGGFILE__">Low Quality “OGG”</a></p> -->
</div>}
HTML;

        return $code;
    }
}
