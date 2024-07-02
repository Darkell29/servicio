<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Auth\Access\HandlesAuthorization;

class VentaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the venta.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Venta $venta)
    {
        return $user->hasRole('administrador');
    }
}
