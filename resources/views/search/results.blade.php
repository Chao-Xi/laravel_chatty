@extends('template.default')

@section('content')
   <h3>You Search for "{{ Request::input('query') }}"</h3>
   @if(!$users->count())
      <p>No results found,sorry</p>
   @else 
   <div class="row">
   <div class="col-lg-12">
        @foreach($users as $user)
           @include('user/partials/userblock')
        @endforeach   
   </div>  
   </div>
   @endif
@stop