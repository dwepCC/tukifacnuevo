import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';
// Auto-import removido - usando Full Import de Element Plus
// import AutoImport from 'unplugin-auto-import/vite'
// import Components from 'unplugin-vue-components/vite'
// import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Plugin para interceptar importaciones de dependencias Vue 2
const vue2StubsPlugin = () => {
  const stubPath = (name) => path.resolve(__dirname, `resources/js/stubs/${name}-stub.js`);
  
  const stubs = {
    'vuex': stubPath('vuex'),
    'vue-keypress': stubPath('vue-keypress'),
    'vue-data-tables': stubPath('vue-data-tables'),
    'vue2-dropzone': stubPath('vue2-dropzone'),
    'vue-ckeditor5': stubPath('vue-ckeditor5'),
    'vue-content-loading': stubPath('vue-content-loading'),
  };

  return {
    name: 'vue2-stubs',
    enforce: 'pre', // Ejecutar antes de otros plugins
    resolveId(id, importer) {
      // Manejar importaciones exactas
      if (stubs[id]) {
        return stubs[id];
      }
      
      // Manejar subpaths de vuex
      if (id === 'vuex/dist/vuex.mjs' || id.startsWith('vuex/') || id.startsWith('vuex\\')) {
        return stubs['vuex'];
      }
      
      // Manejar subpaths de vue2-dropzone
      if (id.startsWith('vue2-dropzone/') || id.startsWith('vue2-dropzone\\')) {
        return stubs['vue2-dropzone'];
      }
      
      return null;
    },
    // Interceptar durante el escaneo de dependencias
    buildStart() {
      // Esto ayuda a que Vite reconozca los stubs durante el pre-bundling
    }
  };
};

