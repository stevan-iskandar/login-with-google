@extends('template')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            @if (session('message'))
                            <div class="alert alert-{{ session('icon') }}">
                                {{ session('message') }}
                            </div>
                            @endif
                            <form class="user" method="post" action="{{ route('login.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}">
                                    <div class="ml-2 invalid-feedback">@error('email') {{ $message }} @enderror</div>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password">
                                    <div class="ml-2 invalid-feedback">@error('password') {{ $message }} @enderror</div>
                                </div>
                                <button type="submit" title="Subscribe" class="btn btn-primary btn-user btn-block">Login</button>
                                <hr>
                                <a href="{{ route('redirect.oauth2', ['type' => 'google']) }}" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="javascript:;">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="javascript:;">Already have an account? Login!</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
