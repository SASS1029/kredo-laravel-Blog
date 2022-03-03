@extends('layouts.app')

@section('title','Create Post')

@section('content')

<form action="{{ route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-lapel">Title</label>             <!-- 他のところ（テキスト、image）でエラーがあった時にまた１から書くのを防ぐため -->
        <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" placeholder="Enter title here" autofocus>
        @error('title')
            <p class=" small text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="body" class="form-lapel">Title</label>
        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body')}}</textarea>
        @error('body')
            <p class=" small text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-3">
        <input type="file" name="image"  class="form-control" >
        @error('image')
            <p class=" small text-danger">{{$message}}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection