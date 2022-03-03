@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row mb-3">
        <div class="col-4">
            @if($user->avatar)
            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail">
            @else
            <i class="far fa-image fa-10x"></i>
            @endif

            <input type="file" name="avatar" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection




















