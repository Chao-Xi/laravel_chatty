@extends('template.default')

@section('content')
   <div class="row">
   <div class='colg-lg-5'>
   <!--User information and status-->
   @include('user.partials.userblock');
   <hr/>
   </div>
   <div class="col-lg-4 col-lg-offset-3">
  <!--Friends, friend request-->
   </div>
</div>

@stop

