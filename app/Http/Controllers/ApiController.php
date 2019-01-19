<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


class ApiController extends Controller
{
	//crearemos  un folder en app llamado Traits y dentro el archivo;
   use ApiResponser;
}
