<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Tdocumentos extends Model
{
  protected $table = "tipos_documentos";

  protected $primaryKey = 'idtipod';

  public $timestamps = false;
}