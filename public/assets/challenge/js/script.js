const statusText = document.getElementById('progress');

function updateStatus(message) {
    statusText.textContent = message;
}

// script.js
document.addEventListener("DOMContentLoaded", function () {
    const codeHolder = document.getElementById('codeHolder');
    const code = codeHolder.getAttribute('data-code');

    const worker = new Worker('/assets/challenge/js/hashWorker.js');

    worker.onmessage = function (e) {
        if (e.data.found) {
            const form = document.querySelector('#form');
            document.getElementById('continue').style.display = "block";
            document.querySelector('.loader').style.display = "none";
            form.querySelector('input[name="_challenge"]').value = e.data.value;
            form.submit();
        } else if (e.data.progress !== undefined) {
            updateStatus('检查中... ' + (e.data.progress * 100).toFixed(2) + '%');
        }
    };

    worker.onerror = function (error) {
        updateStatus('发生错误，请重试！');
        console.error('Error:', error);
    };

    worker.postMessage({code: code});
});
