<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Revisar extends Model
{
  protected $table = "Revisar";

  protected $primaryKey = 'idrevisar';

  public $timestamps = false;
}