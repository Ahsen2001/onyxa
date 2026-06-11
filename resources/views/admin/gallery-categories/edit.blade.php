@extends('layouts.admin')
@section('title','Edit Gallery Category')
@section('page-title','Edit Gallery Category')
@section('content')
    <form method="POST" action="{{ route('admin.gallery-categories.update',$galleryCategory) }}" class="max-w-2xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">@csrf @method('PUT') @include('admin.gallery-categories.partials.form',['category'=>$galleryCategory])</form>
@endsection
