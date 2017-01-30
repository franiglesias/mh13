<?php
/**
 * AnalyticsHelper automagically adds Google Analytics code to all layouts including $script_for_layout
 * 
 * step 1. In your config.php or similar file 
 * 
 * $config['Analytics']['domain'] = 'your_domain.tld';
 * $config['Analytics']['id'] = 'UA-XXXXXX-X';
 *
 * or bootstrap add
 * 
 * Configure::write('Analytics.domain', 'your_domain.tld');
 * Configure::write('Analytics.id', 'UA-XXXXXX-X');
 *
 * step 2. Add [Gdata.]Analytics to the AppController->helpers array
 * 
 * step 3. There is no step 3
 *
 * @package default
 */
class AnalyticsHelper extends AppHelper {
	var $helpers = array('Html');
	public function afterRender()
	{
		if (!($data = Configure::read('Analytics'))) {
			return false;
		}
		if ($view =& ClassRegistry::getObject('view')) {
			echo $this->render($data['domain'], $data['id']);
		}
	}
	
	public function render($domain, $id)
	{
$script = <<<CODE
 var _gaq = _gaq || [];
 _gaq.push(['_setAccount', '{$id}']);
 _gaq.push(['_setDomainName', '.{$domain}']);
 _gaq.push(['_trackPageview']);

 (function() {
   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();
CODE;
	return $this->Html->scriptBlock($script, array('inline' => false));
	}
}
?>