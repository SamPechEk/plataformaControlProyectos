<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
  protected $table = "solicitudes";

  protected $primaryKey = 'idsolicitud';

  public $timestamps = false;
}