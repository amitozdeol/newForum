<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Discussion;
use App\Models\User;
use Carbon\Carbon;
use DB;

use Illuminate\Routing\Route;

class FrontendController extends Controller
{
    public function index()
    {
        $user = new User;
        $users_online = $user->allOnline();
        $forumsCount = count(Forum::all());
        $topicsCount = count(Discussion::all());
        $totalMembers = count(User::all());
        $newest = User::latest()->first();
        $totalCategories = count(Category::all());
        $categories = Category::latest()->get();
        return view('welcome', \compact('categories', 'forumsCount', 'topicsCount', 'newest', 'totalMembers', 'totalCategories', 'users_online'));
    }

    public function categoryOverview($id)
    {
        $user = new User;
        $users_online = $user->allOnline();
        $forumsCount = count(Forum::all());
        $topicsCount = count(Discussion::all());
        $totalMembers = count(User::all());
        $newest = User::latest()->first();
        $totalCategories = count(Category::all());
        $category = Category::find($id);

        return view('client.category-overview', \compact('category'));
    }

    public function forumOverview(Request $request, $id)
    {
        $timePeriod = $postType = NULL;
        $postSortBy = 'desc';
        if ($request->has('time_period') && $request->has('post_type') && $request->has('post_sort_by')) {
            $timePeriod = $request->time_period;
            $postType = $request->post_type;
            $postSortBy = $request->post_sort_by;
        }
        
        $forum = Forum::find($id);

        $forumDiscussionQuery = $forum->discussions()
        ->leftJoin('users', 'users.id', '=', 'discussions.user_id')
        ->leftJoin('discussion_replies', 'discussion_replies.discussion_id', '=', 'discussions.id')
        ->selectRaw(
            'discussions.*,
            users.name as user_name,
            discussion_replies.id as reply_id,
            count(discussion_replies.discussion_id) as discussion_replies_count')
            ->groupBy('discussions.id');

        if($timePeriod == 'day'){
            $forumDiscussionQuery->where('discussions.created_at','>=',Carbon::today());
        }elseif($timePeriod == 'week'){           
            $forumDiscussionQuery->whereBetween('discussions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }elseif($timePeriod == 'month'){
            $forumDiscussionQuery->whereMonth('discussions.created_at', date('m'))
            ->whereYear('discussions.created_at', date('Y'));
        }elseif($timePeriod == 'year'){
            $forumDiscussionQuery->whereYear('discussions.created_at', date('Y'));
        }
        elseif($timePeriod == 'lastYear'){
            $forumDiscussionQuery->whereYear('discussions.created_at', date('Y', strtotime('-1 year')));
        }

        if($postType == 'post_time'){
            $forumDiscussionQuery->orderBy('discussions.created_at',$postSortBy);
        }else if($postType == 'replies'){
            $forumDiscussionQuery->orderBy('discussion_replies_count',$postSortBy); 
        }else if($postType == 'subject'){
            $forumDiscussionQuery->orderBy('discussions.title',$postSortBy);
        }else if($postType == 'views'){
            $forumDiscussionQuery->orderBy('discussions.views',$postSortBy);
        }else{
            $forumDiscussionQuery->orderBy('users.name',$postSortBy);
        }
        
        $forumDiscussions = $forumDiscussionQuery->paginate(30)->onEachSide(1);
        
        return view('client.forum-overview', compact('forum','forumDiscussions'));
    }
}
