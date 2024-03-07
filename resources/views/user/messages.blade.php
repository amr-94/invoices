@extends('layouts.master')
@section('title')
    الرسائل
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الرسائل</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <table class="table table-srtiped " style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>content</th>
                <th>from_user</th>
                <th>Created_at</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($message as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->title }}</td>
                    <td>{{ $message->content }}</td>
                    <td><a
                            href="{{ route('admin.show', [$message->from_user->id]) }}">{{ $message->from_user->name }}</a>
                    </td>
                    <td>{{ $message->created_at->diffforhumans() }}</td>
                    <td>
                        <form class="form" action="{{ route('admin.delete_message', $message->id) }}"
                            method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
