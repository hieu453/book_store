<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function toggleLike(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $user = Auth::user();

        if ($review->isLikedByUser($user)) {
            $review->likes()->where('user_id', $user->id)->delete();
        } else {
            $review->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }
}