export default defineConfig({
  server: {
    host: '127.0.0.1',
    port: 5173,
    cors: true,
    strictPort: false,
    watch: {
      // Ignorar archivos que pueden causar loops de recarga
      ignored: [
        '**/node_modules/**',
        '**/storage/**',
        '**/public/storage/**',
        '**/bootstrap/cache/**',
        '**/vendor/**',
      ],
    },
    hmr: {
      host: '127.0.0.1',
      protocol: 'http',
      port: 5173,
      clientPort: 5173,
    },
  },
  plugins: [
    vue2StubsPlugin(), // Plugin para stubs de Vue 2 (debe ir antes de otros plugins)
    // Auto-import removido - usando Full Import de Element Plus
    // AutoImport({
    //   resolvers: [ElementPlusResolver()],
    // }),
    // Components({
    //   resolvers: [ElementPlusResolver()],
    // }),
    laravel({
      input: [
        'resources/js/app-inertia.js',
        // app.js y system.js ya no se usan - todo se maneja con Inertia.js
        // 'resources/js/system.js', // REMOVED - Migrado a Inertia
        // 'resources/js/app.js', // REMOVED - Migrado a Inertia
        // 'resources/sass/style.scss',
        // 'resources/sass/auth.scss'
      ],
      refresh: true, // Habilitar refresh para desarrollo con Inertia
    }),
    vue({
      template: {
        // No reescribir URLs absolutas (/logo/...) a imports
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  define: {
    // Prevenir que xml-js intente usar módulos de Node.js en el navegador
    'process.env': {},
    'global': 'globalThis',
    'process.browser': true,
  },
  resolve: {
    alias: [
      
      // Alias específicos primero (para subpaths)
      {
        find: 'vuex/dist/vuex.mjs',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vuex-stub.js'),
      },
      {
        find: 'vue2-dropzone/dist/vue2Dropzone.min.css',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue2-dropzone-stub.js'),
      },
      // Alias genéricos después
      {
        find: 'vuex',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vuex-stub.js'),
      },
      {
        find: 'vue-keypress',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue-keypress-stub.js'),
      },
      {
        find: 'vue-data-tables',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue-data-tables-stub.js'),
      },
      {
        find: 'vue2-dropzone',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue2-dropzone-stub.js'),
      },
      {
        find: 'vue-ckeditor5',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue-ckeditor5-stub.js'),
      },
      {
        find: 'vue-content-loading',
        replacement: path.resolve(__dirname, 'resources/js/stubs/vue-content-loading-stub.js'),
      },
      // Otros alias
      {
        find: '@components',
        replacement: path.resolve(__dirname, 'resources/js/components'),
      },
      {
        find: '@Layouts',
        replacement: path.resolve(__dirname, 'resources/js/Layouts'),
      },
      {
        find: '@views',
        replacement: path.resolve(__dirname, 'resources/js/views/tenant'),
      },
      {
        find: '@helpers',
        replacement: path.resolve(__dirname, 'resources/js/helpers'),
      },
      {
        find: '@mixins',
        replacement: path.resolve(__dirname, 'resources/js/mixins'),
      },
      {
        find: '@composables',
        replacement: path.resolve(__dirname, 'resources/js/composables'),
      },
      {
        find: '@stores',
        replacement: path.resolve(__dirname, 'resources/js/stores'),
      },
      {
        find: '@viewsModuleSale',
        replacement: path.resolve(__dirname, 'modules/Sale/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleFinance',
        replacement: path.resolve(__dirname, 'modules/Finance/Resources/assets/js/views'),
      },
      {
        find: '@viewsModulePurchase',
        replacement: path.resolve(__dirname, 'modules/Purchase/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleExpense',
        replacement: path.resolve(__dirname, 'modules/Expense/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleOrder',
        replacement: path.resolve(__dirname, 'modules/Order/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleAccount',
        replacement: path.resolve(__dirname, 'modules/Account/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleItem',
        replacement: path.resolve(__dirname, 'modules/Item/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleHotel',
        replacement: path.resolve(__dirname, 'modules/Hotel/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleDocumentary',
        replacement: path.resolve(__dirname, 'modules/DocumentaryProcedure/Resources/assets/js/views'),
      },
      {
        find: '@viewsModulePayment',
        replacement: path.resolve(__dirname, 'modules/Payment/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleMercadoPago',
        replacement: path.resolve(__dirname, 'modules/MercadoPago/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleSuscription',
        replacement: path.resolve(__dirname, 'modules/Suscription/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleMobileApp',
        replacement: path.resolve(__dirname, 'modules/MobileApp/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleLevelAccess',
        replacement: path.resolve(__dirname, 'modules/LevelAccess/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleReport',
        replacement: path.resolve(__dirname, 'modules/Report/Resources/assets/js/views'),
      },
      {
        find: '@componentsModuleReport',
        replacement: path.resolve(__dirname, 'modules/Report/Resources/assets/js/components'),
      },
      {
        find: '@viewsModuleInventory',
        replacement: path.resolve(__dirname, 'modules/Inventory/Resources/assets/js'),
      },
      {
        find: '@viewsModuleMultiUser',
        replacement: path.resolve(__dirname, 'modules/MultiUser/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleQrChatBuho',
        replacement: path.resolve(__dirname, 'modules/QrChatBuho/Resources/assets/js/views'),
      },
      {
        find: '@viewsModuleQrApi',
        replacement: path.resolve(__dirname, 'modules/QrApi/Resources/assets/js/views'),
      },
      {
        find: 'vue',
        replacement: path.resolve(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js'),
      },
      // Alias para element-plus - resolver problema de entrada
      {
        find: /^element-plus$/,
        replacement: path.resolve(__dirname, 'node_modules/element-plus/lib/index.js'),
      },
    ],
  },

  optimizeDeps: {
    esbuildOptions: {
      define: {
        global: 'globalThis',
      },
    },
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          'vendor': ['vue', 'pinia'],
          'charts': ['chart.js', 'vue-chartjs'],
        }
      },
      external: (id) => {
        // Externalizar módulos de Node.js que no deben estar en el bundle del navegador
        if (id === 'stream' || id.startsWith('stream/')) {
          return true;
        }
        return false;
      }
    }
  }
});
