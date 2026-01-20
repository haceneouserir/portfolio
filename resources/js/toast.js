  const toastEl = document.querySelector('#toastNotif');
  let wasOffline = !navigator.onLine;
  let toastTimeout = null;

  const showToast = (message, bgColor, autoHide = false) => {
    toastEl.textContent = message;
    toastEl.style.backgroundColor = bgColor;
    toastEl.style.opacity = 0.9;

    // Auto hide after 3 seconds
    if (autoHide) {
      if (toastTimeout) clearTimeout(toastTimeout);
      toastTimeout = setTimeout(() => {
        toastEl.style.opacity = 0;
      }, 3000);
    }
  }

  // Initial check on page load
  window.addEventListener('load', () => {
    if (!navigator.onLine) {
      wasOffline = true;
      showToast('You are offline!', '#ed3c0d');
    }
  });

  // Listen for offline event
  window.addEventListener('offline', () => {
    wasOffline = true;
    showToast('You are offline!', '#ed3c0d');
  });

  // Listen for online event
  window.addEventListener('online', () => {
    if (wasOffline) {
      wasOffline = false;
      showToast('Back online!', '#18d26e', true);
      // Reload the page to fetch fresh content
      location.reload();
    }
  });