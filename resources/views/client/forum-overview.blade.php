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
                        <span class="badge badge-primary">{{$topic->replies->count()}} replies</span>
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
                      <div>by <a href="#">{{$topic->user->name}}</a></div>
                      <div>{{$topic->created_at}}</div>
                    </td>
                    <td>
                      <div> {{$topic->replies->count()}} Replies</div>
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
              <option value="day">1 day</option>
              <option value="week">1 week</option>
              <option value="month">1 month</option>
              <option value="year">1 year</option>
              <option value="lastYear">Last year</option>
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
              <option value="author">Author</option>
              <option value="post_time">Post time</option>
              <option value="replies">Replies</option>
              <option value="subject">Subject</option>
              <option value="views">Views</option>
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
              <option value="desc">Desending</option>
              <option value="asc">Ascending</option>
            </select>
          </div>
          <button type="submit" class="btn btn-sm btn-primary">Sort</button>
        </form>
      </div>
      <a href="{{route('topic.new', $forum->id)}}" class="btn btn-lg btn-primary mb-2">New Topic</a>
    </div>
@endsection