document.addEventListener('DOMContentLoaded', function () {
  document
    .querySelectorAll('input[name="_method"][type="hidden"][value="DELETE"]')
    .forEach(deleter => {
      const deleteForm = deleter.closest('form')
      if (deleteForm) {
        deleteForm.onsubmit = event => {
          let confirmText = event.target.dataset.confirmationText ? event.target.dataset.confirmationText : 'Are you sure you want to delete this item?'

          if (!confirm(confirmText)) {
            event.preventDefault();
          }
        }
      }
    })
})
