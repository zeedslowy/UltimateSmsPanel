@extends('admin')

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('SMS Gateway Manage')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('SMS Gateway Manage')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{url('sms/post-manage-sms-gateway')}}">
                                {{ csrf_field() }}

                                @if($gateway->custom=='Yes')
                                    <div class="form-group">
                                        <label>{{language_data('Gateway Name')}}</label>
                                        <input type="text" class="form-control" required name="gateway_name" value="{{$gateway->name}}">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>{{language_data('Gateway Name')}}</label>
                                        <input type="text" class="form-control" value="{{$gateway->name}}" disabled>
                                    </div>
                                @endif

                                @if($gateway->name!='Twilio' && $gateway->name!='Zang' && $gateway->name!='Plivo' && $gateway->name!='AmazonSNS' && $gateway->name!='TeleSign' && $gateway->name!='BSG')
                                    <div class="form-group">
                                        <label>{{language_data('Gateway API Link')}}</label>
                                        <input type="text" class="form-control" required name="gateway_link" value="{{$gateway->api_link}}">
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label>
                                        @if($gateway->name=='Telenorcsms')
                                            {{language_data('Msisdn')}}
                                        @elseif($gateway->name=='Twilio' || $gateway->name=='Zang')
                                            {{language_data('Account Sid')}}
                                        @elseif($gateway->name=='Plivo')
                                            {{language_data('Auth ID')}}
                                        @elseif($gateway->name=='Wavecell')
                                           Sub Account ID
                                        @elseif($gateway->name=='Skebby')
                                            User Key
                                        @elseif($gateway->name=='Ovh')
                                            APP Key
                                        @elseif($gateway->name=='MessageBird' || $gateway->name=='AmazonSNS')
                                            Access Key
                                        @elseif($gateway->name=='Clickatell' || $gateway->name=='ViralThrob' || $gateway->name=='CNIDCOM' || $gateway->name=='SmsBump' || $gateway->name=='BSG')
                                            API Key
                                        @elseif($gateway->name=='Semysms' || $gateway->name=='Tropo')
                                            User Token
                                        @elseif($gateway->name=='SendOut')
                                            Phone Number
                                        @elseif($gateway->name=='Dialog')
                                            API Password
                                        @elseif($gateway->name=='LightSMS')
                                            Login
                                        @elseif($gateway->name=='CheapSMS')
                                            Login ID
                                        @elseif($gateway->name=='TxtNation')
                                            Company
                                        @else
                                            {{language_data('SMS Api User name')}}
                                        @endif
                                    </label>
                                    <input type="text" class="form-control" name="gateway_user_name" value="{{$gateway->username}}">
                                </div>

                                @if($gateway->name!='MessageBird' && $gateway->name!='Clickatell' && $gateway->name!='Dialog' && $gateway->name!='Tropo' && $gateway->name!='SmsBump' && $gateway->name!='BSG')
                                <div class="form-group">
                                    <label>
                                        @if($gateway->name=='Twilio' || $gateway->name=='Zang' || $gateway->name=='Plivo')
                                            {{language_data('Auth Token')}}
                                        @elseif($gateway->name=='SMSKaufen' || $gateway->name=='NibsSMS' || $gateway->name=='LightSMS' || $gateway->name=='Wavecell')
                                            {{language_data('SMS Api key')}}
                                        @elseif($gateway->name=='Semysms')
                                            Device ID
                                        @elseif($gateway->name=='SendOut')
                                            API Token
                                        @elseif($gateway->name=='Skebby')
                                            Access Token
                                        @elseif($gateway->name=='Ovh'  || $gateway->name=='CNIDCOM')
                                            APP Secret
                                        @elseif($gateway->name=='AmazonSNS')
                                            Secret Access Key
                                        @elseif($gateway->name=='ViralThrob')
                                            SaaS Account
                                        @elseif($gateway->name=='TxtNation')
                                            eKey
                                        @else
                                            {{language_data('SMS Api Password')}}
                                        @endif
                                    </label>
                                    <input type="text" class="form-control" name="gateway_password" value="{{$gateway->password}}">
                                </div>
                                @endif

                                @if($gateway->custom=='Yes' || $gateway->name=='SmsGatewayMe'  || $gateway->name=='Asterisk' || $gateway->name=='GlobexCam' || $gateway->name=='Ovh' || $gateway->name=='1s2u' || $gateway->name=='SMSPRO' || $gateway->name=='DigitalReach' || $gateway->name=='AmazonSNS' || $gateway->name=='ExpertTexting' || $gateway->name=='JasminSMS' || $gateway->type=='smpp')
                                <div class="form-group">
                                    @if($gateway->name=='SmsGatewayMe')
                                        <label>Device ID</label>
                                    @elseif($gateway->name=='Asterisk' || $gateway->name=='JasminSMS' || $gateway->type=='smpp')
                                        <label>Port</label>
                                    @elseif($gateway->name=='GlobexCam')
                                        <label>{{language_data('SMS Api key')}}</label>
                                    @elseif($gateway->name=='Ovh')
                                        <label>Consumer Key</label>
                                    @elseif($gateway->name=='1s2u')
                                        <label>IPCL</label>
                                    @elseif($gateway->name=='SMSPRO')
                                        <label>Customer ID</label>
                                    @elseif($gateway->name=='DigitalReach')
                                        <label>MT Port</label>
                                    @elseif($gateway->name=='AmazonSNS')
                                        <label>Region</label>
                                    @elseif($gateway->name=='ExpertTexting')
                                        <label> {{language_data('SMS Api key')}}</label>
                                    @else
                                        <label>{{language_data('Extra Value')}}</label>
                                    @endif
                                    <input type="text" class="form-control" name="extra_value" value="{{$gateway->api_id}}">
                                </div>
                                @endif

                                @if($gateway->name=='Asterisk' )
                                <div class="form-group">
                                    <label>Device Name</label>
                                    <input type="text" class="form-control" name="device_name" value="{{env('SC_DEVICE')}}">
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>{{language_data('Schedule SMS')}}</label>
                                    <select class="selectpicker form-control" name="schedule">
                                        <option value="Yes" @if($gateway->schedule=='Yes') selected @endif>{{language_data('Yes')}}</option>
                                        <option value="No" @if($gateway->schedule=='No') selected @endif>{{language_data('No')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Status')}}</label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="Active"  @if($gateway->status=='Active') selected @endif>{{language_data('Active')}}</option>
                                        <option value="Inactive"  @if($gateway->status=='Inactive') selected @endif>{{language_data('Inactive')}}</option>
                                    </select>
                                </div>

                                <input type="hidden" value="{{$gateway->id}}" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> {{language_data('Update')}} </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
@endsection