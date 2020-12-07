<?php namespace App\Models;

use CodeIgniter\Model;

class MaintenanceModel extends Model
{
    public function isUnderMaintenance() {
        $query = $this->db->query("SELECT * FROM maintenance WHERE id = 1");
        $isUnderMaintenance = $query->getResult()[0]->status;
        return $isUnderMaintenance;
    }

    public function getMessage() {
        $query = $this->db->query("SELECT * FROM maintenance WHERE id = 1");
        $isUnderMaintenance = $query->getResult()[0]->message;
        return $isUnderMaintenance;        
    }

    public function updateMessage($message) {
        $this->db->table('maintenance')->where('id',1)->update(['message'=>$message]); 
    }

    public function setStatus($status) {
        $this->db->table('maintenance')->where('id',1)->update(['status'=>$status]); 
    }
}