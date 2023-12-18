<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jakyeru\Larascord\Models\DiscordAccessToken;

class DiscordAccessTokenObserver
{
    /**
     * Handle the DiscordAccessToken "created" event.
     */
    public function created(DiscordAccessToken $discordAccessToken): void
    {
        $this->refreshRoles($discordAccessToken->user_id);

    }

    /**
     * Handle the DiscordAccessToken "updated" event.
     */
    public function updated(DiscordAccessToken $discordAccessToken): void
    {
        $this->refreshRoles($discordAccessToken->user_id);
    }

    /**
     * Handle the DiscordAccessToken "deleted" event.
     */
    public function deleted(DiscordAccessToken $discordAccessToken): void
    {
        $this->refreshRoles($discordAccessToken->user_id);
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

    private function refreshRoles($id) {
        $user = User::find($id);
        $guildMember = $user->getGuildMember(1181672424836706355);
        $roles = collect($guildMember->roles)->implode(",");
        $user->roles = $roles;
        $user->save();
    }
}
