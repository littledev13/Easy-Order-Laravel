/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./node_modules/tw-elements/dist/js/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("tw-elements/dist/plugin.cjs")],
  darkMode: "class"
}

