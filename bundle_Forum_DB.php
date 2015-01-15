<?php

class bundle_Forum_DB extends Bundle\DatabaseBase {
	public function __construct($ID) {
		parent::__construct($ID, "forums");
	}
	
	public static function getList() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forums ORDER BY ID");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_Forum_DB($row->ID);
			
		return $a_result;
	}
	
	public function count() {
		return count(self::getList());
	}
	
	public function getThreads() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_threads WHERE Forum = " . $this->ID . " ORDER BY Datetime DESC");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumThread($row->ID);
			
		return $a_result;
	}
	
	public static function Create($Title, $Section, $Moderator, $Description, $Allow) {
		$connect = Bundle\DB::Connect();
		
			$Title = $connect->real_escape_string($Title);
			$Section = (int)$Section;
			$Moderator = (int)$Moderator;
			$Description = $connect->real_escape_string($Description);
			$Allow = (int)$Allow;
		
		$connect->query("INSERT INTO " . DB_PREFIX . "forums (Title, Section, Moderator, Description, Allow) 
			VALUES ('" . $Title . "', " . $Section . ", " . $Moderator . ", '" . $Description . "', " . $Allow . ")");
			
		return $connect->insert_id;
	}
}
