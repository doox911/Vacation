<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacation extends Model {

  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'start',
    'end',
    'readonly',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];


  /**
   * @return BelongsTo
   */
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

}
