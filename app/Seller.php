<?php

namespace App;
use App\User;
use App\Seller;
class Seller extends User
{
	
     public function products()
    {
    	return $this->hasMany(Products::class);
    }
}
