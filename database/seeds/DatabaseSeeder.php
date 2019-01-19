<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //Desabilita claves foraneas o desactiva
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
       
        //truncate elimina lo que haya en el interior de la tabla
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();
        $cantidadUsuarios = 1000;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;
        //con esto decimos que vamos a insertar en la bd
        factory(User::class, $cantidadUsuarios)->create();
        factory(Category::class,$cantidadCategorias)->create();
        
        factory(Product::class,$cantidadTransacciones)->create()->each(
         	//usamos una funcion anonima que recibe cada uno de los productos uno a uno luego le enviamos la cantidad de categorias luego generamos
        //la asociacion con attach para eso necesitamos saber las categorias , luego obtenemos aleatoriamente , objetos completos de categorias antes de pluck
         	//con pluck solo  obtenemos los ids
         		function ($producto) {
         			$categorias = Category::all()->random(mt_rand(1, 5))->pluck('id');
         			$producto->categories()->attach($categorias);
         		}
         );

          factory(Transaction::class,$cantidadTransacciones)->create();


    }
}
