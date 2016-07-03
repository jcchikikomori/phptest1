<form method="GET" action="index.php?action=filter">
    <p>INVENTORY:</p>
    <input type="text" placeholder="NAME?" name="name" />
    <input type="date" name="date" />
    <input type="submit" name="filter" />
</form>

<hr />

<h4>SRSLY??</h4>
<?php $this->loadFeedback(); ?>