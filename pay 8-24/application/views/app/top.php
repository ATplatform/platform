<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JS Bin</title>
    <meta charset="utf-8">
    <meta name="Robots" content="All">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <script type="text/javascript">
        function getOnePx() {
            var dpi = window.devicePixelRatio,
                scalez = 1 / dpi;
            console.log(scalez);
            console.log(dpi);
            document.write('<meta content="width=device-width,initial-scale=' + scalez + ',maximum-scale=' + scalez +',user-scalable=no" name="viewport">')
        }
        function reset() {
            var htmlo = document.getElementsByTagName('html')[0],
                clientW = document.documentElement.clientWidth || document.body.clientWidth,
                fontSz = clientW / 10 + 'px';
            console.log(clientW);
            htmlo.style.fontSize = fontSz;
        }
        getOnePx();
        reset();
        window.addEventListener('resize', function () {
            setTimeout(function () {
                reset();
            }, 100);
        }, false)
    </script>
    <script src='<?=base_url().'application/views/plugin/jquery/jquery2.1.1.js'?>'></script>
    <script src='<?=base_url().'application/views/app/common.js'?>'></script>
</head>
<body>
