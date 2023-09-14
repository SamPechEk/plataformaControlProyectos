<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Ejecutora extends Model
{
  protected $table = "eje_gasto";

  protected $primaryKey = 'idejecutora';

  public $timestamps = false;
}