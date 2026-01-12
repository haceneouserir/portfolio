/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",
  content: ["./**/*.{php,html,js}", "!./**/node_modules/**/*.{html,js}"],
  theme: {
    extend: {
      screens: {
        'xs': { 'min': '400px'},
      },
      colors: {
        "capri": "#00bfff",
        "capri-light": "#33ccff",
      },
      animation: {
        "bounce-slow": "bounce 3s infinite;",
        "pulse-speed": "pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite"
      },
      width: {
        68: "17rem",
      },
      inset: {
        68: "17rem",
        80: "20rem",
      },
      margin: {
        125: "31.25rem",
      },
    },
  },
  plugins: [],
};
// This file configures Tailwind CSS for the project.
