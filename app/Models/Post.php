<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *  title="Post",
 * 	@OA\Property(property="id", type="integer", example="3"),
 *  @OA\Property(property="title", type="string", example="Aperiam quis nisi laboriosam."),
 *  @OA\Property(property="slug", type="string", example="voluptatem-quos-magni-nam-sunt-magni-tenetur"),
 *  @OA\Property(property="post", type="string", example="<p>HTML content</p>"),
 *  @OA\Property(property="author_id", type="integer", example="1"),
 *  @OA\Property(property="extract", type="string", example="Omnis quas at est sequi maiores maiores quis debitis. Sed quis et nihil neque quibusdam ut. Harum labore aut dolores. Tempora eveniet natus voluptates error aliquid ut id."),
 *  @OA\Property(property="visits", type="integer", example="3"),
 *  @OA\Property(property="created_at", type="date-time", example="2023-08-06 18:49:58"),
 *  @OA\Property(property="updated_at", type="date-time", example="2023-08-06 18:49:58"),
 *  @OA\Property(property="author", type="object", ref="#/components/schemas/Author"),
 * )
 *  @property int $id
 *  @property string $title
 *  @property string $slug
 *  @property string $post
 *  @property int $author_id
 *  @property string $extract
 *  @property int $visits
 *  @property \DateTime $created_at
 *  @property \DateTime $updated_at
 *  @property Author $author
 * )
 */
class Post extends Model
{
    use HasFactory;

    /**
     * Get post author.
     */
    public function author() : BelongsTo{
        return $this->belongsTo(Author::class);
    }
}
