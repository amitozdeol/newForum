@extends('layouts.app')
@section('content')
</div>
    <div class="container">
      <nav class="breadcrumb">
        <a href="/" class="breadcrumb-item">Forum Categories</a>
        <a href="{{route('category.overview', $forum->category->id)}}" class="breadcrumb-item">{{$forum->category->title}}</a>
        <span class="breadcrumb-item active">{{$forum->title}}</span>
      </nav>

      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <!-- Category one -->
            <div class="col-lg-12">
              <!-- second section  -->
              <h4 class="text-white bg-info mb-0 p-4 rounded-top">
                {{$forum->title}}
              </h4>
              <table
                class="table table-striped table-responsivelg table-bordered"
              >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Topic</th>
                    <th scope="col ">Created</th>
                    <th scope="col">Statistics</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @if (count($forumDiscussions) > 0)
                    @foreach ($forumDiscussions as $topic)
                    <tr>
                    <td>
                      <h3 class="h6">
                        <span class="badge badge-primary">{{$topic->discussion_replies_count}} replies</span>
                        <a href="{{route('topic', $topic->id)}}" class=""
                          >{{$topic->title}}.</a
                        >
                      </h3>
                      <!-- <div class="small">
                        Go to page: <a href="#">1</a>, <a href="#">2</a>,
                        <a href="#">3</a>, <a href="#">4</a> &hellip;<a href="#"
                          >9</a
                        >,<a href="#">10</a>
                      </div> -->
                    </td>
                    <td>
                      <div>by <a href="#">{{$topic->user_name}}</a></div>
                      <div>{{$topic->created_at}}</div>
                    </td>
                    <td>
                      <div> {{$topic->discussion_replies_count}} Replies</div>
                      <div>{{$topic->views}} Views</div>
                    </td>

                  </tr>
                    @endforeach

                  @else 
                  <h1>No topics found in this forum</h1>
                  @endif
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-3 clearfix">
       {{ $forumDiscussions->withQueryString()->links()  }}
        <form action="" class="form-inline float-lg-left d-block d-sm-flex">
          <div class="mb-2 mb-sm-0 mr-2">Display posts from previous</div>
          <div class="form-group mr-2">
            <label class="sr-only" for="time_period"> Time Period</label>
            <select
              name="time_period"
              id=""
              class="form-control form-control-sm"
            >
              <option value="all">All posts</option>
              <option {{ (request()->time_period == "day") ? 'selected':''}} value="day">1 day</option>
              <option {{ (request()->time_period == "week") ? 'selected':''}} value="week">1 week</option>
              <option {{ (request()->time_period == "month") ? 'selected':''}} value="month">1 month</option>
              <option {{ (request()->time_period == "year") ? 'selected':''}} value="year">1 year</option>
              <option {{ (request()->time_period == "lastYear") ? 'selected':''}} value="lastYear">Last year</option>
            </select>
          </div>

          <div class="mb-2 mb-sm-0 mr-2">Sort by:</div>
          <div class="form-group mr-2">
            <label class="sr-only" for="post_type">Sort posts by:</label>
            <select
              name="post_type"
              id=""
              class="form-control form-control-sm"
            >
              <option {{ (request()->post_type == "author") ? 'selected':''}} value="author">Author</option>
              <option {{ (request()->post_type == "post_time") ? 'selected':''}} value="post_time">Post time</option>
              <option {{ (request()->post_type == "replies") ? 'selected':''}} value="replies">Replies</option>
              <option {{ (request()->post_type == "subject") ? 'selected':''}}  value="subject">Subject</option>
              <option {{ (request()->post_type == "views") ? 'selected':''}} value="views">Views</option>
            </select>
          </div>

          <div class="mb-2 mb-sm-0 mr-2">Sort direction:</div>
          <div class="form-group mr-2">
            <label class="sr-only" for="post_sort_by">Sort direct:</label>
            <select
              name="post_sort_by"
              id=""
              class="form-control form-control-sm"
            >
              <option {{ (request()->post_sort_by == "desc") ? 'selected':''}} value="desc">Desending</option>
              <option {{ (request()->post_sort_by == "asc") ? 'selected':''}} value="asc">Ascending</option>
            </select>
          </div>
          <button type="submit" class="btn btn-sm btn-primary">Sort</button>
        </form>
      </div>
      <a href="{{route('topic.new', $forum->id)}}" class="btn btn-lg btn-primary mb-2">New Topic</a>
    </div>
@endsection