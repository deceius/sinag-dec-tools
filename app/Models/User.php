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
        'is_officer',
        'is_build_officer',
        'is_regear_officer'
    ];

    public function getUrlAttribute() {
        return url('member/'.$this->getKey());
    }

    function getIsOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $regearOfficerRole = config('app.discord_roles.officer.regear');
        $buildsOfficerRole = config('app.discord_roles.officer.builds');

        return in_array($regearOfficerRole, $roles) || in_array($buildsOfficerRole, $roles);
    }

    function getIsBuildOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $buildsOfficerRole = config('app.discord_roles.officer.builds');

        return in_array($buildsOfficerRole, $roles);
    }

    function getIsRegearOfficerAttribute(){
        $roles = explode(",", $this->roles);
        $regearOfficerRole = config('app.discord_roles.officer.regear');

        return in_array($regearOfficerRole, $roles) ;
    }

    function getMemberTierAttribute(){
        $roles = explode(",", $this->roles);
        if (in_array(config('app.roles.mentor'), $roles)) {
            return "Mentor";
        }
        elseif (in_array(config('app.roles.core'), $roles)) {
            return "Core";
        }
        elseif (in_array(config('app.roles.senior'), $roles)) {
            return "Senior";
        }
        elseif (in_array(config('app.roles.sinag'), $roles)) {
            return "Sinag";
        }
        elseif (in_array(config('app.roles.trial'), $roles)) {
            return "Trial";
        }
        else {
            return "";
        }
    }



}
