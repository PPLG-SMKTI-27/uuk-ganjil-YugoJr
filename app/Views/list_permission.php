<h3>Permission List</h3>
<?php foreach($data as $row): ?>
<div style="border:1px solid #aaa;margin:10px;padding:10px;">
<b>User:</b> <?= $row['username'] ?><br>
<b>Reason:</b> <?= $row['reason'] ?><br>
<b>Status:</b> <?= $row['status'] ?><br>


<?php if($_SESSION['role_id'] == 2): ?>
<?php $id = $row['id']; include 'update_status.php'; ?>
<?php endif; ?>
</div>
<?php endforeach; ?>