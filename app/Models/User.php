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

}
