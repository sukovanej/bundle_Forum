<style>
	table.forum_table {width:100%;}
	table.forum_table tr td.section {background-color:#1E90FF; color:#fff; font-size:18px; border-bottom:5px solid #235586;}
	table.forum_table tr:hover td.section {background-color:#4AA6FF;}
	table.forum_table tr td, table.forum_table tr th {padding:10px; border-right:1px solid #aaa; vertical-align:middle;}
	table.forum_table tr th:last-child, table.forum_table tr td:last-child {border-right:0;}
	table.forum_table tr {border-bottom:1px solid #eee;}
	table.forum_table tr:last-child {border-bottom:5px solid #235586;}
	table.forum_table tr th {text-align:left; background-color:#eee; color:#1E90FF; border-bottom:1px solid #aaa; font-size:17px;}
	
	table.forum_table tr:hover td {background-color:#fafafa;}
	
	small {font-size:13px; color:#999; line-height:0.9em;}
	.forum_title {font-size:15px; font-weight:bold; line-height:0.9em; margin-bottom:0;}
	
	.panel {padding:5px; margin-bottom:10px; border-radius:3px;}
	.panel a {line-height:1em; display:inline-block;}
	.panel a img {width:20px; margin:-1px 3px; float:left;}
	.panel a:hover img {opacity:0.7;}
	
	.info_p {background-color:#FFFFAB; border:1px solid #E8E85F;}
	.done_p {background-color:#ACFFAB; border:1px solid #5FE85F; color:#2D7D2D;}
	.error_p {background-color:#FFABAD; border:1px solid #E85F62; color:#A52A2A;}
	
	.f_right {float:right;}
	.red {color:#BC0505 !important;}
	
	table.post {border:1px solid #ccc; width:100%; margin-bottom:10px;}
	table.post tr td {border-right:1px solid #bbb; padding:5px; vertical-align:top; }
	table.post tr td * {font-size:14px !important;}
	.post_info {border-top:1px solid #bbb; text-align:right;}
	.post_info a {cursor:pointer; margin-left:5px;}
	.post_author_photo {width:120px; margin:5px 15px; border-radius:50%;}
	.post_author {text-align:center; font-weight:bold;}
	
	.post_author_td {width:150px; background-color:#eee; text-align:center;}
	.post_author_td span {display:block;}
	
	.prizes img {width:30px;}
	.content {padding:15px !important; font-size:12px !important;}
	.content blockquote {border-left:5px solid #aaa; margin:10px; padding:4px; background-color:#eee;}
	.content blockquote p {color:#666 !important; padding:10px; margin:0 !important;}
	
	.pager {background-color:#eee; padding:5px; border-radius:3px; border-top:1px solid #ccc;}
	.pager > a {background-color:#333; padding:2px 7px; border-radius:3px; color:#fff !important;}
	.pager a:hover {background-color:#555;}
	.pager a.selected_pager {background-color:#1C6BB8;}
</style>
<?php $parser = new Bundle\GetParser(); ?>
<h1>Forum</h1>
<div class="panel info_p">
	<strong>Umístění</strong> &rarr; <a href="forum">Forum</a>
	<?php if(isset($parser->forum)): ?>
	 » <a href="?forum=<?= $parser->forum ?>"><?= (new bundle_Forum_DB($parser->forum))->Title ?></a>
	<?php endif; if(isset($parser->thread)): ?>
	 » <a href="?forum=<?= $parser->forum ?>&thread=<?= (new bundle_ForumThread($parser->thread))->ID ?>"><?= (new bundle_ForumThread($parser->thread))->Title ?></a>
	<?php endif; ?>
	
	<div class="f_right">
		<a href="?create_thread"><img src="<?= HPackage::GetPath("bundle_Forum") ?>/img/create.png">Vytvořit nové vlákno</a> &nbsp;
		<a href="?search"><img src="<?= HPackage::GetPath("bundle_Forum") ?>/img/search.png">Hledat</a> &nbsp;
		<a href="uzivatelske-ucty"><img src="<?= HPackage::GetPath("bundle_Forum") ?>/img/users.png">Uživatelé</a>
	</div>
</div>
<?php 
	if (isset($parser->delete)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/delete.php"); 
	} else if (isset($parser->thread)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/thread.php"); 
	} else if (isset($parser->search)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/search.php"); 
	} else if (isset($parser->forum)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/forum.php"); 
	} else if (isset($parser->thread)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/thread.php"); 
	} else if (isset($parser->create_thread)) { 
		require(HPackage::GetPath("bundle_Forum") . "/layout/create_thread.php"); 
	} else {
		require(HPackage::GetPath("bundle_Forum") . "/layout/main.php"); 
	}
?>
