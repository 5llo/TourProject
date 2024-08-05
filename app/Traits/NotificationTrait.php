<?php
namespace App\Traits;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait NotificationsTrait
{
    /**
     * Define a polymorphic relation to notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
