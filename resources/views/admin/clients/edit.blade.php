@extends('layouts.admin')

@section('title', 'Edit Client Logo')
@section('page-title', 'Edit Client Logo')

@section('content')
    <form method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.clients.partials.form')
    </form>
@endsection
