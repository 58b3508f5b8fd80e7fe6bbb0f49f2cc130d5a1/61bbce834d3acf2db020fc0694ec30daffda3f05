@if(!isset($error))
    <div id="tlsavings-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{config('app.description')}}</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="tlpay-auth-form" action="{{url('/api/tlpay')}}" method="post">
                            <input type="hidden" name="amount" value="{{$amount}}">
                            <input type="hidden" name="description" value="{{$description}}">
                            <input type="hidden" name="email" value="{{$email}}">
                            <input type="hidden" name="callback" value="{{$callback}}">
                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="hidden" name="key" value="{{$key}}">
                            <div class="alert alert-primary">
                                <table class="table">
                                    <tr>
                                        <td class="text-right">Email</td>
                                        <td class="text-left">{{$email}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Description</td>
                                        <td class="text-left">Payment for {{$description}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Amount:</td>
                                        <td class="text-left">{{$amount}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card" style="padding:12px;">
                                <div class="form-group">
                                    <label for="name"></label>
                                    <input id="name" class="form-control" type="text" name="name"
                                           placeholder="Enter User ID">
                                <div>
                                <div class="form-group">
                                    <label for="pin"></label>
                                    <input id="pin" class="form-control" type="password" name="pin"
                                           placeholder="Enter Pin">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input class="btn btn-success" type="submit" value="Pay now..">
                            </div>
                        </form>
                    </div>
                    <div><p class="text-center">Powered by <span class="text-info strong">{{config('app.name')}}</span>
                        </p></div>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="tlsavings-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{config('app.description')}}</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger">
                            <p class="text-center">{{$error}}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif