/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./**/*.php',
		'!./node_modules/**',
		'!./build/**',
	],
	theme: {
		extend: {
			colors: {
				'dark-green': '#263B33',
				cream: '#F8F5F0',
				gold: '#C3A36A',
				// Figma lifts the gold on dark grounds so it keeps its
				// contrast; `gold` stays the value used on cream.
				'gold-dark': '#D8B24C',
				'footer-green': '#1A2B24',
			},
			fontFamily: {
				heading: [ 'Athelas', 'Georgia', 'Times New Roman', 'serif' ],
				body: [ 'Kumbh Sans', 'system-ui', 'sans-serif' ],
			},
		},
	},
	plugins: [],
};
