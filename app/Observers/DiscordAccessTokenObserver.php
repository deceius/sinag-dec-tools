<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Jakyeru\Larascord\Models\DiscordAccessToken;

class DiscordAccessTokenObserver
{
    /**
     * Handle the DiscordAccessToken "created" event.
     */
    public function created(DiscordAccessToken $discordAccessToken): void
    {
        Auth::user()->refreshRoles();

    }

    /**
     * Handle the DiscordAccessToken "updated" event.
     */
    public function updated(DiscordAccessToken $discordAccessToken): void
    {
        Auth::user()->refreshRoles();
    }

    /**
     * Handle the DiscordAccessToken "deleted" event.
     */
    public function deleted(DiscordAccessToken $discordAccessToken): void
    {
        //
    }

    /**
     * Handle the DiscordAccessToken "restored" event.
     */
    public function restored(DiscordAccessToken $discordAccessToken): void
    {
        //
    }

    /**
     * Handle the DiscordAccessToken "force deleted" event.
     */
    public function forceDeleted(DiscordAccessToken $discordAccessToken): void
    {
        //
    }
}
