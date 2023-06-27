<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['HTML', 'CSS', 'Javascript', 'VueJs', 'PHP', 'Laravel'];

        foreach($data as $type){
          $new_type = new Type();
          $new_type->name = $type;
          $new_type->slug = Str::slug($type, '-');
          // dump($new_type);
          $new_type->save();
        }
    }
}