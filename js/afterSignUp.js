document.addEventListener('DOMContentLoaded', () => {
    const tipElement = document.getElementById('quick-tip-display');
    if (!tipElement) return;

    let tips = [];
    try {
        tips = JSON.parse(tipElement.getAttribute('data-tips') || '[]');
    } catch (e) {
        console.error('Error parsing quick tips data:', e);
        return;
    }

    if (!tips.length) return;

    let currentTipIndex = 0;

    function cycleTip() {
        tipElement.classList.add('fade-out');
        setTimeout(() => {
            currentTipIndex = (currentTipIndex + 1) % tips.length;
            tipElement.textContent = tips[currentTipIndex];
            tipElement.classList.remove('fade-out');
        }, 500);
    }

    setInterval(cycleTip, 5000);
});