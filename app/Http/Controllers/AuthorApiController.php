<?php

namespace App\Http\Controllers;

use App\Traits\ValidatesFields;
use App\Exceptions\InvalidFieldException;
use Illuminate\Http\JsonResponse;
use App\Adapters\AuthorAdapter;
use Illuminate\Http\Request;


class AuthorApiController extends ApiController{
    use ValidatesFields;

    /**
     * @OA\Get(
     *     path="/api/author/{id}",
     *     tags={"Authors"},
     *     summary="Find by ID",
     *     description="Find one author by its ID",
     *     description="Returns a single author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of author to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operation completed",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="integer", example="2"),
     *               @OA\Property(property="message", type="string", example="Author with id 3 retrieved"),
     *               @OA\Property(
     *                   property="payload",
     *                   type="object",
     *                   ref="#/components/schemas/Author",
     *               ),
     *        )
     *     )
     * )
     *
     * @param int $id
     */
    public function findById(int $id) : JsonResponse{
        $author = AuthorAdapter::findById($id);
        if(empty($author)){
            $this->status = 4;
            $this->message = "Author not found with id $id";
        }
        else{
            $this->status = 2;
            $this->message = "Author with id $id retrieved";
            $this->payload = $author;
            $this->payload->post_count = $author->post_count;
        }

        return $this->generateResponse();
    }

    /**
     * @OA\Put(
     *  path="/api/author/login",
     *  tags={"Authors"},
     *  summary="Login",
     *  description="Performs login attempt and retrieves access token if success",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              )
     *          ),
     *          example={"email": "winona78@example.net","password": "password"}
     *      )
     *  ),
     *     @OA\Response(
     *         response=200,
     *         description="Operation completed",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="integer", example="2"),
     *               @OA\Property(property="message", type="string", example="Login success"),
     *               @OA\Property(
     *                   property="payload",
     *                   type="string",
     *                   example="1|gXppSgPS7E2UMGF8jsMGJuM7FM5MSYH2BAfmmSsT",
     *               ),
     *        )
     *     )
     * )
     */
    public function login(Request $request) : JsonResponse{
        $json = (array)json_decode((string)$request->getContent(),true); //Casting just to ensure PHPStan Validation
        if(!empty($json)){
            //Check valid JSON
            try{
                self::validateFields($json,[
                    "email"=>["required","email"],
                    "password"=>["required","string"]
                ]);
                $token = AuthorAdapter::login(
                    gettype($json["email"]) == "string" ? $json["email"] : "",
                    gettype($json["password"]) == "string" ? $json["password"] : "",
                    true
                );//Type verification just to avoid PHPStan problem with mixed result of standard json_decode function
                if($token){
                    $this->message = "Login success";
                    $this->status = 2;
                    $this->payload = $token;
                }else{
                    $this->message = "Login failed";
                }
            }catch(InvalidFieldException $ife){
                $this->status = 3;
                $this->message = "Some fields are incorrect";
                $errors = (array)json_decode($ife->getMessage(),true);//Casting just to ensure PHPStan Validation
                foreach($errors as $fieldErrors){
                    $fieldErrors = (array)$fieldErrors;
                    foreach($fieldErrors as $error){
                        if(gettype($error) == "string"){ //Just to avoid PHPStan problem with mixed result of standard json_decode function
                            $this->errors[] = $error;
                        }
                    }
                }
            }
        }else{
            $this->status = 3;
            $this->message = "Invalid JSON provided";
        }

        return $this->generateResponse();
    }
}