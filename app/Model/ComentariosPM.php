<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ComentariosPM extends Model
{
  protected $table = "comentarios_programa";

  protected $primaryKey = 'idcomentariop';

  public $timestamps = false;
}