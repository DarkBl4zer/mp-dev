<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Notificaciones extends Model
{
    protected $table = 'mp_notificaciones';
    protected $fillable = ['id_usuario','id_nievel1','id_nievel2'];
    protected $guarded = ['id'];
}
