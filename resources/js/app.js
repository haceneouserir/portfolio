import AOS from "aos";
import "./toast"

// Initialize AOS
AOS.init();

document.addEventListener("DOMContentLoaded", () => {
  // Theme toggles and sidebar handling
  const root = document.documentElement;
  const themeKey = "hs_theme";
  const btnDark = document.getElementById("btnDark");
  const btnLight = document.getElementById("btnLight");
  const drawerToggle = document.getElementById("drawerToggle");
  const sidebar = document.querySelector("aside");
  const drawerToggleIcon = document.querySelector('label[for="drawerToggle"]');
  // Back to top button
  const backToTop = document.getElementById("backToTop");
  const showAfter = 200;

  // Apply theme based on mode
  const applyTheme = (mode, persist = true) => {
    const isDark = mode === "dark";
    root.classList.toggle("dark", isDark);
    btnDark.classList.toggle("hidden", isDark);
    btnLight.classList.toggle("hidden", !isDark);
    if (persist) localStorage.setItem(themeKey, mode);
  };

  // Initial sync with saved preference
  const isDarkNow = root.classList.contains("dark");
  applyTheme(isDarkNow ? "dark" : "light", false);

  // Theme toggles
  btnDark?.addEventListener("click", () => applyTheme("dark"));
  btnLight?.addEventListener("click", () => applyTheme("light"));

  // Respond to system theme if no preference saved
  const mq = window.matchMedia("(prefers-color-scheme: dark)");
  mq.addEventListener("change", (event) => {
    if (!localStorage.getItem(themeKey)) {
      applyTheme(event.matches ? "dark" : "light", false);
    }
  });

  // Hide sidebar when clicking outside
  document.addEventListener("mousedown", (event) => {
    if (
      drawerToggle.checked &&
      !sidebar.contains(event.target) &&
      event.target !== drawerToggle &&
      !drawerToggleIcon.contains(event.target)
    ) {
      event.preventDefault();
      drawerToggle.checked = false;
    }
  });

  // Prevent scroll-to-top when clicking drawer label
  drawerToggleIcon?.addEventListener("click", (event) => {
    event.preventDefault();
    drawerToggle.checked = !drawerToggle.checked;
  });

  // Highlight current section on scroll
  const sections = document.querySelectorAll("section[id]");
  const links = document.querySelectorAll(".sidebar-link");

  const onScroll = () => {
    const scrollTop = window.scrollY;
    let currentId = null;

    sections.forEach((sec) => {
      const id = sec.id;
      const top = sec.offsetTop;
      const bottom = top + sec.offsetHeight;

      if (
        (id !== "contactMe" && scrollTop >= top && scrollTop < bottom) ||
        (id === "contactMe" &&
          scrollTop + window.innerHeight >= bottom)
      ) {
        currentId = id;
      }
    });

    // Reset all links
    links.forEach((link) => {
      link.classList.remove(
        "bg-capri",
        "text-gray-800",
        "dark:text-gray-200",
        "hover:bg-capri-light"
      );
      link.classList.add(
        "text-gray-700",
        "hover:bg-gray-100",
        "dark:text-gray-400",
        "dark:hover:bg-gray-800"
      );
    });

    // Highlight current link
    if (currentId) {
      const activeLink = document.querySelector(
        `.sidebar-link[href="#${currentId}"]`
      );
      activeLink?.classList.remove(
        "text-gray-700",
        "hover:bg-gray-100",
        "dark:text-gray-400",
        "dark:hover:bg-gray-800"
      );
      activeLink?.classList.add(
        "bg-capri",
        "text-gray-800",
        "dark:text-gray-200",
        "hover:bg-capri-light"
      );
    }

    // Show/hide back-to-top
    if (scrollTop > showAfter) {
      backToTop?.classList.remove("hidden");
      backToTop?.classList.add("opacity-100");
    } else {
      backToTop?.classList.add("hidden");
      backToTop?.classList.remove("opacity-100");
    }
  };

  window.addEventListener("scroll", onScroll);
  onScroll(); // trigger initially

  // Re-run scroll handler when clicking a sidebar link
  document.querySelectorAll(".sidebar-link").forEach((link) => {
    link.addEventListener("click", () => {
      setTimeout(onScroll, 10);
    });
  });

  // Smooth scroll back-to-top
  backToTop?.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // Contact form submit
  const contactForm = document.getElementById("contactForm");
  contactForm?.addEventListener("submit", async (event) => {
    event.preventDefault();
    const form = event.currentTarget;
    const sendMailBtn = document.getElementById("sendMail");
    sendMailBtn.disabled = true;
    sendMailBtn.textContent = "Sending...";

    const initialUrl = 'contact.php';
    const url = initialUrl.split(/[?#]/)[0];
    const formData = new FormData(form);

    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });
      const res = await response.json();

      const fields = ["name", "email", "subject", "message", 'cf-turnstile-response'];
      if (res.errors) {
        fields.forEach((f) => {
          const err = form.querySelector(`.${f}-field .validation-err`);
          if (res.errors[f]) {
            err?.classList.remove("hidden");
            err.textContent = res.errors[f];
            if (f === 'cf-turnstile-response') {
              turnstile.reset(turnstileWidgetId);
            }
          } else {
            err?.classList.add("hidden");
            err.textContent = "";
          }
        });
      } else if (res.success) {
        document.querySelectorAll(".validation-err").forEach((el) =>
          el.classList.add("hidden")
        );
        document.querySelectorAll(".error-icon").forEach((el) =>
          el.classList.add("hidden")
        );
        document.querySelectorAll(".success-icon").forEach((el) =>
          el.classList.remove("hidden")
        );
        const alertMsg = document.querySelector(".alert-msg");
        alertMsg?.classList.remove("hidden", "bg-red-400");
        alertMsg?.classList.add("bg-green-400");
        document.querySelector(".alert-msg-text").textContent = res.message;

        setTimeout(() => alertMsg?.classList.add("hidden"), 5000);
        form.reset();
        turnstile.reset(turnstileWidgetId);
      } else {
        const alertMsg = document.querySelector(".alert-msg");
        document.querySelectorAll(".validation-err").forEach((el) =>
          el.classList.add("hidden")
        );
        document.querySelectorAll(".success-icon").forEach((el) =>
          el.classList.add("hidden")
        );
        document.querySelectorAll(".error-icon").forEach((el) =>
          el.classList.remove("hidden")
        );
        alertMsg?.classList.remove("hidden", "bg-green-400");
        alertMsg?.classList.add("bg-red-400");
        document.querySelector(".alert-msg-text").textContent = res.message;
        setTimeout(() => alertMsg?.classList.add("hidden"), 5000);
      }
    } catch (error) {
      // console.error("AJAX request failed:", error);
      const alertMsg = document.querySelector(".alert-msg");
      alertMsg?.classList.remove("hidden");
      alertMsg?.classList.add("bg-red-400");
      document.querySelector(".alert-msg-text").textContent =
        "Something went wrong, please try again later!";
      setTimeout(() => alertMsg?.classList.add("hidden"), 5000);
    } finally {
      sendMailBtn.disabled = false;
      sendMailBtn.textContent = "Send Message";
    }
  });

  // Close alert
  document.querySelectorAll(".alert-msg-close").forEach((btn) => {
    btn.addEventListener("click", (event) => {
      event.preventDefault();
      document.querySelector(".alert-msg")?.classList.add("hidden");
    });
  });
});