<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
  protected $table = "t_estado";

  protected $primaryKey = 'id_estado';

  public $timestamps = false;
}