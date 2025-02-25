const editor = new Jodit('#content', {
    toolbar: [
        'bold', 'italic', 'underline', 'strikethrough',
        '|', 'fontsize', 'brush', 'paragraph',
        '|', 'align', 'ul', 'ol', 'outdent', 'indent',
        '|', 'link', 'image', 'table', 'hr',
        '|', 'undo', 'redo', 'fullsize'
    ],
    uploader: {
        url: '/php/upload-image.php',
    },
    height: 500,
});