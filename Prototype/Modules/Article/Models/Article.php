<?php

namespace Modules\Article\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable =  ['title'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
