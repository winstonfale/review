<?php

namespace App\Http\Controllers;

use App\Enums\ReviewStatus;
use App\Enums\WebsiteIds;
use App\Http\Resources\ReviewResources;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index($id){

      

        // $ratings = Cache::remember('ratings'.$id, (60 * 60 * 4), function () use ($id) {
            $sql = Review::query()
            ->where('website_id', $id);

    
            $sql = $sql->select(DB::raw('
                count(id) as total, 
                count(CASE WHEN rating = 5 THEN 1 END) as five_rating,
                count(CASE WHEN rating = 4 THEN 1 END) as four_rating,
                count(CASE WHEN rating = 3 THEN 1 END) as three_rating,
                count(CASE WHEN rating = 2 THEN 1 END) as two_rating,
                count(CASE WHEN rating = 1 THEN 1 END) as one_rating,
                avg(rating) as average_rating
                '))
            ->get();


        //     return $sql->first();
        // });

        $reviews = Review::where('website_id', $id)
        ->orderBy('created_at','DESC')
        ->paginate(5);

        return ReviewResources::collection($reviews)->additional(['ratings' => $sql->first()]);
    }

    public function lists(Request $request){
        // return $request->all();
        return Review::where('status',ReviewStatus::PENDING)->paginate(20) ;
    }

    public function store(Request $request){

        $request->validate([
            'comment' => 'required',
            'site_id' => 'required|in:'.implode(',', WebsiteIds::getValues()),
        ]);

        $website_id = $request->site_id;

        $review = Review::create([
            'website_id' => $website_id,
            'commentor_id' => 1,
            'website_url' => WebsiteIds::getKey($website_id),
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'feedback' =>  $request->feedback,
        ]);

        return new ReviewResources($review);
    }


    public function approve($id){

       $review =  Review::findOrfail($id);

       $review->status = ReviewStatus::APPROVED;
       $review->save();

        return  $review ;
    }


    public function reject($id){

        $review =  Review::findOrfail($id);

        $review->status = ReviewStatus::REJECTED;
        $review->save();
 
         return  $review ;
    }
}
