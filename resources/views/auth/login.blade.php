@extends('layouts.auth', ['title' => 'Login'])

@section('content')

<div class="col-xl-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-3 mb-0">
                <div class="card-body">

                    <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                        <div class="auth-title-section mb-3 text-center">
                            <h3 class="text-dark fs-20 fw-medium mb-2">Welcome back</h3>
                            <p class="text-dark text-capitalize fs-14 mb-0">Sign in to continue.</p>
                        </div>

                        <div class="pt-0">
                            <form method="POST" action="#" class="my-4">
                                
                                @csrf
                                @if (sizeof($errors) > 0)
                                @foreach ($errors->all() as $error)
                                <p class="text-danger mb-3">{{ $error }}</p>
                                @endforeach
                                @endif
                                <div class="form-group mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                                </div>

                                <div class="form-group d-flex mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <a class='text-muted fs-14' href='#'>Forgot password?</a>
                                    </div>
                                </div>

                                <div class="form-group mb-0 row">
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit"> Log In </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-xl-7">
    <div class="account-page-bg p-md-5 p-4">
        <div class="text-center">
            <div class="auth-image">
                <img src="{{ asset('images/auth-images.svg') }}" class="mx-auto img-fluid" alt="images">
            </div>
        </div>
    </div>
</div>

@endsection