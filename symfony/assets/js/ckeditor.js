
document.addEventListener('DOMContentLoaded', (event) => {
    console.log('loaded');
    document.querySelectorAll('.ckeditor').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error('Ckeditor error', error);
            });
    });
});
