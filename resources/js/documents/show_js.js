$(document).on('DOMContentLoaded', function () {
  const togglePreviewBtn = $('#toggle-preview');
  const closePreviewBtn = $('#close-preview');
  const previewContainer = $('#preview-container');

  if (togglePreviewBtn && previewContainer) {
    togglePreviewBtn.on('click', function () {
      previewContainer.toggleClass('hidden');
    });
  }

  if (closePreviewBtn && previewContainer) {
    closePreviewBtn.on('click', function () {
      previewContainer.addClass('hidden');
    });
  }
});