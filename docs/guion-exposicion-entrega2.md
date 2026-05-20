# Guion de Exposición — Entrega 2

## Sistema de Gestión Agrícola
### Duración estimada: 12 a 15 minutos
### Integrantes: Jhennyfer (A) y Daniel (B)

---

## PRESENTACIÓN (1 minuto)

**A (Jhennyfer):** Buenos días/tardes. Somos el equipo de desarrollo y hoy vamos a presentar nuestra segunda entrega del Sistema de Gestión Agrícola. Yo soy Jhennyfer Nallely Arevalo Naranjo.

**B (Daniel):** Y yo soy Luis Daniel Obando Betancurt. En esta entrega implementamos **dos historias de usuario completas** con sus respectivas **pruebas unitarias**, usando **ramas en Git** y **GitHub** como repositorio en línea para trabajar en equipo.

**A:** Vamos a mostrarles el resultado de nuestro trabajo.

---

## PARTE 1: HISTORIAS DE USUARIO (4 minutos)

### Historia de Usuario 1: Gestión de Pedidos — Jhennyfer

**A:** Yo trabajé en la primera historia de usuario, que es la **Gestión de Pedidos**.

**¿Qué permite hacer?**
- Crear pedidos y asociarlos a un cliente
- Ver todos los pedidos registrados
- Cambiar el estado del pedido: pendiente, en proceso, enviado o entregado
- Cancelar pedidos siempre que no estén entregados
- Asociar productos y transporte al pedido

**Demostración en pantalla:**
1. Abro la página de pedidos
2. Creo un nuevo pedido seleccionando un cliente
3. Muestro cómo cambiar el estado
4. Muestro la lista completa de pedidos

**Criterios de aceptación que cumplimos:**
1. ✅ El pedido solo se crea si el cliente existe en el sistema
2. ✅ Se puede consultar la lista completa de pedidos
3. ✅ El estado se puede actualizar de pendiente a entregado
4. ✅ No se puede eliminar un pedido que ya fue entregado
5. ✅ Todos los datos obligatorios se validan antes de guardar

### Historia de Usuario 2: Gestión de Clientes — Daniel

**B:** Yo trabajé en la segunda historia de usuario, que es la **Gestión de Clientes**.

**¿Qué permite hacer?**
- Registrar nuevos clientes con nombre, contacto y canal de distribución
- Consultar todos los clientes registrados
- Editar los datos de un cliente
- Eliminar clientes, pero solo si no tienen pedidos asociados
- Ver los pedidos que tiene cada cliente

**Demostración en pantalla:**
1. Abro la página de clientes
2. Creo un cliente nuevo
3. Muestro el detalle del cliente con sus pedidos
4. Intento eliminar un cliente que tiene pedidos y muestro el error

**Criterios de aceptación que cumplimos:**
1. ✅ Se puede crear un cliente con nombre, contacto y canal de distribución
2. ✅ Se puede ver el listado completo de clientes
3. ✅ Se pueden actualizar los datos de cualquier cliente
4. ✅ No se elimina un cliente si tiene pedidos asociados
5. ✅ El nombre del cliente es obligatorio

---

## PARTE 2: PRUEBAS UNITARIAS (3 minutos)

**A:** Las pruebas son importantes para asegurarnos de que el código funciona bien. Implementamos **33 pruebas automáticas** con **63 afirmaciones o verificaciones**.

**B:** Cada modelo que usamos en las historias de usuario tiene por lo menos 3 pruebas:

| Modelo | Pruebas | ¿Qué verifican? |
|--------|---------|-----------------|
| **Cliente** | 7 pruebas | Crear, listar, actualizar, proteger al eliminar, validar campos, relación con pedidos, datos de prueba |
| **Pedido** | 8 pruebas | Crear con cliente, listar, cambiar estado, validar datos, asociar productos, relación con factura |
| **Factura** | 4 pruebas | Crear factura, número único, relación con pedido, pagos asociados |
| **Producto** | 5 pruebas | Crear producto, inventario, parcela de origen, varios pedidos, devoluciones |
| **Relaciones** | 7 pruebas | Todas las conexiones entre modelos |

**A:** Vamos a mostrar cómo se ejecutan:

```bash
php vendor/bin/phpunit
```

[Mostrar en pantalla el resultado: 33 de 33 pruebas pasadas, 63 afirmaciones]

**B:** Como pueden ver, todas las pruebas pasaron correctamente. Esto nos da la seguridad de que las funcionalidades que hicimos están bien y si en el futuro alguien hace cambios, no va a romper lo que ya funciona.

---

## PARTE 3: MANEJO DE RAMAS EN GIT (2 minutos)

**A:** Para organizar nuestro trabajo, usamos **Git con la estrategia de ramas**:

```
main
  └── develop
        ├── feature/HU-1-gestion-pedidos
        └── feature/HU-2-gestion-clientes
```

**B:** Les explicamos cómo funciona:

