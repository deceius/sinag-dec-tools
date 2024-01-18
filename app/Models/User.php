<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jakyeru\Larascord\Traits\InteractsWithDiscord;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithDiscord;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'global_name',
        'discriminator',
        'email',
        'avatar',
        'verified',
        'banner',
        'banner_color',
        'accent_color',
        'locale',
        'mfa_enabled',
        'premium_type',
        'public_flags',
        'roles',
        'ao_character_id',
        'ao_character_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'global_name' => 'string',
        'discriminator' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'verified' => 'boolean',
        'banner' => 'string',
        'banner_color' => 'string',
        'accent_color' => 'string',
        'locale' => 'string',
        'mfa_enabled' => 'boolean',
        'premium_type' => 'integer',
        'public_flags' => 'integer',
        'roles' => 'json',
    ];

    protected $appends = [
        'url',
        'member_tier',
        'member_tier_icon',
        'is_officer',
        'is_build_officer',
        'is_regear_officer'
    ];

    public function getUrlAttribute() {
        return url('member/'.$this->getKey());
    }

    function getIsOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $regearOfficerRole = env('OFFICER_REGEAR_DISCORD_ROLE');
        $buildsOfficerRole = env('OFFICER_BUILDS_DISCORD_ROLE');

        return in_array($regearOfficerRole, $roles) || in_array($buildsOfficerRole, $roles);
    }

    function getIsBuildOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $buildsOfficerRole = env('OFFICER_BUILDS_DISCORD_ROLE');

        return in_array($buildsOfficerRole, $roles);
    }

    function getIsRegearOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $regearOfficerRole = env('OFFICER_REGEAR_DISCORD_ROLE');

        return in_array($regearOfficerRole, $roles) ;
    }

    function getMemberTierAttribute(){
        $roles = explode(",", $this->roles);
        if (in_array(env('MEMBER_ROLE_MENTOR'), $roles)) {
            return "Mentor";
        }
        elseif (in_array(env('MEMBER_ROLE_CORE'), $roles)) {
            return "Core";
        }
        elseif (in_array(env('MEMBER_ROLE_SENIOR'), $roles)) {
            return "Senior";
        }
        elseif (in_array(env('MEMBER_ROLE_SINAG'), $roles)) {
            return "Sinag";
        }
        elseif (in_array(env('MEMBER_ROLE_TRIAL'), $roles)) {
            return "Trial";
        }
        else {
            return "";
        }
    }

    function getMemberTierIconAttribute(){
        $roles = explode(",", $this->roles);
        if (in_array(env('MEMBER_ROLE_MENTOR'), $roles)) {
            return "🎖️";
        }
        elseif (in_array(env('MEMBER_ROLE_CORE'), $roles)) {
            return "⚔️";
        }
        elseif (in_array(env('MEMBER_ROLE_SENIOR'), $roles)) {
            return "🛡️";
        }
        elseif (in_array(env('MEMBER_ROLE_SINAG'), $roles)) {
            return "☀️";
        }
        elseif (in_array(env('MEMBER_ROLE_TRIAL'), $roles)) {
            return "🌱";
        }
        else {
            return "";
        }
    }

}
