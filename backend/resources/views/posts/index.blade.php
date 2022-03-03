<!-- homeを表示 -->
@extends('layouts.app')

@section('title' , 'Index')

@section('content')
@if($all_posts->isNotEmpty())
    @foreach($all_posts as $post)
        <div class="mt-2 border border-2 rounded py-3 px-4">
            <h2 class="h5">
                <a href="{{ route('post.show',$post->id)}}">{{ $post->title }}</a>
            </h2>
            <p class="mb-0">
                {{$post->body}}
            </p>

            <!-- 他の人の編集しないように -->
            @if($post->user_id === Auth::user()->id)
            <form action="{{ route('post.destroy' , $post->id)}}" method="post" class="text-end mt-2">
              @csrf
               @method('DELETE')
               <!-- go to the edit page -->
               <a href="{{ route('post.edit' , $post->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <!-- delete a post -->
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
            </form>
            @endif
        </div>

    @endforeach
@endif
@endsection

