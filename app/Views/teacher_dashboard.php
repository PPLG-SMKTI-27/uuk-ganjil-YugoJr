<h2>Teacher Dashboard</h2>
<?php foreach($data as $row): ?>
<div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
<b>Student:</b> <?= $row['username'] ?><br>
<b>Reason:</b> <?= $row['reason'] ?><br>
<b>Status:</b> <?= $row['status'] ?><br><br>


<form method="POST" action="?action=teacher-update-status">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<select name="status">
<option <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
<option <?= $row['status']=='Accepted'?'selected':'' ?>>Accepted</option>
<option <?= $row['status']=='Not Accepted'?'selected':'' ?>>Not Accepted</option>
</select>
<button type="submit">Update</button>
</form>
</div>
<?php endforeach; ?>