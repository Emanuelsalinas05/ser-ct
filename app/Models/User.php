<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                            'id',
                            'id_ct',
                            'name',
                            'email',
                            'password',
                            'orfc',
                            'ocurp',
                            'id_ct',
                            'oct',
                            'id_ctorigen',
                            'octorigen',
                            'omodalidad',
                            'opwd',
                            'orol',
                            'ocargo',
                            'ovalle',
                            'onombre_ct',
                            'onivel',
                            'ocorreo',
                            'status',
                        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'orol',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'id_ct', 'kcvect');
    }
    
    public function roluser() {
        return $this->belongsTo(Rolesusers::class, 'orol', 'id');
    }

    public function datosacta() {
        return $this->belongsTo(DatosActa::class, 'id', 'id_user');
    }

    public function titular() {
        return $this->belongsTo(Ctitulares::class, 'id_ct', 'id_ct');
    }



    public function adminlte_image()
    {
        return 'img/userIcon.jpg';
    }

    public function adminlte_desc()
    {
        return 'Hola';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

}
