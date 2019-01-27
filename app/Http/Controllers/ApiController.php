<?php
namespace App\Http\Controllers;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;



class ApiController extends Controller
{
	//crearemos  un folder en app llamado Traits y dentro el archivo;
   use ApiResponser;
}
