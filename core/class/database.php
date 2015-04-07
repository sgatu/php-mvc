<?php

	class Database{
		protected $db;
		public function Database()
		{
			$this->db = new medoo(unserialize(CONFIG_DB));
		}
	}

?>