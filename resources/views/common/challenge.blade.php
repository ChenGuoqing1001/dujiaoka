<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>检查您的连接是否安全</title>
    <link rel="stylesheet" href="/assets/challenge/css/style.css">
</head>
<body>
    <main class="status">
        <h1>检查您的连接是否安全</h1>
        <div class="loader"></div>
        <p id="progress">初始化...</p>
        <p id="continue" hidden>继续...</p>
    </main>
    <form method="GET" id="form" hidden>
        <input type="hidden" name="_challenge" value="">
    </form>
<!-- 在HTML中设置数据属性 -->
<div id="codeHolder" data-code="{{ $code }}" style="display: none;"></div>

<!-- 引入外部JavaScript -->
<script src="/assets/challenge/js/script.js"></script>

</body>
</html>
