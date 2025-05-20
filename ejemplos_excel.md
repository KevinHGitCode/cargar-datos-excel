# Ejemplos de Archivos Excel para Cargar

A continuación se muestran ejemplos de cómo deben estructurarse los archivos Excel para su carga en el sistema.

## Ejemplo 1: Excel de Bienes

Este archivo debe contener las columnas "Bienes" y "Tipo".

| Bienes       | Tipo        |
|--------------|-------------|
| Computador   | Serial      |
| Monitor      | Serial      |
| Teclado      | Cantidad    |
| Mouse        | Cantidad    |
| Impresora    | Serial      |
| Escritorio   | Cantidad    |
| Silla        | Cantidad    |
| Teléfono     | Serial      |
| Archivador   | Cantidad    |
| Tablero      | Cantidad    |

## Ejemplo 2: Excel de Ubicaciones

Este archivo debe contener las columnas "Bien" y "Ubicación".

| Bien         | Ubicación        |
|--------------|------------------|
| Computador   | Oficina 101      |
| Monitor      | Oficina 101      |
| Teclado      | Oficina 101      |
| Mouse        | Oficina 101      |
| Impresora    | Sala de reuniones|
| Escritorio   | Oficina 102      |
| Silla        | Oficina 102      |
| Teléfono     | Recepción        |
| Archivador   | Archivo general  |
| Tablero      | Sala de juntas   |

## Notas importantes

1. **Encabezados**: Los nombres de las columnas deben escribirse exactamente como se muestra arriba, respetando mayúsculas y tildes.

2. **Formato del archivo**: El sistema acepta archivos en formato Excel (.xlsx o .xls).

3. **Datos vacíos**: Las filas con datos vacíos en cualquiera de las columnas requeridas serán ignoradas durante la carga.

4. **Proceso de validación**: El sistema valida que el archivo tenga la estructura correcta según el tipo seleccionado.

5. **Creación de archivos**: Puede crear estos archivos usando Microsoft Excel, LibreOffice Calc u otra aplicación compatible con el formato Excel.
