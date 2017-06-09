<?php

	interface FileBinderStrategyInterface {
		public function bind(UploadedFileInterface $File, FileDispatcherInterface $Dispatcher);
	}

?>