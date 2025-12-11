module.exports = {
  content: [
    './resources/**/*.{js,vue,blade.php}',
    './modules/**/Resources/**/*.{js,vue,blade.php}',
    './public/**/*.html'
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#1f6feb'
        }
      }
    }
  },
  plugins: []
};
