<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorie = ['cinema', 'motori', 'giardinaggio', 'videogiochi', 'sport'];
        foreach($categorie as $categoria){
            $nuova_categoria = new Category();
            $nuova_categoria->name = $categoria;
            $nuova_categoria->slug = Str::of($categoria)->slug("-");
            $nuova_categoria->save();
        }
    }
}