1. **main** — Tiene la versión estable y final del proyecto
2. **develop** — Es la rama donde unimos el trabajo de los dos
3. **feature/HU-1** — Aquí trabajó Jhennyfer la Gestión de Pedidos
4. **feature/HU-2** — Aquí trabajó Daniel la Gestión de Clientes

**A:** Para tener orden, usamos la siguiente regla en los mensajes de cada confirmación: escribimos el mensaje seguido de `#HU-N` para saber a qué historia pertenece. Por ejemplo:

- `"Initial commit: Laravel project..."` — Confirmación base del proyecto
- `"HU-2: Seeder de clientes con datos de prueba #HU-2"` — Hecho por Daniel
- `"HU-2: Agregados tests de cliente #HU-2"` — Hecho por Daniel
- `"Documentación: README con info del equipo #HU-2"` — Hecho por Daniel

**B:** En GitHub se puede ver el historial completo con los nombres de cada uno:

```
6e6e33e Jhennyfer Nallely Arevalo Naranjo
4dac4dc Luis Daniel Obando Betancurt
2153918 Luis Daniel Obando Betancurt
3e0c5fd Luis Daniel Obando Betancurt
```

---

## PARTE 4: GITHUB — TRABAJO EN EQUIPO (1 minuto)

**A:** El proyecto está subido a GitHub en la siguiente dirección:

👉 **https://github.com/jhennyfernallely123-alt/agricola-app**

**B:** En GitHub se puede ver:
- Las confirmaciones de los dos integrantes del equipo
- Las ramas creadas para cada historia de usuario
- Cómo fue evolucionando el proyecto

**A:** Cada uno trabajó en su rama por separado y luego unimos todo en develop, así evitamos conflictos y problemas.

---

## PARTE 5: DIFICULTADES Y SOLUCIONES (2 minutos)

### Con Laravel y Eloquent

**A:** **Problema:** Al principio se nos dificultó configurar las migraciones con las relaciones correctas, especialmente las llaves foráneas y las tablas intermedias.

**B:** **Solución:** Usamos los métodos que ofrece Laravel como `foreignId()->constrained()->cascadeOnDelete()` que hacen más fácil crear las relaciones entre tablas.

**A:** **Problema:** Algunos modelos tenían nombres en español pero Eloquent esperaba nombres en inglés, entonces daba error al buscar las tablas.

**B:** **Solución:** Colocamos `protected $table = 'nombre_tabla'` en cada modelo para indicar el nombre correcto de la tabla en la base de datos.

### Con Git

**A:** **Problema:** Al inicio, los nombres de usuario en Git no estaban configurados correctamente, y aparecía el nombre de otra persona en las confirmaciones.

**B:** **Solución:** Configuramos bien `git config user.name` y `git config user.email`, y corregimos la confirmación usando `git commit --amend --author`.

**A:** **Problema:** Cuando hicimos el primer envío a GitHub, las confirmaciones tenían autores incorrectos.

**B:** **Solución:** Usamos `git push --force-with-lease` después de haber corregido los autores.

### Con GitHub

**A:** **Problema:** Los tokens de acceso detallados (fine-grained) no tenían permisos para crear repositorios desde programas externos.

**B:** **Solución:** Creamos el repositorio manualmente desde la página de GitHub y usamos un token de acceso clásico para autenticarnos.

---

## CIERRE (1 minuto)

**B:** En resumen, cumplimos con los 5 requisitos de la Entrega 2:

1. ✅ **Dos historias de usuario** completas y funcionando
2. ✅ **33 pruebas unitarias** (mínimo 3 por modelo)
3. ✅ **Manejo de ramas** con main, develop y ramas por funcionalidad
4. ✅ **GitHub** con confirmaciones de los dos integrantes
5. ✅ **Presentación** de las dificultades y cómo las solucionamos

**A:** Este proyecto nos sirvió para poner en práctica lo aprendido sobre Laravel, Eloquent, pruebas unitarias con PHPUnit y trabajo en equipo usando Git y GitHub.

**B:** Muchas gracias. Quedamos atentos a sus preguntas.

---

## ANEXO: POSIBLES PREGUNTAS Y RESPUESTAS

**1. ¿Por qué usaron SQLite para las pruebas?**
R: Porque Laravel ya viene configurado con SQLite en memoria para hacer pruebas, es rápido y no necesita configurar una base de datos aparte.

**2. ¿Cuánto tiempo les tomó desarrollar las dos historias de usuario?**
R: [Responder según su experiencia real]

**3. ¿Qué pasa si un cliente tiene muchos pedidos?**
R: La relación está bien modelada con una llave foránea. La carga de datos se puede optimizar según sea necesario.

**4. ¿Cómo hacen para que las pruebas siempre pasen?**
R: Cada prueba usa `RefreshDatabase`, que limpia la base de datos entre una prueba y otra, así son independientes y siempre dan el mismo resultado.

**5. ¿Por qué separaron el trabajo en dos ramas diferentes?**
R: Para que cada uno pudiera trabajar sin afectar lo que el otro estaba haciendo, siguiendo la metodología de trabajo con ramas.
