function loadSection(name) {
  fetch(`templates/${name}.html`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('main-section').innerHTML = html;
      return fetch(`modals/${name}Modal.html`);
    })
    .then(res => res.text())
    .then(modalHtml => {
      document.getElementById('modals-container').innerHTML = modalHtml;
    });
}

function logout() {
  // alert("Saindo...");
}
