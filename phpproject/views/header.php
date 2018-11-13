<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="public/assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<!--    <meta http-equiv="refresh" content="30">-->

    <title>CTF MONITORING | ACT.Warriors</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <link href="public/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="public/assets/css/fresh-bootstrap-table.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
<!--    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>-->
    <style>
        td > textarea {
            width: 100%;
            height: 90px;
            background: none repeat scroll 0 0;
            border-image: none;
            border-radius: 6px 6px 6px 6px;
            border-style: none solid solid none;
            border-width: medium 1px 1px medium;
            box-shadow: 0 1px 2px rgba( 0.12, 0.12, 0.12, 0.12) inset;
            font-size: 1em;
            line-height: 1.4em;
            transition: background-color 0.2s ease 0s;
        }
        /* Modal */
        .modal.left .modal-dialog{
            position: fixed;
            margin: auto;
            width: 40%;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }
        .modal.left .modal-content{
            height: 100%;
            overflow: hidden;
        }
        .modal.left .modal-body{
            padding: 15px 15px 80px;
        }
        .modal.left.fade .modal-dialog{
            left: -320px;
            -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
            -o-transition: opacity 0.3s linear, left 0.3s ease-out;
            transition: opacity 0.3s linear, left 0.3s ease-out;
        }
        .modal.left.fade.in .modal-dialog{
            left: 0;
        }
        .modal-content textarea {
            word-wrap: break-word;
            height: 600px;
            width: 100%;
            border-style: none;
        }
        .modal-header {
            border-bottom-color: #EEEEEE;
            background-color: #FAFAFA;
        }
    </style>
</head>