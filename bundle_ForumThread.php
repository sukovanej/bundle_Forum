<?php

class bundle_ForumThread extends Bundle\DatabaseBase {
	public function __construct($ID) {
		parent::__construct($ID, "forum_threads");
		$this->Datetime = (new DateTime($this->Datetime))->format('d. m. Y H:i');
	}
	
	public static function getList() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_threads ORDER BY OnTop, Datetime ASC");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumThread($row->ID);
			
		return $a_result;
	}
	
	public function getForum() {
		return new bundle_Forum_DB($this->Forum);
	}
	
	public function getPosts() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_posts WHERE Thread = " . $this->ID);
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumPost($row->ID);
			
		return $a_result;
	}
	
	public function Delete() {
		parent::Delete();
		
		Bundle\DB::Connect()->query("DELETE FROM " . DB_PREFIX . "forum_posts WHERE Thread = " . $this->ID);
	}
	
	public function count() {
		return count(self::getList());
	}
	
	public static function Create($Title, $Author, $Forum, $OnTop) {
		$result = Bundle\DB::Connect();
			
			$Title = $result->real_escape_string($Title);
			$Author = (int)$Author;
			$Forum = (int)$Forum;
			$OnTop = (int)$OnTop;
			
		$result->query("INSERT INTO " . DB_PREFIX . "forum_threads (Title, Author, Forum, OnTop) 
			VALUES ('" . $Title . "', " . $Author . ", " . $Forum . ", " . $OnTop . ")");
			
		return $result->insert_id;
	}
}
