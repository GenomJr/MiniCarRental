<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

  // Table Name
  protected $table = 'cars';
  // Primary Key
  public $primaryKey = 'id';
  // Timestamps
  public $timestamps = true;

  public function user(){
    return $this->belongsTo('App\User');
}
}
