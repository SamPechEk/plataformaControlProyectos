<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DocumentoXP extends Model
{
  protected $table = "documentosxproyecto";

  protected $primaryKey = 'id';

  public $timestamps = false;
}