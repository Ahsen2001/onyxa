@extends('layouts.admin')
@section('title', 'Add Event')
@section('page-title', 'Add Event')
@section('content')
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.events.partials.form', ['event' => null])
    </form>
@endsection
