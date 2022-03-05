<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Agencia_Especial extends Model
{
    protected $table = 'mp_agencia';
    protected $fillable = ['numero_agencia_especial', 'fecha_creacion', 'delegada', 'nombre_ministerio', 'noticia_criminal', 'despacho_judicial', 'nombre_unidad', 'adecuacion_tipica', 'criterio_creacion', 'justificacion', 'sintesis', 'estado', 'justificacion_fin', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
