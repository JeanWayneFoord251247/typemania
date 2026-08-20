document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('customizeProfileModal');
  const openBtns = [
    document.querySelector('.avatar-container'),
    document.querySelector('.btn-edit-profile'),
  ];
  const closeBtns = [
    document.getElementById('modalCloseX'),
    document.getElementById('modalCancelBtn'),
  ];

  openBtns.forEach((btn) => {
    btn?.addEventListener('click', () => {
      modal?.classList.add('show');
    });
  });

  closeBtns.forEach((btn) => {
    btn?.addEventListener('click', () => {
      modal?.classList.remove('show');
    });
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.remove('show');
    }
  });

  const usernameInput = document.getElementById('usernameInput');
  const previewCircle = document.getElementById('previewCircle');
  const previewText = document.getElementById('previewText');

  usernameInput?.addEventListener('input', (e) => {
    const val = e.target.value.trim();
    if (val.length >= 2) {
      previewText.textContent = val.substring(0, 2).toUpperCase();
    } else if (val.length === 1) {
      previewText.textContent = val.substring(0, 1).toUpperCase() + '_';
    } else {
      previewText.textContent = 'TM';
    }
  });

  document.querySelectorAll('input[name="circle_color"]').forEach((radio) => {
    radio.addEventListener('change', (e) => {
      if (previewCircle) {
        previewCircle.style.borderColor = e.target.value;
        previewCircle.style.boxShadow = `0 0 18px ${e.target.value}`;
      }
    });
  });

  document.querySelectorAll('input[name="letter_color"]').forEach((radio) => {
    radio.addEventListener('change', (e) => {
      if (previewText) {
        previewText.style.color = e.target.value;
      }
    });
  });
});
