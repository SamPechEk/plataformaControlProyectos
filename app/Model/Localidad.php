<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
  protected $table = "t_localidad";

  protected $primaryKey = 'id_localidad';

  public $timestamps = false;
}