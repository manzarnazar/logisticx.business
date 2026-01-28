<?php

$php_version_success = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$timezone_success = false;

$php_version_required = '8.1';
$current_php_version = PHP_VERSION;

//check required php version
if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}

//check mySql
if (function_exists('mysqli_connect')) {
    $mysql_success = true;
}

//check curl
if (function_exists('curl_version')) {
    $curl_success = true;
}

//check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}


//check allow_url_fopen
$timezone_settings = ini_get('date.timezone');
if ($timezone_settings) {
    $timezone_success = true;
}

//check if all requirement is success
if ($php_version_success && $mysql_success && $curl_success && $gd_success && $timezone_success) {
    $all_requirement_success = true;
} else {
    $all_requirement_success = false;
}


if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) {
    $writeable_directories = ['../routes', '../resources', '../public', '../storage', '../.env'];
} else {
    $writeable_directories = ['./routes', './resources', './public', './storage', '.env'];
}

foreach ($writeable_directories as $value) {
    if (!is_writeable($value)) {
        $all_requirement_success = false;
    }
}

$dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $dashboard_url = 'https://' . $dashboard_url;
} else {
    $dashboard_url = 'http://' . $dashboard_url;
}

//include "view/index.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="advancescripts">
    <link rel="icon" href="{{ asset('uploads/seeders/favicon.png') }}" />
    <title>{{env('APP_NAME')}} - Installation</title>
    <link rel='stylesheet' type='text/css' href="{{ asset('installer/bootstrap.min.css') }}" />


    <link rel='stylesheet' type='text/css' href="{{ asset('installer/assets/css/install.css') }}" />
    <link rel='stylesheet' type='text/css' href="{{ asset('installer/assets/css/styleone.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/cdn-to-custom') }}/bootstrap-float-label.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('installer/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('installer/') }}/font-awesome.css" />
    <style>
        .text-center {
            text-align: center !important;
        }
    </style>


</head>

