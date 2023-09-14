<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
  protected $table = "proyecto";

  protected $primaryKey = 'idproyecto';

  public $timestamps = false;
}