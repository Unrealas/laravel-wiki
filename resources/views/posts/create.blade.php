@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Create new post
                    </div>
                    <div class="card-body">
                        {{--Form Start--}}
                        <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="cat">Category</label>
                                <select class="form-control" id="cat" name="cat[]" multiple>
                                    @foreach($cat as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                            <div class="form-group">
                                <label for="file">Attach file:</label>
                                <input type="file" name="file[]" id="file" multiple>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
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

