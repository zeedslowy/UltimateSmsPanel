@extends('admin')

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Manage SMS Template')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Manage SMS Template')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('sms/post-manage-sms-template')}}" method="post">


                                <div class="form-group">
                                    <label>{{language_data('Template Name')}}</label>
                                    <input type="text" class="form-control" required name="template_name" value="{{$st->template_name}}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('From')}}</label>
                                    <input type="text" class="form-control" name="from" value="{{$st->from}}"/>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Status')}}</label>
                                    <select class="form-control selectpicker" name="status">
                                        <option value="active" @if($st->status=='active') selected @endif>{{language_data('Active')}}</option>
                                        <option value="inactive"  @if($st->status=='inactive') selected @endif>{{language_data('Inactive')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Insert Merge Filed')}}</label>
                                    <select class="form-control selectpicker" id="merge_value">
                                        <option value="<%Phone Number%>">{{language_data('Phone Number')}}</option>
                                        <option value="<%Email Address%>">{{language_data('Email')}} {{language_data('Address')}}</option>
                                        <option value="<%User Name%>">{{language_data('User Name')}}</option>
                                        <option value="<%Company%>">{{language_data('Company')}}</option>
                                        <option value="<%First Name%>">{{language_data('First Name')}}</option>
                                        <option value="<%Last Name%>">{{language_data('Last Name')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Message')}}</label>
                                    <textarea class="form-control" id="message" name="message" rows="8">{{$st->message}}</textarea>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" @if($st->global=='yes') checked @endif value="yes" name="set_global">
                                        <span class="co-check-ui"></span>
                                        <label>Set as Global</label>
                                    </div>
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$st->id}}" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> {{language_data('Save')}}</button>
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

    <script>
        $(document).ready(function () {

            var merge_state = $('#merge_value');

            merge_state.on('change', function () {
                var merge_value = this;

                $('#message').val(function (_, v) {
                    return v + merge_value.value;
                });
            });


        });
    </script>

@endsection