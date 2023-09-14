<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
  protected $table = "documentos_proyecto";

  protected $primaryKey = 'iddocumento';

  public $timestamps = false;
}