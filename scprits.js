document.addEventListener("DOMContentLoaded", function () {
    // Aperçu dans le formulaire d'upload
    const pdfInput = document.getElementById("pdf");
    const pdfPreview = document.getElementById("pdfPreview");
  
    if (pdfInput && pdfPreview) {
      pdfInput.addEventListener("change", function () {
        const file = pdfInput.files[0];
        if (file && file.type === "application/pdf") {
          pdfPreview.src = URL.createObjectURL(file);
          pdfPreview.style.display = "block";
        } else {
          pdfPreview.style.display = "none";
          pdfPreview.src = "";
          alert("Veuillez sélectionner un fichier PDF valide.");
        }
      });
    }
  
    // Gestion du modal de prévisualisation
    const enlargeButtons = document.querySelectorAll(".enlarge-btn");
    const modal = document.getElementById("previewModal");
    const modalContent = document.getElementById("modalContent");
    const modalClose = document.getElementById("modalClose");
  
    enlargeButtons.forEach(button => {
      button.addEventListener("click", () => {
        const pdfSrc = button.getAttribute("data-pdf");
        if (pdfSrc) {
          modalContent.src = pdfSrc;
          modal.style.display = "block";
        }
      });
    });
  
    if (modalClose) {
      modalClose.addEventListener("click", () => {
        modal.style.display = "none";
        modalContent.src = "";
      });
    }
  
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
        modalContent.src = "";
      }
    });
  });
  