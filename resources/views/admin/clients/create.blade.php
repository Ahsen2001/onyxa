@extends('layouts.admin')

@section('title', 'Add Client Logo')
@section('page-title', 'Add Client Logo')

@section('content')
    <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.clients.partials.form')
    </form>
@endsection
