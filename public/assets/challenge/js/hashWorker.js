self.onmessage = function (e) {
    const code = e.data.code;
    work(code).then(output => {
        self.postMessage({found: true, value: output});
    }).catch(error => {
        self.postMessage({error: error.message});
    });
};

async function sha1(str) {
    const encoder = new TextEncoder();
    const hash = await crypto.subtle.digest('SHA-1', encoder.encode(str));
    return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2, '0')).join('');
}

async function work(target) {
    for (let i = 0; i < Number.MAX_SAFE_INTEGER; i++) {
        const hash = await sha1(i.toString());
        if (hash.endsWith(target)) {
            return i;
        }
        if (i % 10000 === 0) {
            self.postMessage({progress: i / Number.MAX_SAFE_INTEGER});
        }
    }
}
