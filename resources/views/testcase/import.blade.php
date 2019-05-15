@extends('layouts.index')

@section('content')
    <div class="pt-3"></div>
    <h4 class="font-weight-bold">Import CSV file</h4>
    <div class="pt-3"></div>
    @if(!empty($message))
        @if($alert == 'success')
            <div class="alert alert-success"> {{ $message }} </div>
        @elseif($alert == 'error')
            <div class="alert alert-danger"> {{ $message }} </div>
        @endif
    @endif
    <form id="frmForm" method="post" enctype="multipart/form-data" class="w-50">
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-md-3">CSV File</label>
            <div class="col-md-9">
                <input id="file" name="csvfile" type="file" class="form-control-file">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3"></label>
            <div class="col-md-9">
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#frmForm").validate({
                rules: {
                    csvfile: { required: true },
                },

            });

            $('.btn-submit').click(function(){
                if ($("#frmForm").valid()) {
                    $("#frmForm").submit();
                }
            });
        });
    </script>
@endsection