<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Predis\Response\Status;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message', 'heure', 'date'
    ];


    public function getMessagesByUser($emetteurId, $recepteurId)
    {
        return $this->where(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $recepteurId)
                  ->where('emetteur_id', $emetteurId);
        })
        ->orWhere(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $emetteurId)
                  ->where('emetteur_id', $recepteurId);
        })
        ->orderBy('id', 'ASC')
        ->get();
    }

    public function getCountMessagesByStatus($emetteurId, $recepteurId, $status)
    {
        return $this->Where(function ($query) use ($emetteurId, $recepteurId, $status) {
            $query->where('recepteur_id', $emetteurId)
                  ->where('emetteur_id', $recepteurId)
                  ->where("status", $status);
        })
        ->count();
    }

    public function getLastMessagesByUser($emetteurId, $recepteurId)
    {
        return $this->where(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $recepteurId)
                  ->where('emetteur_id', $emetteurId);
        })
        ->orWhere(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $emetteurId)
                  ->where('emetteur_id', $recepteurId);
        })
        ->orderBy('id', 'DESC')
        ->limit(1)
        ->first();
    }

    public function setStatusMessagesIsNull($emetteurId, $recepteurId, $status)
    {
        return $this->Where(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $emetteurId)
                  ->where('emetteur_id', $recepteurId)
                  ->whereNull('status');
        })
        ->orWhere(function ($query) use ($emetteurId, $recepteurId) {
            $query->where('recepteur_id', $emetteurId)
                  ->where('emetteur_id', $recepteurId)
                  ->Where('status', 1);
        })
        ->update(['status' => $status]);
    }

}
