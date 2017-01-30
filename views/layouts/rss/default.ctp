<?php echo $this->Rss->header(); ?> 
<?php 
if (!isset($documentData)) {
	$documentData = array('xmlns:atom' => "http://www.w3.org/2005/Atom");
}
if (!isset($channelData)) {
	$channelData = array();
}
if (!isset($channelData['title'])) {
	$channelData['title'] = $title_for_layout;
}
$channelData['atom:link'] = array('attrib' => array(
	'href' => Router::url(null, true),
	'rel' => 'self',
	'type' => 'application/rss+xml'
));
$channelData['docs'] = 'http://blogs.law.harvard.edu/tech/rss';

$channel = $this->Rss->channel(array(), $channelData, $content_for_layout);
echo $this->Rss->document($documentData,$channel);
?> 