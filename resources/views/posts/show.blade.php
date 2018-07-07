@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ $post->title }}
                        @auth
                            @can('edit', $post)
                                <div class="d-inline-block p-2 float-right">
                                    <form action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="post">
                                        @csrf
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
                                        <input type="hidden" name="_method" value="delete">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            @endcan
                        @endauth
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{$post->content}}
                        </p>
                        <br>
                        Category/-ies :
                        @foreach($post->cat as $cat )
                            <a class="badge badge-info" href="href={{route('categories.show', ['cat_id' =>$cat->id])}}">{{ $cat->name }}</a>
                            <span class="badge badge-info">{{ $cat->name }}</span>
                        @endforeach
                        <br>
                        <small>Created at: {{$post->created_at}} by</small>
                        <span class="badge badge-info">{{$post->thisIsUserObject -> name}}</span>
                        <br>
                        <ul>
                            @foreach($post->fileObject as $file)
                                {{--show image--}}
                                <li><a href={{ asset('/storage/'.$file->path) }}> {{ $file->name }} </a></li>
                                {{--download image --}}
                                <li> Download : <a href={{route('dwn_file',['id'=> $file->id]) }}> {{ $file->name }} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

