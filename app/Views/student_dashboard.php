<h1>Student Dashboard</h1>

<p>Welcome, student!</p>

<a href="index.php?action=create-permission">Create Permission Request</a>

<br><br>

<h3>Your Permission History</h3>

<?php if (!empty($data)): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['reason'] ?></td>  
                <td><?= $row['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No permission submissions yet.</p>
<?php endif; ?>