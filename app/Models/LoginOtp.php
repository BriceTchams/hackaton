<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginOtp extends Model
{
  protected $fillable = [
    'user_id','code_hash','expires_at','attempts','used'
  ];

  protected $casts = [
    'expires_at' => 'datetime',
    'used' => 'boolean',
  ];

  public function user() : BelongsTo {
    return $this->belongsTo(LoginOtp::class);
  }
}