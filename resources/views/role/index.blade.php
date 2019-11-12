@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-md-4 offset-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Payment Details
                </h3>
                <div class="checkbox pull-right">
                    <label>
                        <input type="checkbox" />
                        Remember
                    </label>
                </div>
            </div>
            <div class="panel-body">
                <form role="form" action="{{ url('role/update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cardNumber">
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cardNumber" placeholder="Valid Card Number"
                                    autofocus />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expityMonth">
                                    EXPIRY DATE</label>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control" id="expityMonth" placeholder="MM"  />
                                </div>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control" id="expityYear" placeholder="YY"  /></div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" class="form-control" id="cvCode" placeholder="CV"  />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Pay</button>
                </form>
            </div>
        </div>
    </div>
@endsection
