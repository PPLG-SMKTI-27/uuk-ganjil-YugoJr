<?php
class Permission {
private $conn;
public $id;
public $user_id;
public $reason;
public $status;


public function __construct($db){ $this->conn = $db; }


public function create(){
// Defensive validation to avoid inserting invalid data
if (empty($this->user_id)) {
    throw new InvalidArgumentException('user_id is required');
}
if ($this->reason === null || trim($this->reason) === '') {
    throw new InvalidArgumentException('reason is required');
}

$stmt = $this->conn->prepare("INSERT INTO permissions(user_id, reason) VALUES(?,?)");
return $stmt->execute([$this->user_id, $this->reason]);
}


public function readAll(){
$stmt = $this->conn->prepare("SELECT p.*, u.username FROM permissions p JOIN users u ON p.user_id=u.id ORDER BY p.id DESC");
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function readByUser($user_id){
$stmt = $this->conn->prepare("SELECT * FROM permissions WHERE user_id=? ORDER BY id DESC");
$stmt->execute([$user_id]);
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function updateStatus(){
$stmt = $this->conn->prepare("UPDATE permissions SET status=? WHERE id=?");
return $stmt->execute([$this->status, $this->id]);
}


public function delete(){
$stmt = $this->conn->prepare("DELETE FROM permissions WHERE id=?");
return $stmt->execute([$this->id]);
}
}