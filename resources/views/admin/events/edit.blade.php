@extends('layouts.admin')
@section('title', 'Edit Event')
@section('page-title', 'Edit Event')
@section('content')
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.events.partials.form', ['event' => $event])
    </form>
@endsection
