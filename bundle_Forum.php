<?php
	class bundle_Forum extends Bundle\PackageBase {
		public $menu_title;
		public $includes;
		
		// Inicialize
		public function __construct() {
			$this->menu_title = "Forum";
			
			$this->includes = array(
				"bundle_Forum_DB.php",
				"bundle_ForumSection.php",
				"bundle_ForumThread.php",
				"bundle_ForumPost.php"
			);
		}
		
		// Install
		public function install() {
			if(Bundle\DB::Connect()->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "forum_sections (
				ID int(11) NOT NULL AUTO_INCREMENT,
				Title varchar(200) COLLATE utf8_czech_ci NOT NULL,
				PRIMARY KEY (ID)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;") &&
				Bundle\DB::Connect()->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "forums (
				ID int(11) NOT NULL AUTO_INCREMENT,
				Title varchar(200) COLLATE utf8_czech_ci NOT NULL,
				Section int(11) NOT NULL,
				Moderator int(11) NOT NULL,
				Description varchar(300) COLLATE utf8_czech_ci,
				Allow int(11) NOT NULL,
				PRIMARY KEY (ID)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;") &&
				Bundle\DB::Connect()->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "forum_threads (
				ID int(11) NOT NULL AUTO_INCREMENT,
				Title varchar(200) COLLATE utf8_czech_ci NOT NULL,
				Author int(11) NOT NULL,
				Forum int(11) NOT NULL,
				OnTop int(11) NOT NULL,
				Datetime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 				PRIMARY KEY (ID)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;") &&
				Bundle\DB::Connect()->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "forum_posts (
				ID int(11) NOT NULL AUTO_INCREMENT,
				Datetime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				Author int(11) NOT NULL,
				Thread int(11) NOT NULL,
				Content varchar(5000) COLLATE utf8_czech_ci NOT NULL,
				PRIMARY KEY (ID)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;")) {
				return true;
			}
			
			return false;
		}
		
		public function uninstall() {
			if(Bundle\DB::Connect()->query("DROP TABLE " . DB_PREFIX . "forums") &&
				Bundle\DB::Connect()->query("DROP TABLE " . DB_PREFIX . "forum_threads") &&
				Bundle\DB::Connect()->query("DROP TABLE " . DB_PREFIX . "forum_posts")) {
				return true;
			}
			
			return false;			
		}
	}
