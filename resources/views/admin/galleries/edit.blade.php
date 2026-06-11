@extends('layouts.admin')
@section('title','Edit Gallery Image')
@section('page-title','Edit Gallery Image')
@section('content')
    <form method="POST" action="{{ route('admin.galleries.update',$gallery) }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">@csrf @method('PUT') @include('admin.galleries.partials.form',['gallery'=>$gallery])</form>
@endsection
