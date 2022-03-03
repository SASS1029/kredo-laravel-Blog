@extends('layouts.app')

@section('title' , 'Show')

@section('content') 
<div class="mt-2 border border-2 shadow-sm rounded py-3 px-4">
    <h2 class="h5">{{ $post->title}}</h2>
    <p>{{ $post->body}}</p>
    <img src="{{ asset('/storage/images/' . $post->image)}}"  alt="{{ $post->image}}" class="img-thumbnail">
</div>
<form action="{{ route('comment.store', $post->id) }}" method="post">
    @csrf 
    <div class="input-group mt-2">
        <input type="text" name="comment" placeholder="Write your comment here" value="{{ old('comment')}}" class="form-control">
        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    </div>
    @error('comment')
        <p class="text-danger small">{{ $message }}</p>
    @enderror
</form>
<!-- 一つの投稿に対して、今まで書かれてきたコメントを表示 -->
@if($comments->isNotEmpty())
    <div class="my-5 bg-secondary bg-opacity-25 rounded">
        @foreach($comments as $comment)
        <div class="row p-2">
            <div class="col-10">
                <p class="mb-0">
                    <span class="fw-bold">{{ $comment->user->name}}</span>
                    &nbsp;   <!-- &ampersand nonbreaking space -->
                    <span class="small text-muted">{{ $comment->created_at}}</span>
                </p>
                <p>{{ $comment->body}}</p>
            </div>
             <div class="col-2 text-end"> <!-- 自分が打ったコメントのみ削除できるようにする  -->
                @if($comment->user_id === Auth::user()->id)
                <form action="{{ route('comment.destroy', $comment->id)}}" method="post">
                    @csrf 
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
                @endif
            </div>

        </div>
        @endforeach
    </div>
@endif

@endsection

