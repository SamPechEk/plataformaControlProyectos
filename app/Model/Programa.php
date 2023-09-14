<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
  protected $table = "programa";

  protected $primaryKey = 'idprograma';

  public $timestamps = false;
}