<table>
	<tr><td style="text-align:center;">
	<form method="POST">
		<input type="text" placeholder="Hledejte ve fóru" name="search_content" />
		<input type="submit" value="Hledat" name="search_submit" />
	</form>
	</td></tr>
</table>

<br />
<hr />
<br />

<?php if (isset($_POST["search_submit"])): ?>
<?php
	$mysql = Bundle\DB::Connect();
		$search = $mysql->real_escape_string($_POST["search_content"]);
	$result = $mysql->query("SELECT Thread FROM " . DB_PREFIX . "forum_posts WHERE Content LIKE '%" . $search . "%' GROUP BY (Thread)");
?>
<h2>Výsledek hledání</h2>
<table>
	<tr>
		<th>Vlákno</th>
		<th>Fórum</th>
	</tr>
	<?php while($row = $result->fetch_object()): $obj = new bundle_ForumThread($row->Thread) ?>
		<tr>
			<td><a href="?forum=<?= $obj->Forum ?>&thread=<?= $obj->ID ?>"><?= $obj->Title ?></a></td>
			<td><a href="?forum=<?= $obj->Forum ?>"><?= (new bundle_Forum_DB($obj->Forum))->Title ?></a></td>
		</tr>
	<?php endwhile; ?>
</table>
<?php endif; ?>
