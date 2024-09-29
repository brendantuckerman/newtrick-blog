document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.ckeditor').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error('Ckeditor error', error);
            });
    });
});
