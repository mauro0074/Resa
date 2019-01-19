<?php 
//los traits se pueden poner en cualquier carpeta pero lo pondremos en su propio folder
//
namespace App\Traits;
trait ApiResponse
{
	//devolvera respuestas positivas
	private function succesResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	//devolvera errores
	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}
	//Muestra todaslas instancias ,todos usuarios o elementos, si no se recibe un codigo se asumira que su variable es 200 recibe coleccio
	protected function showAll(Collection $collection, $code = 200)
	{
		return $this->successResponse(['data'=> $collection], $code);
	}
	//Muestra una instancias ,un usuarios o elementos, si no se recibe un codigo se asumira que su variable es 200 recibe objeto simple
	protected function ShowOne(Model $instance, $code = 200)
	{
		return $this->successResponse(['data' => $collection], $code);
	}
}
?>