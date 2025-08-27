import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

export default defineConfig({
  plugins: [react()],
  root: 'assets-src',
  build: {
    outDir: '../assets',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        admin: resolve(__dirname, 'assets-src/admin.ts'),
        frontend: resolve(__dirname, 'assets-src/frontend.ts'),
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name]-[hash].js',
        assetFileNames: '[name].[ext]',
      },
    },
  },
  server: {
    port: 3000,
    hmr: {
      port: 3000,
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@import "assets-src/styles/variables.scss";`,
      },
    },
  },
});
