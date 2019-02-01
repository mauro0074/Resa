<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //  No se utilizan  para apis
    //public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);
        $category = Category::create($request->all());
        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     //* @param  \App\Category  $category
     //* @return \Illuminate\Http\Response
     */
    // no se usa para apis
    // public function edit(Category $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //Nombre y descripcion son opcionales or lo que no validaremos
        //pero verificaremos que envie por lo menos uno y que no sea el 
        //mismo
        //EN LARAVEL 5.5 Se debe usar el metodo Only en vez de intersect
        //fill recibe los valores a actualizar, intersect recibe 
        //unicament los valores de name y description. Si se envia otro
        //valor no es atendido para la insercion
        //Intersect recibira un aray con lo atributos que queremos 
        //modificar
        $category->fill($request->intersect(['name','description']));
        //si el usuario no envia nada o los valores son identicos a categoria devolvemos una excepcion
        //para eso verificamos si la categoria cambio con referencia a la instancia inicial isDirty verifica si cambio isClea verif si no cambio
        if ($category->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }
        $category->save();
        return $this->ShowOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
