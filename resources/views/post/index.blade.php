@extends('layouts.main')
@section('content')

    <div>
        <div>
            <a class="btn btn-primary" href="{{route('post.create')}}">Add one</a>
        </div>
        @foreach($posts as $post)
            <div><a href="{{route('post.show',$post->id)}}">{{$post->id}}. {{$post->title}}</a></div>

        @endforeach

        <div class="mt-3">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>

@endsection
