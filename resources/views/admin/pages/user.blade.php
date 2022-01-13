@extends('layouts.dashboard')
@section('css')
<style>
    .list-group-unbordered .list-group-item {
        line-height: 2;
        border: 0;
    }
    .card-header {
        margin: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .card {
        background-color: #fff;
    }
    .card-body {
        margin: 10px;
        padding-bottom: 10px;
    }
    .card-body.m-t-5 {
        margin: 15px !important;
        padding: 15px 0px 5px 10px !important;
    }
    .tab-content {
        line-height: 3;
    }
    .card-header.p-2 {
        margin: 15px !important;
        padding-top: 15px !important;
        padding-bottom: 5px !important;
        padding-left: 10px !important;
    }
</style>
@endsection
@section('content')
    @if ($user)
        <!-- Main content -->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" width="100" height="100"
                                        src="{{ asset('/images/profile.png') }}" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                <p class="text-muted text-center">
                                    {{ $user->telegram }}
                                    <span class="badge badge-success">{{ $user->skills }}</span>
                                </p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Joined</b></br>
                                        <b>Last seen</b></br>
                                        <b>Reaction score</b></br>
                                        <b>Total sell</b></br>
                                        <b>Total purchase</b></br>
                                        <b>Messages</b> <a class="float-right">{{ count($user->topics) }}</a>
                                    </li>
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
                                <p>
                                    {{ $user->education }}
                                </p>
                                <p>
                                    Contact tg : {{ $user->telegram }}
                                </p>
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
                                    <li class="nav-item active">
                                        <a class="nav-link active" href="#activity" data-toggle="tab">
                                            Latest Activity
                                        </a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline"
                                            data-toggle="tab">Timeline</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#settings"
                                            data-toggle="tab">Settings</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body m-t-5">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" width="5%" src="{{ asset('/images/profile.png') }}" alt="user image">
                                                <span class="username">
                                                    <a href="#">{{ $user->name }}</a>
                                                    <a href="#" class="float-right btn-tool">
                                                        {{-- <i class="fa fa-times" aria-hidden="true"></i> --}}
                                                    </a>
                                                </span>
                                                <span class="description">
                                                    Shared publicly - {{ $latest->created_at ?? '' }}
                                                </span>
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
                                        </div>
                                        <!-- /.post -->
                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" width="5%"
                                                    src="{{ asset('/images/profile.png') }}" alt="User Image">
                                                <span class="username">
                                                    <a href="#">{{ optional(optional($latest)->user)->name }}</a>
                                                    <a href="#" class="float-right btn-tool">
                                                        {{-- <i class="fa fa-times" aria-hidden="true"></i> --}}
                                                    </a>
                                                </span>
                                                <span class="description">Started a discussion -
                                                    {{ $latest->created_at ?? '' }}</span>
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
                                        </div>
                                        <!-- /.post -->
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="settings">
                                        <form action="{{ route('user.update', $user->id) }}" method="POST"
                                            class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="inputEducation" class="col-sm-2 col-form-label">About
                                                    you</label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" value="{{ $user->education }}"
                                                        class="form-control" name="education" id="inputEducation"
                                                        placeholder="{{ $user->education }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                                <div class="col-sm-10">
                                                    <input type="text" value="{{ $user->skills }}" class="form-control"
                                                        name="skills" id="inputSkills" placeholder="Skills">
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
            </section><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @endif
@endsection
