# Guía de Presentación - Entrega 2

## Estructura de la Presentación (12-15 min)

### 1. Introducción (1 min)
- Presentación del equipo y del proyecto
- Resumen de lo entregado

### 2. Demo de Historias de Usuario (4 min)
- HU-1: Gestión de Pedidos - mostrar crear, consultar, cambiar estado
- HU-2: Gestión de Clientes - mostrar CRUD completo

### 3. Pruebas Unitarias (3 min)
- Mostrar la ejecución de PHPUnit
- Explicar 3 pruebas por entidad
- Relación con criterios de aceptación

### 4. Manejo de Ramas (3 min)
- Mostrar el árbol de ramas (git log --graph)
- Explicar la convención de commits
- Mostrar contribuciones de cada miembro en GitHub

### 5. Dificultades y Soluciones (2 min)

**Con el Framework (Laravel):**
- Dificultad: Configuración inicial y migraciones
- Solución: Uso de artisan make:migration y documentación oficial
- Dificultad: Relaciones Eloquent (N:M con tablas pivote)
- Solución: Métodos belongsToMany() con nombre de tabla personalizado

**Con Ramas (Git):**
- Dificultad: Conflictos al fusionar ramas feature con develop
- Solución: Commits frecuentes y comunicación en equipo
- Dificultad: Convención de commits inconsistente al inicio
- Solución: Estandarización con formato "mensaje #HU-N"

**Con GitHub:**
- Dificultad: Push inicial y autenticación
- Solución: Uso de token personal access
- Dificultad: Sincronización entre miembros
- Solución: Pull frecuente desde develop antes de empezar a trabajar

### 6. Cierre (1 min)
- Conclusiones
- Preguntas