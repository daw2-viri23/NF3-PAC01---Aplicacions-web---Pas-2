<?php

class Config {
	private $LOGGER_LEVEL = 75;
	private $DEBUG_LEVEL = 100;
	private $LOGGER_FILE = 'C:\Users\Administrator\Desktop\pruebaphp\pruebaphp2.txt';

	public function getConfigLevel() {
		return $this->LOGGER_LEVEL;
	}
		
	public function getConfigFile() {
		return $this->LOGGER_FILE;
	}

	public function addConfig($constLog, $value) {
		
		if($constLog == 'LOGGER_LEVEL') {
			$this->LOGGER_LEVEL = $value;
		}
		else if ($constLog == 'DEBUG_LEVEL') {
			$this->DEBUG_LEVEL = $value;
		}
		else {
			$this->LOGGER_FILE = $value;
			echo 'save value final path.';
		}
	}
} 
?>