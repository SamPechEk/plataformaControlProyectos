<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
  protected $table = "t_municipio";

  protected $primaryKey = 'id_municipio';

  public $timestamps = false;
}