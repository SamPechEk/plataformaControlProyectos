<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
  protected $table = "presupuesto";

  protected $primaryKey = 'idpresupuesto';

  public $timestamps = false;
}