@extends('layouts.app')

@section('title' , 'Profile')

@section('content') 
<div class="row mt-2 mb-5">
    <div class="col-4">
        @if($user->avatar)
        <img src="{{ asset('storage/avatars/' . $user->avatar)}}" alt="{{ $user->avatar }}" class="img-thumbnail"> 
        @else
        <i class="far fa-image fa-10x d-block text-center"></i> 
        @endif
    </div>
    <div class="col-8 p-3 d-flex flex-column">
        <h2 class="mb-auto display-6">{{ $user->name }}</h2>
        <a href="{{ route('user.edit')}}" class="text-decoration-none">Edit Profile</a>         
    </div> 
</div>
@if($my_posts->isNotEmpty())
<ul class="list-group mb-5">
    @foreach($my_posts as $post)
    <li class="list-group-item">
        <h3 class="h5">{{ $post->title}}</h3>
        <p class="fw-light mb-0">{{ $post->body}}</p>
    </li>
    @endforeach
</ul>

@endif

@endsection