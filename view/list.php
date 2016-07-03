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
	<table>
	  <thead>
	  	<tr>
	  		<th>NAME</th>
	  		<th>DATE</th>
	  		<th>ACTIONS</th>
	  	</tr>
	  </thead>
	  <tbody>
	    <?php foreach ($data as $dat) { ?>
			<tr>
				<td><?php echo $dat['name']; ?></td>
				<td><?php echo $dat['datetime']; ?></td>
				<td><a href="index.php?action=delete&id=<?php echo $dat['id']; ?>"><u>delete</u></a>
			</tr>
		<?php } ?>
	  </tbody>
	</table>
	<hr />
	<button onclick="javascript:window.print();">PRINT ME</button>
<?php } ?>