@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Edit post: <b>{{$cat ->name}}</b>
                    </div>
                    <div class="card-body">
                        {{--Form Start--}}
                        <form action="{{route('categories.update',['id'=> $cat->id])}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value={{$cat->name}}>
                            </div>
                            <div class="form-group">
                                <label for="cat">Category</label>
                                <select class="form-control" id="cat" name="cat">

                                    @foreach($cat as $c)
                                        <option value={{$c->id}}>{{$c->name}}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="3" >{{$post->content}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-info">Save post</button>
                            <br>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                        {{--Form end--}}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

