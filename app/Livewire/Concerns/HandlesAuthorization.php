<?php

namespace App\Livewire\Concerns;

use Illuminate\Auth\Access\AuthorizationException;

trait HandlesAuthorization
{
    public function authorizeAction(callable $callback, ?callable $onDenied = null)
    {
        try {
            return $callback();

        } catch (AuthorizationException $e) {

            if ($onDenied) {
                return $onDenied($e);
            }

            $this->dispatch(
                'notify',
                title: 'Akses ditolak',
                message: 'Anda tidak memiliki izin untuk melakukan aksi ini.',
                type: 'error'
            );

            return null;
        }
    }
}
