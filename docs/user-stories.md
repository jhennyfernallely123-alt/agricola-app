# Historias de Usuario - Sistema de Gestión Agrícola

## HU-1: Gestión de Pedidos de Clientes

**Como** administrador de ventas
**Quiero** gestionar los pedidos de los clientes (crear, consultar, actualizar estado, cancelar)
**Para** mantener un control eficiente de las transacciones comerciales y la logística de entrega

### Criterios de Aceptación

1. **CA-1.1:** El sistema debe permitir crear un pedido asociado a un cliente existente, con fecha y estado inicial "pendiente"
2. **CA-1.2:** El sistema debe permitir consultar la lista de todos los pedidos con su información completa (cliente, fecha, estado, transporte)
3. **CA-1.3:** El sistema debe permitir actualizar el estado de un pedido (pendiente → en_proceso → enviado → entregado)
4. **CA-1.4:** El sistema debe permitir cancelar un pedido solo si su estado no es "entregado"
5. **CA-1.5:** El sistema debe validar que el cliente exista antes de asociarlo a un pedido

### Entidades Involucradas
- Pedido (principal)
- Cliente (relación N:1)
- Transporte (relación N:1, opcional)
- ProductoTerminado (relación N:M vía pedido_producto)
- Factura (relación 1:1)
- RutaEntrega (relación 1:N)

---

## HU-2: Gestión de Clientes

**Como** administrador comercial
**Quiero** gestionar el registro de clientes (crear, consultar, actualizar, eliminar)
**Para** mantener actualizada la base de datos de compradores y sus canales de distribución

### Criterios de Aceptación

1. **CA-2.1:** El sistema debe permitir crear un cliente con nombre, contacto y canal de distribución
2. **CA-2.2:** El sistema debe permitir consultar todos los clientes registrados
3. **CA-2.3:** El sistema debe permitir actualizar los datos de un cliente existente
4. **CA-2.4:** El sistema debe permitir eliminar un cliente solo si no tiene pedidos asociados
5. **CA-2.5:** El nombre del cliente es obligatorio (validación)

### Entidades Involucradas
- Cliente (principal)
- Pedido (relación 1:N)