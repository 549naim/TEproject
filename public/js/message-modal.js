function showSuccessModal(message = "Operation successful!") {
  let modalHtml = `
       <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body alert alert-success m-2">

                        ${message}
                      </div>
                      
            </div>
          </div>
        </div>
    `;

  // Remove previous modal if exists
  const existingModal = document.getElementById("successModal");
  if (existingModal) existingModal.remove();

  // Append new modal
  document.body.insertAdjacentHTML("beforeend", modalHtml);

  // Show the modal using Bootstrap's JS
  const modal = new bootstrap.Modal(document.getElementById("successModal"));
  modal.show();
}

function showConfirmDeleteModal(message, onConfirm) {
  let modalHtml = `
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ${message}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>
  `;

  // Remove previous modal if exists
  const existingModal = document.getElementById("confirmDeleteModal");
  if (existingModal) existingModal.remove();

  // Append new modal
  document.body.insertAdjacentHTML("beforeend", modalHtml);

  // Show the modal using Bootstrap's JS
  const modalElement = document.getElementById("confirmDeleteModal");
  const modal = new bootstrap.Modal(modalElement);
  modal.show();

  // Handle confirm button click
  const confirmBtn = document.getElementById("confirmDeleteBtn");
  confirmBtn.addEventListener("click", function () {
    if (typeof onConfirm === "function") {
      onConfirm();
    }
    modal.hide();
  });
}
