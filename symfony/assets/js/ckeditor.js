document.addEventListener("DOMContentLoaded", function() {
  ClassicEditor
      .create(document.querySelector('#post_form_content'))
      .catch(error => {
          console.error(error);
      });
});