<body>
    <div class="container">

        <div class="row">

            <div class="wizard-inner">
                <div id="alert-container " class="text-left">

                    @if (session('error'))
                        <div id="error_m" class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div id="success_m" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @isset($errors)
                        @if ($errors->any())
                            <div class="alert alert-danger" id="error_m">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @endif
                    </div>

                    <form name="config-form" id="msform" action="{{ route('install') }}" method="post">
                        @csrf

                        <div class="section newsletter_box">
                            <div class="col-md-12">
                                <div class="panel-heading text-center">
                                    <h2>Welcome To Parcelyfly</h2>
                                    <h2>{{env('APP_NAME')}} - Installation</h2>
                                </div>
                            </div>

                            <div class="col-md-12 section-item">

                                <h4 class="pb-20 pt-20">Please configure your PHP settings to match following requirements</h4>

                                <table>
                                    <thead>
                                        <tr>
                                            <th width="25%">PHP Settings</th>
                                            <th width="27%">Current Version</th>
                                            <th>Required Version</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>PHP Version</td>
                                            <td><?php echo $current_php_version; ?></td>
                                            <td><?php echo $php_version_required; ?>+</td>
                                            <td class="text-center">
                                                <?php if ($php_version_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 section-item">
                                <h4 class="pb-20"> Please make sure the extensions/settings listed below are
                                    installed/enabled</h4>
                                <table>
                                    <thead>
                                        <tr>
                                            <th width="25%">Extension/settings</th>
                                            <th width="27%">Current Settings</th>
                                            <th>Required Settings</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>MySQLi</td>
                                            <td> <?php if ($mysql_success) { ?>
                                                On
                                                <?php } else { ?>
                                                Off
                                                <?php } ?>
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                <?php if ($mysql_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>GD</td>
                                            <td> <?php if ($gd_success) { ?>
                                                On
                                                <?php } else { ?>
                                                Off
                                                <?php } ?>
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                <?php if ($gd_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>cURL</td>
                                            <td> <?php if ($curl_success) { ?>
                                                On
                                                <?php } else { ?>
                                                Off
                                                <?php } ?>
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                <?php if ($curl_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OpenSSL PHP Extension</td>
                                            <td>
                                                @if (OPENSSL_VERSION_NUMBER < 0x009080bf)
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @else
                                                    On
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (OPENSSL_VERSION_NUMBER < 0x009080bf)
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PDO PHP Extension</td>
                                            <td>
                                                @if (PDO::getAvailableDrivers())
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (PDO::getAvailableDrivers())
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>BCMath PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('bcmath'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('bcmath'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ctype PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('ctype'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('ctype'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fileinfo PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('fileinfo'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('fileinfo'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mbstring PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('mbstring'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('mbstring'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tokenizer PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('tokenizer'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('tokenizer'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>XML PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('xml'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('xml'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>JSON PHP Extension</td>
                                            <td>
                                                @if (extension_loaded('json'))
                                                    On
                                                @else
                                                    @php $all_requirement_success = false; @endphp
                                                    Off
                                                @endif
                                            </td>
                                            <td>On</td>
                                            <td class="text-center">
                                                @if (extension_loaded('json'))
                                                    <i class="status fa fa-check-circle-o"></i>
                                                @else
                                                    <i class="status fa fa-times-circle-o"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td>date.timezone</td>
                                            <td> <?php if ($timezone_success) {
                                                echo $timezone_settings;
                                            } else {
                                                echo 'Null';
                                            } ?>
                                            </td>
                                            <td>Timezone</td>
                                            <td class="text-center">
                                                <?php if ($timezone_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                                <?php } ?>
                                            </td>
                                        </tr> --}}

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 section-item">
                                <h4 class="pb-20">Please make sure you have set the writable permission on the following
                                    folders/files</h4>
                                <table>
                                    <tbody>
                                        <?php
                                                        foreach ($writeable_directories as $value) {
                                                            ?>
                                        <tr>
                                            <td id="first-td" class="text-left"><?php echo $value; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (is_writeable($value)) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                                <?php
                                                                    } else {
                                                                        $all_requirement_success = false;
                                                                        ?>
                                                <i class="status fa fa-times-circle-o"
                                                    style="color:#d73b3b!important"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                                        }
                                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 section-item">
                                <h4 class="pb-5">Please enter your database connection details.</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('host') ?? 'localhost' }}"
                                                id="host" name="host" placeholder="Enter Database Host" class="form-control has-content" />


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('dbuser') ?? 'root' }}" name="dbuser"
                                                class="form-control has-content" placeholder="Enter Database User" autocomplete="off" id="dbuser" />


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="password" value="{{ old('dbpassword') ?? '' }}"
                                                name="dbpassword" placeholder="Enter Database Password" id="dbpassword" class="form-control "
                                                autocomplete="off" />


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('dbname') ?? '' }}" name="dbname"
                                                class="form-control" placeholder="Enter Database Name" id="dbname" />


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 section-item">
                                <h4 class="pb-5">Please enter your account details for administration.</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('first_name') ?? '' }}" id="first_name"
                                                name="first_name" placeholder="Enter First Name" class="form-control" />


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('last_name') ?? '' }}" id="last_name"
                                                name="last_name" placeholder="Enter Last Name" class="form-control" />


                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{ old('email') ?? '' }}" name="email"
                                                class="form-control" placeholder="Enter Email" id="email" />


                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <input type="password" value="{{ old('password') ?? '' }}" name="password"
                                                id="password" placeholder="Enter Password" class="form-control" />


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 section-item">

                                <div class="panel-footer">

                                    <button type="submit"
                                        class="btn btn-info puprple_btn form-next right btn-finish-old"
                                        style="position: relative!important" {{$all_requirement_success ? '':'disabled'}}>
                                        {{-- <span class="loader hide"> Installing...</span> --}}
                                        <span class="button-text"></i>Finish</span>
                                    </button>
                                </div>
                            </div>


                        </div>



                    </form>
                </div>


            </div>
        </div>


        <script src="{{ asset('frontend')}}/assets/js/jquery-3.7.0.min.js"></script>
        <script src="{{ asset('backend')}}/vendor/sweetalert2/js/sweetalert2.all.min.js"></script>

        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });
            });

            function alertMessage(message, icon = 'error') {

                const Toast = Swal.mixin({
                    toast: true
                    , position: 'bottom-end'
                    , showConfirmButton: false
                    , timer: 3000
                    , timerProgressBar: true
                    , didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: icon
                    , title: message
                })
            }


            @if(session('success'))
            alertMessage("{{ session('success') }}", "success");
            @endif

            @if(session('danger'))
            alertMessage("{{ session('danger') }}", "error");
            @endif

        </script>
    </body>

    </html>
