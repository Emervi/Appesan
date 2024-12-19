// /** @type {import('tailwindcss').Config} */
// module.exports = {
//   content: [],
//   theme: {
//     extend: {},
//   },
//   plugins: [],
// }

/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // atau 'media' atau 'class'
  theme: {
    extend: {
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        roboto: ['Roboto', 'sans-serif'],
      },
      colors: {
        lB: '#81D4FA',
        mB: '#2196F3',
        dB: '#1565C0',
        mY: '#ffb703',
        dY: '#fb8500',
        // primary: '#4CAF50', // Hijau terang
        // dark: '#2E7D32',    // Hijau gelap
        // light: '#81C784',   // Hijau lembut
        // accent: '#00E676',  // Hijau neon
        // muted: '#A5D6A7',   // Hijau abu-abu
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
