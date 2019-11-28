@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-md-4 offset-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Payment Details
                </h3>
            </div>
            <div class="panel-body">
                <form role="form" action="{{ url('role/update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cardNumber">
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" name="cardNumber" class="form-control {{ $errors->has('cardNumber') ? 'is-invalid' : '' }}" id="cardNumber" placeholder="Valid Card Number"
                                    autofocus />
                            @error('cardNumber')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expiryMonth">
                                    EXPIRY DATE</label>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" name="expiryMonth" class="form-control {{ $errors->has('expiryMonth') ? 'is-invalid' : '' }}" id="expiryMonth" placeholder="MM"  />
                                    @error('expiryMonth')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" name="expiryYear" class="form-control {{ $errors->has('expiryYear') ? 'is-invalid' : '' }}" id="expiryYear" placeholder="YY"  />
                                    @error('expiryYear')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" name="cvCode" class="form-control {{ $errors->has('cvCode') ? 'is-invalid' : '' }}" id="cvCode" placeholder="CV"  />
                                @error('cvCode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Pay</button>
                </form>
            </div>
        </div>
    </div>
@endsection
