<?php

namespace App\Observers;

use App\OrderNote;

class OrderNoteObserver
{
    /**
     * Handle the Comment "creating" event.
     *
     * @param  \App\OrderNote  $ordernote
     * @return void
     */
    public function creating(OrderNote $ordernote)
    {
        $ordernote->user_id = auth()->user()->id;
    }
}
