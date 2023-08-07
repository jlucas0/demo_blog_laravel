<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @OA\Schema(
 *  title="Author",
 * 	@OA\Property(property="id", type="integer", example="3"),
 *  @OA\Property(property="name", type="string", example="Great Author"),
 *  @OA\Property(property="email", type="string", example="great@author.au"),
 *  @OA\Property(property="post_count", type="integer", example="5"),
 * )
 *  @property int $id
 *  @property string $name
 *  @property string $email
 *  @property int $post_count
 */
class Author extends User
{
    use HasApiTokens, HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get author's posts.
     */
    public function posts() : HasMany{
        return $this->hasMany(Post::class);
    }

    /**
     * Accessor to calculate author's number of posts.
     */
    protected function postCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->posts()->count(),
        );
    }
}
