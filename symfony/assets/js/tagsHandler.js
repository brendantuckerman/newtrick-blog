document.addEventListener('DOMContentLoaded', function() {
    console.log('Handler firing');
    var tagInput = document.getElementById('tag-input');
    var addTagButton = document.getElementById('add-tag');
    var tagsList = document.getElementById('tags-list');
    var tagIndex = tagsList.children.length;

    function addTag(tagValue) {
        var tagSpan = document.createElement('span');
        tagSpan.className = 'tag';
        tagSpan.innerHTML = tagValue +
            '<button type="button" class="remove-tag">&times;</button>' +
            '<input type="hidden" name="post_form[tags][' + tagIndex + ']" value="' + tagValue + '">';
        tagsList.appendChild(tagSpan);
        tagInput.value = '';
        tagIndex++;
    }

    addTagButton.addEventListener('click', function() {
        var tagValue = tagInput.value.trim();
        if (tagValue) {
            addTag(tagValue);
        }
    });

    tagInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var tagValue = this.value.trim();
            if (tagValue) {
                addTag(tagValue);
            }
        }
    });

    tagsList.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-tag')) {
            event.target.closest('.tag').remove();
        }
    });
});