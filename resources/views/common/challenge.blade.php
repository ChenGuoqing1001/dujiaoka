<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>检查您的连接是否安全</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <style>
        .status {
            padding: 5vh 10vw;
            font-size: xx-large;
            font-family: Helvetica, Tahoma, Arial, "PingFang SC", "Hiragino Sans GB", "Heiti SC", "Microsoft YaHei", "WenQuanYi Micro Hei";
        }
        .loader {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            border: .3rem solid #f5f5f5;
            border-top-color: #000;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @media (prefers-color-scheme: dark) {
            .status { color: #fff; }
            .loader {
                border-color: #bbb;
                border-top-color: #fff;
            }
            body { background-color: #2A2A2C; }
        }
    </style>
</head>
<body>
    <div class="status">
        <p>检查您的连接是否安全</p>
        <div class="loader"></div>
        <p id="progress" style="font-size: medium;">初始化...</p>
        <p style="display:none;" id="continue">继续...</p>
    </div>
    <form method="GET" id="form">
        <input type="hidden" name="_challenge" value="">
    </form>
    <script>
        const encoder = new TextEncoder();
        const statusText = document.getElementById('progress');

        function updateStatus(message) {
            statusText.textContent = message;
        }

        async function sha1(str) {
            const hash = await crypto.subtle.digest('SHA-1', encoder.encode(str));
            return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2, '0')).join('');
        }

        async function work(target) {
            for (let i = 0; i < Number.MAX_SAFE_INTEGER; i++) {
                const hash = await sha1(i.toString());
                if (hash.endsWith(target)) {
                    return i;
                }
                if (i % 10000 === 0) { // 更新进度
                    updateStatus('检查中... ' + ((i / Number.MAX_SAFE_INTEGER) * 100).toFixed(2) + '%');
                }
            }
        }

        work('{{$code}}').then(output => {
            const form = document.querySelector('#form');
            document.getElementById('continue').style.display = "block";
            document.querySelector('.loader').style.display = "none";
            form.querySelector('input[name="_challenge"]').value = output;
            form.submit();
        }).catch(error => {
            updateStatus('发生错误，请重试！');
            console.error('Error:', error);
        });
    </script>
</body>
</html>
