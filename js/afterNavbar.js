let warnTimer;
let logoutTimer;
let countdownInterval;
let timeLeft = 10;

const modal = document.getElementById('idleModal');
const countdownEl = document.getElementById('idleCountdown');
const stayBtn = document.getElementById('stayLoggedInBtn');

function showWarning() {
  modal.classList.remove('d-none');
  timeLeft = 10;
  countdownEl.textContent = timeLeft;

  countdownInterval = setInterval(() => {
    timeLeft--;
    countdownEl.textContent = timeLeft;
    if (timeLeft <= 0) {
      clearInterval(countdownInterval);
    }
  }, 1000);

  logoutTimer = setTimeout(() => {
    window.location.href = '../pages/login.php?timeout=1';
  }, 10000);
}

function resetTimers() {
  clearTimeout(warnTimer);
  clearTimeout(logoutTimer);
  clearInterval(countdownInterval);

  if (modal) modal.classList.add('d-none');

  warnTimer = setTimeout(showWarning, 20000);
}

['mousemove', 'keydown', 'click', 'scroll'].forEach((evt) => {
  window.addEventListener(evt, resetTimers);
});

if (stayBtn) {
  stayBtn.addEventListener('click', resetTimers);
}

resetTimers();
