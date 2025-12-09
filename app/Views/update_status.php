<form method="POST" action="?action=update-status">
<input type="hidden" name="id" value="<?= $id ?>">
<select name="status">
<option>Pending</option>
<option>Accepted</option>
<option>Not Accepted</option>
</select>
<button type="submit">Update</button>
</form>