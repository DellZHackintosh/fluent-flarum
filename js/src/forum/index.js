import app from 'flarum/forum/app';

function withID(more = "") {
    return `dalez-fluent-flarum${more}`;
}

function storageAvailable() {
    var storage;
    try {
        storage = window["localStorage"];
        var x = "__storage_test__";
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    } catch (e) {
        return (
            e instanceof DOMException &&
            // everything except Firefox
            (e.code === 22 ||
                // Firefox
                e.code === 1014 ||
                // test name field too, because code might not be present
                // everything except Firefox
                e.name === "QuotaExceededError" ||
                // Firefox
                e.name === "NS_ERROR_DOM_QUOTA_REACHED") &&
            // acknowledge QuotaExceededError only if there's something already stored
            storage &&
            storage.length !== 0
        );
    }
}

async function getNoiseAsset() {
    return storageAvailable() && localStorage.noiseAsset && Math.random() < 0.01 ? localStorage.noiseAsset : await (async () => {
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = 256;
        const context = canvas.getContext('2d');
        const imageData = new ImageData(256, 256);
        const data = imageData.data;

        for (let i = 0; i < data.length; i += 4) {
            let color = Math.floor(Math.random() * 255);
            data[i] = color;
            data[i + 1] = color;
            data[i + 2] = color;
            data[i + 3] = 10;
        }

        context.putImageData(imageData, 0, 0);
        return canvas.toDataURL();
    })();
}


app.initializers.add(withID(), () => {
    (async () => {
        document.documentElement.style.setProperty('--noise-asset', `url(${await getNoiseAsset()})`);
    })();
    document.body.classList.toggle('activated');
    window.addEventListener('blur', () => document.body.classList.toggle('activated'));
});