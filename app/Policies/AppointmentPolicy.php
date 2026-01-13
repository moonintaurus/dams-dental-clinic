<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;

class AppointmentPolicy
{
    public function view(User $user, Appointment $appointment)
    {
        return $user->isAdmin() || $user->isStaff() || $user->id === $appointment->user_id;
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->isAdmin() || $user->isStaff();
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || $user->isAdmin();
    }
}