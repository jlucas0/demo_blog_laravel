<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFieldException;
use Illuminate\Http\JsonResponse;
use App\Adapters\PostAdapter;
use Illuminate\Http\Request;

class PostApiController extends ApiController{
    /**
     * @OA\Get(
     *     path="/api/post/{id}",
     *     tags={"Posts"},
     *     summary="Find by ID",
     *     description="Returns a single post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to return",
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
     *                   ref="#/components/schemas/Post",
     *               ),
     *        )
     *     )
     * )
     *
     * @param int $id
     */
    public function findById(int $id) : JsonResponse{
        $post = PostAdapter::findById($id);
        if(empty($post)){
            $this->status = 4;
            $this->message = "Post not found with id $id";
        }
        else{
            $this->status = 2;
            $this->message = "Post with id $id retrieved";
            $this->payload = $post;
        }

        return $this->generateResponse();
    }


    /**
     * @OA\Get(
     *  path="/api/post/list",
     *  tags={"Posts"},
     *  summary="List of posts",
     *  description="Get complete list of posts with pagination options",
     *  @OA\Parameter(
     *      name="results",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *          description="Amount of post to be retrieved (by default all), starting by order field (default id) and ignoring first n posts specified by offset parameter (default 0)"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="offset",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *          description="Ignore first n posts (by default 0)"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="order_field",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          description="Determines field to order results (by default id)"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="order_ascending",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="boolean",
     *          description="Determines if order is ascending (default) or descending"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Operation completed",
     *      @OA\JsonContent(
     *          @OA\Property(property="status", type="integer", example="2"),
     *          @OA\Property(property="message", type="string", example="List retrieved"),
     *          @OA\Property(
     *              property="payload",
     *              type="object",
     *              @OA\Property(property="total_posts",type="integer",example="50"),
     *              @OA\Property(
     *                  property="retrieved_posts",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/Post"
     *                  )
     *              )  
     *          )
     *      )
     *  )
     * )
     */
    public function list(Request $request) : JsonResponse{
        
        //Retrieve all query parameters
        $results = $request->results ? (is_numeric($request->results) ? (int)$request->results : -1) : 0;
        $offset = $request->offset ? (is_numeric($request->offset) ? (int)$request->offset : -1) : 0;
        $orderField = $request->order_field ? (gettype($request->order_field)=="string" ? $request->order_field : "") : "id";
        $ascending = $request->order_ascending ?? true;
        if($ascending == "false"){
            $ascending = false;
        }
        
        try{
            //Retrieve results and prepare response
            $results = PostAdapter::getList($results,$offset,$orderField,(bool)$ascending);
            $this->status = 2;
            $this->message = "List retrieved";
            $this->payload = [
                "total_posts" => PostAdapter::getCount(),
                "retrieved_posts" => $results
            ];
        }catch(InvalidFieldException $ife){
            $this->status = 3;
            $this->message = "Some parameters are incorrect";
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

        return $this->generateResponse();
    }
}