<?php

namespace App\Http\Controllers\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
       return $this->showAll($usuarios);
       // return ['data'=>$usuarios];
    }

   
    public function store(Request $request)
    {
        $reglas = [
                  'name' => 'required',
                  'email' => 'required|email|unique:users',
                  'password' => 'required|min:6|confirmed'
                 // 'password' => 'required|min:6'
              ];
        $this->validate($request, $reglas);
        
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_VERIFICADO;
        //$campos['verification_token'] = bcrypt(User::generaVerificationToken());
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $usuario =  User::findorFail($id);
         return $this->showOne($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);

        $reglas = [
                  'email' => 'email|unique:users,email,' .$user->id,
                  'password' => 'min:6|confirmed',
                  'admin' => 'in:' . user::USUARIO_ADMINISTRADOR . ',' .User::USUARIO_REGULAR, 
              ];


        $this->validate($request, $reglas);
        if ($request->has('name')) 
        {
            $user->name = $request->name;
        }
       
        if ($request->has('email') &&  $user->email != $request->email) 
        {
            $user->verified = user::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) 
        {
            $user->password = bcrypt($request->password);
        }  
            
        if ($request->has('admin')) 
        {
            if (!$user->esVerificado()) 
            { 
                //error 409 es de conflicto con peticion
                return $this->errorResponse('Solo los usuarios verificados pueden cambiar su valor', 409);
               // $user->verification_token = User::generarVerificationToken();
            }
            $user->admin = $request->admin;
        
        }
        //en esta parte con dirty verificamos si ha cambiado algun dato de user
        if (!$user->isDirty())
        {
            return $this->errorResponse('Se debe teclear por lo menos un valor diferente, para actualizar', 422);
        }
            
        $user->save();  
       return $this->showOne($user);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);
        $user->delete();
        return $this->showOne($user);
    }
}
