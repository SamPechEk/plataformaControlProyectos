<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Contratista extends Model
{
  protected $table = "contratista";

  protected $primaryKey = 'idcontratista';

  public $timestamps = false;
}