<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Adapters\PostAdapter;

class PostApiController extends ApiController{
    /**
     * @OA\Get(
     *     path="/api/post/{id}",
     *     tags={"Posts"},
     *     summary="Find by ID",
     *     description="Find post by ID",
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
            $this->payload->author->post_count = $post->author->post_count;
        }

        return $this->generateResponse();
    }
}