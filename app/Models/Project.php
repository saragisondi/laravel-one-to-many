<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'type_id',
    'slug',
    'text',
    'date',
    'reading_time',
    'image_path',
    'image_original_name'
  ];

  //TYPE
  public function type()
  {
    return $this->belongsTo(Type::class);
  }

  // SLUG
  public static function generateSlug($str)
  {
    $slug = Str::slug($str, '-');
    $original_slug = $slug;
    $slug_exists = Project::where('slug', $slug)->first();
    $c = 1;
    while ($slug_exists) {
      $slug = $original_slug . '-' . $c;
      $slug_exists = Project::where('slug', $slug)->first();
      $c++;
    }
    return $slug;
  }
}