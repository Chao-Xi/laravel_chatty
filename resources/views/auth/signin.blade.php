@extends('template.default')

@section('content')
<h3>Sign Up</h3>
   <div class="row">
   <div class="col-lg-6">
      <form class="form-vertical" role="form" method="POST" action="{{route('auth.signin')}}">
         <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
          <label for="email" class="control-label">Email</label>
          <input type="text" name="email" class="form-control" id="email">
          @if($errors->has('email'))
              <span class="help-block">{{ $errors->first('email') }}</span> 
          @endif
         </div>

           <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
           <label for="password" class="control-label">Password</label>
           <input type="password" name="password" class="form-control" id="password" > 
            @if($errors->has('email'))
              <span class="help-block">{{ $errors->first('password') }}</span> 
            @endif
          </div>
           
           <div class="form-group">
            <label>
            <input type="checkbox" name="remember">Remember me
            </label>

           <div class="form-group">
            <button type="submit" class="btn btn-default">Sign in</button>
            <input type="hidden" name="_token" value="{{Session::token()}}">
         </div>
      </form>
   </div>
   </div>
@stop