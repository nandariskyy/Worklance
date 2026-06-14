import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/pages/admin/dashboard.js',
                'resources/js/pages/admin/booking.js',
                'resources/js/pages/admin/pengguna.js',
                'resources/js/pages/admin/freelancer.js',
                'resources/js/pages/admin/pengajuan.js',
                'resources/js/pages/admin/kelola.js',
                'resources/js/pages/pengaturan/informasi.js',
                'resources/js/pages/pengaturan/kontak.js',
                'resources/js/pages/layanan/show.js',
                'resources/js/pages/freelancer/daftar.js',
                'resources/js/pages/freelancer/kelola.js',
                'resources/js/pages/booking/pesanan.js',
                'resources/js/pages/booking/ringkasan.js',
                'resources/js/components/navbar.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
