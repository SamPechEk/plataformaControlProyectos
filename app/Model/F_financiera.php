<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class F_financiera extends Model
{
  protected $table = "f_financiera";

  protected $primaryKey = 'idfuente';

  public $timestamps = false;
}