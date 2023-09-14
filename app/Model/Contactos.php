<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
  protected $table = "contactos";

  protected $primaryKey = 'idcontacto';

  public $timestamps = false;
}