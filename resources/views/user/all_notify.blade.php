 @extends('layouts.master')
 @section('title')
     الاشعارات
 @endsection
 @section('page-header')
     <!-- breadcrumb -->
     <div class="breadcrumb-header justify-content-between">
         <div class="my-auto">
             <div class="d-flex">
                 <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     الاشعارات</span>
             </div>
         </div>
     </div>
     <!-- breadcrumb -->
 @endsection
 @section('content')

            <div class="card-body">
         <div>
             @foreach ($notifications as $notifications)
                 <div class="card my-2">
                     <div class="card-body">

                         {{-- @if ($notifications->unread()) --}}
                             <a href="{{ route('admin.show_notify', $notifications->id) }}"
                                 style="text-decoration: none;color: red">
                         {{-- @endif --}}
                         <h4>{{ $notifications->data['title'] }}</h4> </a>
                         <p> {{ $notifications->data['body'] }}</p>
                         <p> user: {{ $notifications->data['user'] }}</p>
                         <p class="text-muted">{{ $notifications->created_at->diffForhumans() }}</p>

                     </div>
                     <form action="{{ route('delete_notify', $notifications->id) }}" method="post">
                         @csrf
                         @method('delete')
                         <button class="btn btn-outline-danger" type="submit">Delete Notification</button>
                     </form>
                 </div>
             @endforeach
         </div>

         @if ($notifications->count() !== 0)
             {{-- <form action="{{ route('notification.destroyall') }}" method="post">
                 @csrf
                 @method('delete')
                 <button class="btn btn-outline-primary" type="submit">Clear all Notifications</button>
             </form> --}}
         @endif
     </div>
 @endsection
