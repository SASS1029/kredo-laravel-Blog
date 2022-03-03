@extends('layouts.app')

@section('title', 'Edit')

@section('content')
<form action="{{ route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="title" class="form-lapel">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{old('title', $post->title)}}" placeholder="Enter title here" autofocus>
        @error('title')
            <p class=" small text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="body" class="form-lapel">Title</label>
        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body', $post->body)}}</textarea>
        @error('body')
            <p class=" small text-danger">{{$message}}</p>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <img src="{{ asset('/storage/images/' . $post->image)}}" alt="{{ $post->image}}" class="img-thumbnail">
            <input type="file" name="image"  class="form-control" >
            @error('image')
                <p class=" small text-danger">{{$message}}</p>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-warning">Save</button>
</form>
@endsection