<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="register",
     *      tags={"User"},
     *      summary="register the user to the database",
     *      description="Returns the authentication infomation",
     *      @OA\Parameter(
     *          name="email",
     *          description="User email",
     *          required=true,
     *          example="user@admin.com",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),   
     *      @OA\Parameter(
     *          name="name",
     *          description="User name",
     *          example="PeerRater",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="User password",
     *          example="PeerRater",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="isInstructor",
     *          description="User access level",
     *          example=true,
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="boolean"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function register(Request $request)
    {
        $user = User::create([
             'email'    => $request->email,
             'password' => $request->password,
             'name' => $request->name,
             'isInstructor' => $request->has('isInstructor'),
         ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"User"},
     *      summary="user login",
     *      description="Returns the authentication infomation",
     *      @OA\Parameter(
     *          name="email",
     *          description="User email",
     *          required=true,
     *          example="user@admin.com",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="User password",
     *          example="PeerRater",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *          @OA\Property(property="access_token", type="object", example="eyJ0eXAiOiJK..."),
     *          @OA\Property(property="token_type", type="object", example="bearer"),
     *          @OA\Property(property="expires_in", type="object", example=3600),
     *          )
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logout",
     *      tags={"User"},
     *      summary="user logout",
     *      description="Returns the authentication infomation",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *          @OA\Property(property="message", type="object", example="Successfully logged out"),)
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }    
    /**
     * @OA\Get(
     *      path="/api/me",
     *      operationId="me",
     *      tags={"User"},
     *      summary="Get login user infomation",
     *      description="Returns the authentication infomation",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *          @OA\Property(property="id", type="object", example=11),
     *          @OA\Property(property="name", type="object", example="tom"),
     *          @OA\Property(property="email", type="object", example="tom@tom.ca"),
     *          @OA\Property(property="email_verified_at", type="object", example=null),
     *          @OA\Property(property="isInstructor", type="object", example="1"),
     *          @OA\Property(property="created_at", type="object", example="2022-04-04T02:29:04.000000Z"),
     *          @OA\Property(property="updated_at", type="object", example="2022-04-04T02:29:04.000000Z"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Error, please check server configuration",
     *       ),
     *     )
     *
     */
  

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
