<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    /**
     * Create a new policy instance.
     */
   /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // Constructeur vide ou initialisation si nécessaire
    }

    public function update(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }

    public function delete(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
}
