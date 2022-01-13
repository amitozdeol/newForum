@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('/images/profile.png') }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ optional(auth()->user())->name }}</h3>

                            <p class="text-muted text-center">{{ optional(auth()->user())->telegram }}<span
                                    class="badge badge-success">{{ optional(auth()->user())->skills }}</span></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Joined</b></br>
                                    <b>Last seen</b></br>
                                    <b>Reaction score</b></br>
                                    <b>Total sell</b></br>
                                    <b>Total purchase</b></br>
                                    <b>Messages</b> <a class="float-right">{{ count(optional(auth()->user())->topics) }}</a>
                                </li>
                                {{-- <li class="list-group-item">
                                           <b>Following</b> <a class="float-right">543</a>
                                       </li>
                                       <li class="list-group-item">
                                           <b>Friends</b> <a class="float-right">13,287</a>
                                       </li> --}}
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{ optional(auth()->user())->education }}

                            </br>Contact tg : {{ optional(auth()->user())->telegram }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->






                <div class="col-md-9">






                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity"
                                        data-toggle="tab">Latest activity</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline"
                                        data-toggle="tab">Timeline</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings"
                                        data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">

                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" width="5%"
                                                src="{{ asset('/images/profile.png') }}" alt="user image">
                                            <span class="username">
                                                <a href="#">{{ optional(auth()->user())->name }}</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Shared publicly - {{ optional($latest)->created_at }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        @if ($latest_user_post)
                                            <p>
                                                {{ $latest_user_post->desc }}
                                            </p>
                                        @else
                                            <p>
                                                You have not started any discussion yet
                                            </p>
                                        @endif

                                        {{-- <p>
                                                   <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                                   <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                                   <span class="float-right">
                                                       <a href="#" class="link-black text-sm">
                                                           <i class="far fa-comments mr-1"></i> Comments (5)
                                                       </a>
                                                   </span>
                                               </p>

                                               <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> --}}
                                    </div>
                                    <!-- /.post -->




                                    <!-- Post -->
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" width="5%"
                                                src="{{ asset('/images/profile.png') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">{{ optional(optional($latest)->user)->name }}</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Started a discussion -
                                                {{ optional($latest)->created_at }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        @if ($latest)
                                            <p>
                                                {!! $latest->desc !!}
                                            </p>
                                        @else
                                            <p>
                                                You have not started any discussion yet
                                            </p>
                                        @endif

                                        {{-- <form class="form-horizontal">
                                                   <div class="input-group input-group-sm mb-0">
                                                       <input class="form-control form-control-sm" placeholder="Response">
                                                       <div class="input-group-append">
                                                           <button type="submit" class="btn btn-danger">Send</button>
                                                       </div>
                                                   </div>
                                               </form> --}}
                                    </div>
                                    <!-- /.post -->


                                </div>










                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">


                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">


                                    <form action="{{ route('user.update', auth()->id()) }}" method="POST"
                                        class="form-horizontal">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="inputEducation" class="col-sm-2 col-form-label">About you</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" value="{{ optional(auth()->user())->education }}"
                                                    class="form-control" name="education" id="inputEducation"
                                                    placeholder="{{ optional(auth()->user())->education }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ optional(auth()->user())->skills }}"
                                                    class="form-control" name="skills" id="inputSkills"
                                                    placeholder="Skills">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
