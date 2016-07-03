<form method="GET" action="index.php">
	<p>INVENTORY:</p>
	<div class="no-print">
		<input type="text" placeholder="NAME?" name="name" />
		<input type="date" name="date" />
	  	<input type="submit" name="filter" />
	</div>
</form>

<hr />

<?php $this->loadFeedback(); if (!empty($data)) { ?>
	<table class="sortable" style="width:100%;">
	  <thead>
	  	<tr>
	  		<th>NAME</th>
	  		<th>DATE</th>
	  		<th class="sorttable_nosort no-print">ACTIONS</th>
	  	</tr>
	  </thead>
	  <tbody>
	    <?php foreach ($data as $dat) { ?>
			<tr style="text-align: center;">
				<td><?php echo $dat['name']; ?></td>
				<td><?php echo date_format(date_create($dat['datetime']), 'F j, Y'); ?></td>
				<td class="no-print"><a href="index.php?action=delete&id=<?php echo $dat['id']; ?>"><u>delete</u></a>
			</tr>
		<?php } ?>
	  </tbody>
	</table>
	<hr />
	<button class="no-print" onclick="javascript:window.print();">PRINT ME</button>
<?php } ?>

<script type="text/javascript">
	// var dateTH = document.getElementsByTagName("th")[1];
	// sorttable.innerSortFunction.apply(dateTH, []);
</script>