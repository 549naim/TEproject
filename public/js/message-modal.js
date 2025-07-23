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
