@extends('profiles.profile')

@section('profile')
    <form class="form" action="{{ route('profile.update', [$user]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" value="{{ $user->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" value="{{ $user->email }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Save Changes</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 col-sm-6 mb-3">
            <form action="{{ route('profile.changePassword', [$user]) }}" method="POST">
                @csrf
                <div class="mb-2"><b>Change Password</b></div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" type="password" name="new_password">
                            @error('new_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                            <input class="form-control {{ $errors->has('repeat_password') ? 'is-invalid' : '' }}" type="password" name="repeat_password">
                            @error('repeat_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 col-sm-6 mb-3">
            <form action="{{ route('profile.changeAvatar', [$user]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-2"><b>Change Avatar</b></div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Choose Picture</label>
                            <input class="form-control-file {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" name="avatar">
                            @error('avatar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-camera"></i>
                            <span>Change Photo</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
