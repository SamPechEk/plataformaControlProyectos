<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
  protected $table = "contratos";

  protected $primaryKey = 'idcontrato';

  public $timestamps = false;
}