@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{$posts->links()}}

                @foreach($posts as $pos)
                    @forelse($pos->cats as $post)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{ $post->title }}
                            @auth
                                @can('edit', $post)
                                    <div class="d-inline-block p-2 float-right">

                                        <form action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="post">
                                            @csrf
                                            <a class="btn btn-primary btn-sm" href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>

                                        </form>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                        <div class="card-body">
                            <p class="card-text">{!!str_limit($post->content,100)!!}
                            </p>
                            <br>

                            @foreach($post->cat as $cat )
                                <span class="badge badge-info">{{ $cat->name }}</span>
                            @endforeach
                            <br>
                            <small>{{$post->created_at}}</small>
                            <br>

                            <a href={{route('posts.show', ['id'=>$post->id])}}>Read more</a>
                            <br>
                        </div>
                    </div>
                @empty
                    <p>No posts...</p>
                @endforelse
                @endforeach
                <br>
                {{$posts->links()}}
            </div>
        </div>
    </div>
@endsection

