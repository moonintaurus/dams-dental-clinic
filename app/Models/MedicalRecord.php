<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'appointment_id',
    'diagnosis',
    'treatment',
    'prescription'
];

    protected $casts = [
        'next_visit' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // dentist that handled the record
    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}