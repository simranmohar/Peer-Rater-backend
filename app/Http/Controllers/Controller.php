<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
* @OA\Info(
* version="1.0.0",
* title="L5 OpenApi",
* description="L5 Swagger OpenApi description"
* )
* @OA\Servers(
* url:"http://praterlaravel.azurewebsites.net/api"
* )
* @OA\SecurityScheme(
* scheme="Bearer",
* securityScheme="Bearer",
* type="apiKey",
* in="header",
* name="Authorization",
* )
* @OA\Tag(name="User", description="Peer rater user")
* @OA\Tag(name="Category", description="Peer rater category")
* @OA\Tag(name="PeerGroup", description="Peer rater group")
* @OA\Tag(name="Rating", description="Peer rater user's rating")
* @OA\Tag(name="Survey", description="Peer rater surbey")
*/


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
