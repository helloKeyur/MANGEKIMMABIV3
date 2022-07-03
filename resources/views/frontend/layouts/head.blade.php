<!DOCTYPE html>
<html>
<head id="all-head">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{{{\App\Models\SysConfig::set()['system_title']}}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ url('/') }}/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="{{ url('/') }}/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/dist/css/skins/_all-skins.min.css">
    <link href="{{ url('/') }}/assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/custom/css/custom.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/DataTables/datatables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/loading/waitMe.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css">

    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/ElegantLoader/src/css/preloader.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/summernote/summernote.min.css">


      <link href="{{ url('/') }}/assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
      <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/plugins/tooltipster/dist/css/tooltipster.bundle.min.css" />


    {{-- <script src="{{ url('/') }}/assets/plugins/ElegantLoader/jquery.preloader.min.js"></script> --}}



    @yield('css')

    <style type="text/css">


.red{
    color: red;
}




.date_element {
    /*position: absolute;*/
    margin-top: 110px !important;
    text-align:center;
}


.text-11{
      font-size: 11px;
      font-weight: bold;
     }



        .dashed-table {
            border: dashed 1px #00c0ef;
        }

        .loader {
            border: 8px solid #ebf7d0;
            border-radius: 50%;
            border-top: 8px solid #3CB371;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #3CB371;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }

        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
</head>
