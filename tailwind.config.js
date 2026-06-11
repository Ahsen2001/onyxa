export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/View/**/*.php',
        './storage/framework/views/*.php',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    brown: '#8B5E3C',
                    green: '#2E7D32',
                    cream: '#FFF8EC',
                    gold: '#D9A441',
                    dark: '#2B2B2B',
                },
            },
            fontFamily: {
                sans: ['Poppins', 'Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                soft: '0 16px 40px rgb(43 43 43 / 0.08)',
            },
        },
    },
};
