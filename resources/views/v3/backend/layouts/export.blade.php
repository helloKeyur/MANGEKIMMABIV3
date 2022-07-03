<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <style type="text/css">
        .clearfix:after {
          content: "";
          display: table;
          clear: both;
      }
      body {
          position: relative;
          width: 21cm;  
          height: 29.7cm; 
          margin: 0 auto; 
          color: #001028;
          background: #FFFFFF; 
          font-family: Arial, sans-serif; 
          font-size: 12px; 
          font-family: Arial;
      }
      table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
      }

      table tr:nth-child(2n-1) td {
          background: #F5F5F5;
      }

      table th,
      table td {
          text-align: center;
      }

      table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;        
          font-weight: normal;
      }

      table .service,
      table .desc {
          text-align: left;
      }

      table td {
          padding: 20px;
          text-align: left;
      }

      table td.service,
      table td.desc {
          vertical-align: top;
      }

      table td.unit,
      table td.qty,
      table td.total {
          font-size: 1.2em;
      }

      table td.grand {
          border-top: 1px solid #5D6975;;
      }

      .text-center{
        text-align: center;
      }

      .border-top-bootom-1{
        border-top: 1px solid gray;
        border-bottom: 1px solid gray;
      }
      .py-4{
        padding-top:16px;
        padding-bottom:16px;
      }

      .my-4{
        margin-top:16px;
        margin-bottom:16px;
      }

      .px-4{
        padding-left:16px;
        padding-right:16px;
      }

      .mx-4{
        margin-left:16px;
        margin-right:16px;
      }

      .row > .col-4{
        width: 33%;
        display: inline-block;
      }

      .row > .col-6{
        width: 49%;
        display: inline-block;
      }

      .border-1{
        border:1px solid gray;
      }

      .text-right{
        text-align: right;
      }
  </style>
  </head>
  <body>
    @yield('content')
  </body>
</html>