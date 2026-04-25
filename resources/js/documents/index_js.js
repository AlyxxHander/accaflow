$(document).ready(function () {
  // Definisi Elemen
  const $selectAll = $('#select-all');
  const $checkboxes = $('.doc-checkbox');
  const $bulkActions = $('#bulk-actions');
  const $selectedCount = $('#selected-count');
  const $bulkDeleteConfirm = $('#bulk-delete-confirm');
  const $bulkDeleteForm = $('#bulk-delete-form');
  const $singleDeleteBtns = $('.delete-single-btn');
  const $singleDeleteForm = $('#single-delete-form');

  // Fungsi Update Tampilan Bulk Actions
  function updateBulkActions() {
    const checkedCount = $('.doc-checkbox:checked').length;
    $selectedCount.text(checkedCount);

    if (checkedCount > 0) {
      $bulkActions.removeClass('hidden').addClass('flex');
    } else {
      $bulkActions.addClass('hidden').removeClass('flex');
    }
  }

  // Event Checkbox "Select All"
  $selectAll.on('change', function () {
    // Mengubah semua status checkbox berdasarkan status 'select-all'
    $checkboxes.prop('checked', this.checked);
    updateBulkActions();
  });

  // Event Checkbox Satuan
  $checkboxes.on('change', function () {
    // Update status 'select-all' jika semua checkbox satuan tercentang
    const allChecked = $checkboxes.length === $('.doc-checkbox:checked').length;
    $selectAll.prop('checked', allChecked);

    updateBulkActions();
  });

  // Event Bulk Delete (Hapus Banyak)
  $bulkDeleteConfirm.on('click', function () {
    const count = $('.doc-checkbox:checked').length;
    if (confirm(`Apakah Anda yakin ingin menghapus ${count} dokumen terpilih secara permanen?`)) {
      $bulkDeleteForm.submit();
    }
  });

  // Event Single Delete (Hapus Satu)
  $singleDeleteBtns.on('click', function () {
    const id = $(this).attr('data-id'); // Mengambil data-id
    const title = $(this).attr('data-title'); // Mengambil data-title

    if (confirm(`Apakah Anda yakin ingin menghapus dokumen "${title}" secara permanen?`)) {
      // Mengubah atribut action form sebelum submit
      $singleDeleteForm.attr('action', `/documents/${id}`);
      $singleDeleteForm.submit();
    }
  });
});