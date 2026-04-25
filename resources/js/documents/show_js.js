$(document).ready(function () {
  const togglePreviewBtn = $('#toggle-preview');
  const closePreviewBtn = $('#close-preview');
  const previewContainer = $('#preview-container');

  if (togglePreviewBtn && previewContainer) {
    togglePreviewBtn.on('click', function () {
      if (previewContainer.hasClass('hidden')) {
        previewContainer.removeClass('hidden');
      } else {
        previewContainer.addClass('hidden');
      }
    });
  }

  if (closePreviewBtn && previewContainer) {
    closePreviewBtn.on('click', function () {
      previewContainer.addClass('hidden');
    });
  }
});