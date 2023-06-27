<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Generator as Faker;
use App\Models\User;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for ($i=0; $i < 100; $i++) {
        $new_project = new Project();
        $new_project -> title = $faker -> sentence();
        $new_project -> slug = Project::generateSlug($new_project->title);
        $new_project -> text = $faker -> text(1000);
        $new_project -> date = date('Y-m-d');
        $new_project -> save();

      }
    }
}