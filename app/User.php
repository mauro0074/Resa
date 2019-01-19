<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO ='0';


    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'verification_token', 
        'admin',
    ];

    //MUTADORES de Name, llevamos a minusculas: cambiar a myusculas o a minusculas antes de insertar en la base de datos
    public function setNameAtribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    //MUTADORES de Email, llevamos a minusculas : cambiar a myusculas o a minusculas antes de insertar en la base de datos
    public function setEmailAtribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }
    // ACCESORES de Name:  despues de insertar en la bd lo recuperamos y cambiamos  el valor
    public function getNameAtribute($valor)
    {
        //ucfirst cambia el primer nombre a mayuscula
        //return ucfirst($valor);
         //ucword cambia el primer nombre de cada letra a mayuscula
        //return ucword($valor);
        return ucword($valor);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    public function esAdministrador(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public function generaVerificationToken(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificationToken()
    {
        return str_random(40);
    }



}
