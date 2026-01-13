<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'dentist_id', 'service_id', 
        'appointment_date', 'appointment_time', 'status', 'notes'
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }
}