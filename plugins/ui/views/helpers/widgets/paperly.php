<?php
	class Paperly
	{

	var $defaults = array('paper' => false, 'width' => 180, 'background' => '#00316D');

	var $Widget;
	
	public function Paperly($widget)
	{
        $this->Widget = $widget;
	}
		public function code($options = array()) {

			$options = array_merge($this->defaults, $options);
			extract($options);
			if (!$paper) {
				return false;
			}
			$code = <<<EOD
<script src="http://widgets.paper.li/javascripts/init.js" type="text/javascript"></script>
<script>
 Paperli.PaperWidget.Show({
   pid: '$paper',
   width: $width,
   background: '$background'
 })
</script>
EOD;
		return $code;
		}
	}
?>
