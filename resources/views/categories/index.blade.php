@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                    @forelse($categories as $category)

                        <div class="card mt-4">
                            <h5 class="card-header">{{$category->name}}</h5>
                            <div class="card-body">
                                <p class="card-text">{!!str_limit($category->content,100)!!}
                                </p>
                                <br>
                                <small>{{$category->created_at}}</small>
                                <br>
                                <a href={{route('categories.show', ['id'=>$category->id])}}>Read more</a>
                            </div>

                        </div>
                    @empty
                        <p>No categories...</p>
                    @endforelse
            </div>
        </div>
    </div>
@endsection

