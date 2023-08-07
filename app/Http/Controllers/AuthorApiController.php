<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Adapters\AuthorAdapter;

/**
 * @OA\Info(title="Authors",version="1")
 */
class AuthorApiController extends ApiController{
    /**
     * @OA\Get(
     *     path="/api/author/{id}",
     *     tags={"author"},
     *     summary="Find author by ID",
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
     *                   @OA\Property(property="id", type="integer", example="3"),
     *                   @OA\Property(property="name", type="string", example="Great Author"),
     *                   @OA\Property(property="email", type="string", example="great@author.au"),
     *               ),
     *        )
     *     )
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
        }

        return $this->generateResponse();
    }

}