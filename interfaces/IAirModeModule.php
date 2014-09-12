<?php

interface IAirModeModule {

	/**
	 * Called to register the module with the front end
	 * Expected to register scripts, css, and any front end code needed
	 * @return [type] [description]
	 */
	public function registerWithFrontEnd();
}