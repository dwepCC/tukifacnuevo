/**
 * Script para corregir etiquetas <tr> sin cerrar en archivos Vue
 * Busca el patrón: <tr slot="heading">...<th>...</th><tr> (debería ser </tr>)
 */

const fs = require('fs');
const path = require('path');
const glob = require('glob');

const pattern = /(<tr\s+slot="heading"[^>]*>[\s\S]*?<\/th>\s*)<tr>/g;

function fixFile(filePath) {
  try {
    let content = fs.readFileSync(filePath, 'utf8');
    const originalContent = content;
    
    // Buscar y reemplazar el patrón problemático
    content = content.replace(pattern, (match, p1) => {
      return p1 + '</tr>';
    });
    
    if (content !== originalContent) {
      fs.writeFileSync(filePath, content, 'utf8');
      console.log(`✅ Corregido: ${filePath}`);
      return true;
    }
    return false;
  } catch (error) {
    console.error(`❌ Error en ${filePath}:`, error.message);
    return false;
  }
}

// Buscar todos los archivos Vue en resources/js/views/tenant
const files = glob.sync('resources/js/views/tenant/**/*.vue', { cwd: __dirname });

let fixedCount = 0;
files.forEach(file => {
  const fullPath = path.join(__dirname, file);
  if (fixFile(fullPath)) {
    fixedCount++;
  }
});

console.log(`\n✅ Total de archivos corregidos: ${fixedCount}`);

