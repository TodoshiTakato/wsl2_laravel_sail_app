<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Customized additions:

// Factory:
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Task\TaskFactory;

// Other:
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'status',
        'priority',
        'start_time',
        'finish_time',
        'time_spent',
        'user_id',
    ];

    /**
     * Create a new factory instance for the model.
     * Nurlan's comment: it is for faker, seeding and etc.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    /**
     * Rate the article.
     *
     * @param int $rating
     * @param int|null $comment
     * @param int|null $task_user
     * @return Model
     */
    public function rate($rating, $task_user = null, $comment = null)
    {
        if ($rating > 5 || $rating < 1) {
            throw new InvalidArgumentException('Ratings must be between 1-5.');
        }
        $rating_user = $task_user ? $task_user : auth()->user();

        return $this->ratings()->updateOrCreate(
            ['user_id' => $rating_user->id, 'task_id' => $this->id],
            ['rating' => $rating, 'comment' => $comment]
        );
    }

    /**
     * Fetch the average rating for the task.
     *
     * @return float
     */
    public function rating()
    {
//        return $this->ratings->avg('rating');
        return round($this->ratings->avg('rating'), 2);
    }

    /**
     * Get all ratings for the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
//        return $this->hasMany('App\Rating')->avg('rating');
        return $this->hasMany('App\Rating');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
