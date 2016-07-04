<?php $this->loadFeedback(); if (!empty($data)) { ?>
	<table class="sortable" style="width:100%;">
	  <thead>
	  	<tr>
	  		<th>CASE NO.</th>
	  		<th>ACCUSED NAME</th>
	  		<th>FILED DATE</th>
	  		<th>CASE CHARGE</th>
	  		<th>POSS. MAX. PENALTY</th>
	  		<th>BONDED</th>
	  		<th>DATE ARRANGED</th>
	  		<th>LAST TRIAL DATE</th>
	  		<th>STATUS</th>
	  		<th>BUNDLE NUMBER</th>
	  		<th class="sorttable_nosort no-print">ACTIONS</th>
	  	</tr>
	  </thead>
	  <tbody>
	    <?php foreach ($data as $dat) { ?>
			<tr style="text-align: center;">
				<td><?php echo $dat['id']; ?></td>
				<td><?php echo $dat['accused_name']; ?></td>
				<td><?php echo date_format(date_create($dat['filed_date']), 'F j, Y'); ?></td>
				<td><?php echo $dat['charges']; ?></td>
				<td><?php echo $dat['penalty']; ?></td>
				<td><?php echo (($dat['bonded'] == 1) ? 'Yes' : 'No'); ?></td>
				<td><?php echo date_format(date_create($dat['arranged_date']), 'F j, Y'); ?></td>
				<td><?php echo date_format(date_create($dat['last_trial_date']), 'F j, Y'); ?></td>
				<td><?php echo $dat['status']; ?></td>
				<td><?php echo $dat['bundle_no']; ?></td>
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
