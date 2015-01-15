<?php

class bundle_ForumSection extends Bundle\DatabaseBase {
	public function __construct($ID) {
		parent::__construct($ID, "forum_sections");
	}
	
	public static function getList() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_sections ORDER BY ID");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumSection($row->ID);
			
		return $a_result;
	}
	
	public function getForums() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forums WHERE Section = " . $this->ID);
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_Forum_DB($row->ID);
			
		return $a_result;
	}
	
	public function count() {
		return count(self::getList());
	}
	
	public static function Create($Title) {
		$connect = Bundle\DB::Connect();
			$Title = $connect->real_escape_string($Title);
		$connect->query("INSERT INTO " . DB_PREFIX . "forum_sections (Title) VALUES ('" . $Title . "')");
		
		return $connect->insert_id;
	}
}
