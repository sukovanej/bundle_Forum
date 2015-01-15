<?php

class bundle_ForumPost extends Bundle\DatabaseBase {
	public function __construct($ID) {
		parent::__construct($ID, "forum_posts");
		
		$this->Datetime = (new DateTime($this->Datetime))->format('d. m. Y H:i');
		$this->Content = 
			self::codeParser(
			self::hyperLinkParser(
				$this->Content));
	}
	
	public static function hyperLinkParser($s) {
		return preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0" target="_blank">$0</a>', $s);
	}
	
	public static function codeParser($s) {
		return preg_replace('/^\?(.*)\?$/', '<pre><code class="language-php">$0</code></pre>', $s);
	}
	
	public function getThread() {
		return new bundle_ForumThread($this->Thread);
	}
	
	public static function getList() {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_posts ORDER BY Datetime DESC");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumPost($row->ID);
			
		return $a_result;
	}
	
	public function count() {
		return count(self::getList());
	}
	
	public static function Create($Author, $Thread, $Content) {
		$connect = Bundle\DB::Connect();
		
			$Content = $connect->real_escape_string($Content);
			$Thread = (int)$Thread;
			$Author = (int)$Author;
			
		$connect->query("INSERT INTO " . DB_PREFIX . "forum_posts (Author, Thread, Content) VALUES (" . $Author . ", " . $Thread . ", '" . $Content . "')");
		return $connect->insert_id;
	}
	
	public static function GetByAuthor($id) {
		$result = Bundle\DB::Connect()->query("SELECT ID FROM " . DB_PREFIX . "forum_posts WHERE Author = " . (int)$id . " ORDER BY Datetime DESC");
		$a_result = array();
		
		while($row = $result->fetch_object())
			$a_result[] = new bundle_ForumPost($row->ID);
			
		return $a_result;
	}
}
