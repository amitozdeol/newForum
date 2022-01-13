<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Discussion;
use App\Models\DiscussionReply;

class DiscussionController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $forums = Forum::latest()->get();
        $forum = Forum::find($id);

        return \view('client.new-topic', \compact('forums', 'forum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notify = 0;

        if($request->notify && $request->notify =="on")
        {
            $notify = 1;
        }

        $topic = new Discussion;
        $topic->title = $request->title;
        $topic->desc = $request->desc;
        $topic->forum_id = $request->forum_id;
        $topic->user_id = auth()->id();
        $topic->notify = $notify;

        $topic->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Discussion::find($id);
        if($topic){
            $topic->increment('views', 1);
        }

        return view('client.topic', \compact('topic'));
    }


        /**
     * Save reply to the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $reply = New DiscussionReply;
        $reply->desc = $request->desc;
        $reply->user_id =auth()->id();
        $reply->discussion_id = $id;

        $reply->save();

        toastr()->success('Reply saved successfully');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply = DiscussionReply::find($id);
        $reply->delete();

        toastr()->success('Reply deleted successfully');

        return back();
    }
}
