<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function user() {
      return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $filter) {
      if($filter ?? false) {
        //Search multiple words by space. Code by Jarek Tkaczyk
        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $filter, -1, PREG_SPLIT_NO_EMPTY); 

        return $query->where(function ($q) use ($searchValues) {
          foreach ($searchValues as $value) {
            $q->orWhere('title', 'like', "%{$value}%")
            ->orWhere('skills', 'like', "%{$value}%")
            ->orWhere('companyName', 'like', "%{$value}%");
          }
        });
      }
    }

    public function scopeBookmark($query, $filter) {
      if($filter ?? false) {
        $jobs = explode(',', $filter);
        return $query->whereIn('id', $jobs);
      }
    }
}
