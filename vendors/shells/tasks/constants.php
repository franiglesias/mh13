<?php

/**
* 
*/
class ConstantsTask extends AppShell
{

	public function execute()
	{
		$this->hr();
		$this->out('CakePHP CONSTANTS');
		$this->hr();
		$this->out('CAKE:             '. CAKE);
		$this->out('CAKE_CORE_INCL...:'. CAKE_CORE_INCLUDE_PATH);
		$this->out('APP:              '. APP);
		$this->out('APP_DIR:          '. APP_DIR);
		$this->out('ROOT:             '. ROOT);
		$this->out('WWW_ROOT:         '. WWW_ROOT);
		$this->out('WEBROOT_DIR:      '. WEBROOT_DIR);
		$this->hr();
		$this->out('MVC paths');
		$this->hr();
		$this->out('MODELS:           '. MODELS);
		$this->out('  BEHAVIORS:      '. BEHAVIORS);
		$this->out('CONTROLLERS:      '. CONTROLLERS);
		$this->out('  COMPONENTS:     '. COMPONENTS);
		$this->out('VIEWS:            '. VIEWS);
		$this->out('  HELPERS:        '. HELPERS);
		$this->out('  LAYOUTS:        '. LAYOUTS);
		$this->out('  ELEMENTS:       '. ELEMENTS);
		$this->hr();
		$this->out('Libraries, configs and assets');
		$this->hr();
		$this->out('CONFIGS:          '. CONFIGS);
		$this->out('APPLIBS:          '. APPLIBS);
		$this->out('LIBS (CAKE):      '. LIBS);
		$this->out('CSS:              '. CSS);
		$this->out('JS:               '. JS);
		$this->out('IMAGES:           '. IMAGES);
		$this->out('CONSOLE_LIBS:     '. CONSOLE_LIBS);
		$this->hr();
		$this->out('TESTS');
		$this->hr();
		$this->out('TESTS:            '. TESTS);
		$this->out('CAKE_TESTS:       '. CAKE_TESTS);
		$this->out('CAKE_TESTS_LIB:   '. CAKE_TESTS_LIB);
		$this->out('CONTROLLER_TESTS: '. CONTROLLER_TESTS);
		$this->out('COMPONENT_TESTS:  '. COMPONENT_TESTS);
		$this->out('HELPER_TESTS:     '. HELPER_TESTS);
		$this->out('MODEL_TESTS:      '. MODEL_TESTS);
		$this->out('LIB_TESTS:        '. LIB_TESTS);
		$this->hr();
		$this->out('TMP folders');
		$this->hr();
		$this->out('TMP:              '. TMP);
		$this->out('LOGS:             '. LOGS);
		$this->out('CACHE:            '. CACHE);
		$this->out('VENDORS:          '. VENDORS);
		$this->hr();
		$this->out('URL');
		$this->hr();
		// $this->out('FULL_BASE_URL:    '. FULL_BASE_URL);
		$this->out('IMAGES_URL:       '. IMAGES_URL);
		$this->out('CSS_URL:          '. CSS_URL);
		$this->out('JS_URL:           '. JS_URL);

	}

}


?>
