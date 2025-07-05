console.log('jodit_setup.js is running');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded. Initializing Jodit editor...');

    if (typeof Jodit === 'undefined') {
        console.error('Jodit library is not loaded.');
        return;
    }

    const editor = new Jodit('#content', {
        uploader: {
            url: '/../endpoints/media_upload_epind',
        },
        height: 500,
    });

    console.log('Jodit editor initialized successfully.');
});