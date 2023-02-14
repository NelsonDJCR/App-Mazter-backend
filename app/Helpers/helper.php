<?php

use App\Models\User;


function getUser()
{
    return User::where('auth_token', request()->bearerToken())->first();
}
function getUserId()
{
    return User::where('auth_token',request()->bearerToken())->first()->id;
}
function getStoreId()
{
    return User::where('auth_token',request()->bearerToken())->first()->store_id;
}
