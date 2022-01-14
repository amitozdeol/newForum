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

        $forumDiscussions = DB::table('forums')->leftJoin('discussions','discussions.forum_id','=','forums.id')
        ->leftJoin('users', 'users.id', '=', 'discussions.user_id')
        ->leftJoin('discussion_replies', 'discussion_replies.discussion_id', '=', 'discussions.id')
        ->selectRaw(
            'discussions.*,
            users.name as user_name,
            discussion_replies.id as reply_id,
            count(discussion_replies.discussion_id) as discussion_replies_count')
            ->groupBy('discussions.id')
            ->when($timePeriod == 'day', function ($query) {$query->where('discussions.created_at','>=',Carbon::today());})
            ->when($timePeriod == 'week', function ($query) {$query->whereBetween('discussions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);})
            ->when($timePeriod == 'month', function ($query){$query->whereMonth('discussions.created_at', date('m'))->whereYear('discussions.created_at', date('Y'));})
            ->when($timePeriod == 'year', function ($query) {$query->whereYear('discussions.created_at', date('Y'));})
            ->when($timePeriod == 'lastYear', function ($query) {$query->whereYear('discussions.created_at', date('Y', strtotime('-1 year')));})
            ->when($postType == 'author', function ($query) use($postSortBy){$query->orderBy('users.name',$postSortBy);})
            ->when($postType == 'post_time', function ($query) use($postSortBy){$query->orderBy('discussions.created_at',$postSortBy);})
            ->when($postType == 'replies', function ($query) use($postSortBy){$query->orderBy('discussion_replies_count',$postSortBy);})
            ->when($postType == 'subject', function ($query) use($postSortBy){$query->orderBy('discussions.title',$postSortBy);})
            ->when($postType == 'views', function ($query) use($postSortBy){$query->orderBy('discussions.views',$postSortBy);})
            ->paginate(30)->onEachSide(1);
        
        return view('client.forum-overview', compact('forum','forumDiscussions'));
    }
}
