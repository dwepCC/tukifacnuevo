#!/usr/bin/env node

/**
 * Script para verificar compatibilidad de componentes con Vue 3
 * Uso: node scripts/check-vue3-compatibility.js [ruta]
 */

const fs = require('fs')
const path = require('path')

// Colores para terminal
const colors = {
  reset: '\x1b[0m',
  red: '\x1b[31m',
  green: '\x1b[32m',
  yellow: '\x1b[33m',
  blue: '\x1b[34m',
  cyan: '\x1b[36m'
}

// Patrones Vue 2 que necesitan migración
const vue2Patterns = [
  {
    name: 'Vue.component (registro global)',
    pattern: /Vue\.component\(/g,
    severity: 'high',
    fix: 'Migrar a app.component() en app.js'
  },
  {
    name: 'this.$store (Vuex)',
    pattern: /this\.\$store/g,
    severity: 'high',
    fix: 'Migrar a Pinia: useMainStore()'
  },
  {
    name: 'Filters (removidos en Vue 3)',
    pattern: /filters\s*:/g,
    severity: 'high',
    fix: 'Convertir a computed o funciones'
  },
  {
    name: 'Vue.mixin (global)',
    pattern: /Vue\.mixin\(/g,
    severity: 'medium',
    fix: 'Migrar a provide/inject o composables'
  },
  {
    name: 'new Vue() (event bus)',
    pattern: /new\s+Vue\(/g,
    severity: 'high',
    fix: 'Usar mitt o eventBus helper'
  },
  {
    name: '$listeners (removido)',
    pattern: /\$listeners/g,
    severity: 'high',
    fix: 'Usar $attrs en Vue 3'
  },
  {
    name: '$scopedSlots (removido)',
    pattern: /\$scopedSlots/g,
    severity: 'high',
    fix: 'Usar $slots en Vue 3'
  },
  {
    name: 'beforeDestroy (renombrado)',
    pattern: /beforeDestroy\s*\(/g,
    severity: 'medium',
    fix: 'Renombrar a beforeUnmount'
  },
  {
    name: 'destroyed (renombrado)',
    pattern: /destroyed\s*\(/g,
    severity: 'medium',
    fix: 'Renombrar a unmounted'
  },
  {
    name: 'Vue.use() en componente',
    pattern: /Vue\.use\(/g,
    severity: 'low',
    fix: 'Mover a app.js'
  }
]

// Patrones de Composition API (buenos)
const vue3Patterns = [
  {
    name: 'Composition API (<script setup>)',
    pattern: /<script\s+setup>/g,
    severity: 'good'
  },
  {
    name: 'defineProps',
    pattern: /defineProps\(/g,
    severity: 'good'
  },
  {
    name: 'defineEmits',
    pattern: /defineEmits\(/g,
    severity: 'good'
  },
  {
    name: 'Pinia store',
    pattern: /useMainStore|useStore|defineStore/g,
    severity: 'good'
  },
  {
    name: 'Composables',
    pattern: /use[A-Z]\w+/g,
    severity: 'good'
  }
]

function findVueFiles(dir, fileList = []) {
  const files = fs.readdirSync(dir)
  
  files.forEach(file => {
    const filePath = path.join(dir, file)
    const stat = fs.statSync(filePath)
    
    if (stat.isDirectory()) {
      // Ignorar node_modules y otros
      if (!['node_modules', '.git', 'vendor', 'storage'].includes(file)) {
        findVueFiles(filePath, fileList)
      }
    } else if (file.endsWith('.vue') || file.endsWith('.js')) {
      fileList.push(filePath)
    }
  })
  
  return fileList
}

function checkFile(filePath) {
  const content = fs.readFileSync(filePath, 'utf8')
  const issues = []
  const goodPatterns = []
  
  // Verificar patrones Vue 2
  vue2Patterns.forEach(({ name, pattern, severity, fix }) => {
    const matches = content.match(pattern)
    if (matches) {
      issues.push({
        name,
        severity,
        fix,
        count: matches.length,
        lines: getLineNumbers(content, pattern)
      })
    }
  })
  
  // Verificar patrones Vue 3 (positivos)
  vue3Patterns.forEach(({ name, pattern, severity }) => {
    const matches = content.match(pattern)
    if (matches) {
      goodPatterns.push({
        name,
        count: matches.length
      })
    }
  })
  
  return { issues, goodPatterns }
}

function getLineNumbers(content, pattern) {
  const lines = content.split('\n')
  const lineNumbers = []
  
  lines.forEach((line, index) => {
    if (pattern.test(line)) {
      lineNumbers.push(index + 1)
    }
  })
  
  return lineNumbers.slice(0, 5) // Solo primeros 5
}

function formatSeverity(severity) {
  const colorsMap = {
    high: colors.red,
    medium: colors.yellow,
    low: colors.blue,
    good: colors.green
  }
  return `${colorsMap[severity] || colors.reset}${severity.toUpperCase()}${colors.reset}`
}

function generateReport(files, targetDir = '') {
  console.log(`\n${colors.cyan}=== Verificación de Compatibilidad Vue 3 ===${colors.reset}\n`)
  console.log(`Directorio: ${targetDir || 'Todo el proyecto'}`)
  console.log(`Archivos analizados: ${files.length}\n`)
  
  let totalIssues = 0
  let totalGood = 0
  const filesWithIssues = []
  const summary = {
    high: 0,
    medium: 0,
    low: 0,
    good: 0
  }
  
  files.forEach(file => {
    const { issues, goodPatterns } = checkFile(file)
    
    if (issues.length > 0 || goodPatterns.length > 0) {
      const relativePath = path.relative(process.cwd(), file)
      console.log(`${colors.blue}📄 ${relativePath}${colors.reset}`)
      
      if (issues.length > 0) {
        filesWithIssues.push(file)
        issues.forEach(({ name, severity, fix, count, lines }) => {
          summary[severity] = (summary[severity] || 0) + count
          totalIssues += count
          
          console.log(`  ${formatSeverity(severity)} ${name} (${count}x)`)
          if (lines && lines.length > 0) {
            console.log(`    Líneas: ${lines.join(', ')}`)
          }
          console.log(`    Fix: ${colors.yellow}${fix}${colors.reset}`)
        })
      }
      
      if (goodPatterns.length > 0) {
        goodPatterns.forEach(({ name, count }) => {
          summary.good = (summary.good || 0) + count
          totalGood += count
          console.log(`  ${colors.green}✓${colors.reset} ${name} (${count}x)`)
        })
      }
      
      console.log('')
    }
  })
  
  // Resumen
  console.log(`${colors.cyan}=== Resumen ===${colors.reset}\n`)
  console.log(`Total de problemas encontrados: ${colors.red}${totalIssues}${colors.reset}`)
  console.log(`  - ${colors.red}Alta prioridad: ${summary.high || 0}${colors.reset}`)
  console.log(`  - ${colors.yellow}Media prioridad: ${summary.medium || 0}${colors.reset}`)
  console.log(`  - ${colors.blue}Baja prioridad: ${summary.low || 0}${colors.reset}`)
  console.log(`\nTotal de patrones Vue 3 encontrados: ${colors.green}${totalGood}${colors.reset}`)
  console.log(`\nArchivos con problemas: ${colors.yellow}${filesWithIssues.length}${colors.reset}`)
  
  // Generar archivo de reporte
  const reportPath = path.join(process.cwd(), 'vue3-migration-report.json')
  const report = {
    timestamp: new Date().toISOString(),
    totalFiles: files.length,
    filesWithIssues: filesWithIssues.length,
    summary,
    details: filesWithIssues.map(file => ({
      file: path.relative(process.cwd(), file),
      issues: checkFile(file).issues
    }))
  }
  
  fs.writeFileSync(reportPath, JSON.stringify(report, null, 2))
  console.log(`\n${colors.green}✓${colors.reset} Reporte guardado en: ${reportPath}`)
  
  return report
}

// Main
const targetDir = process.argv[2] || process.cwd()
const vueFiles = findVueFiles(targetDir)

if (vueFiles.length === 0) {
  console.log(`${colors.yellow}No se encontraron archivos .vue o .js${colors.reset}`)
  process.exit(0)
}

const report = generateReport(vueFiles, targetDir)

// Exit code basado en problemas de alta prioridad
if (report.summary.high > 0) {
  process.exit(1)
}

process.exit(0)

