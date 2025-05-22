# Sistema de Carga de Excel a MySQL

Aplicación en vivo: [https://cargar-datos-excel.onrender.com](https://cargar-datos-excel.onrender.com)

Este sistema permite cargar datos desde archivos Excel a una base de datos MySQL. Soporta dos tipos de archivos Excel:

1. **Bienes**: Con columnas "Bienes" y "Tipo"
2. **Ubicaciones**: Con columnas "Bien" y "Ubicación"

## Requisitos

- PHP 7.4 o superior
- MySQL/MariaDB
- Composer (para instalar dependencias)
- Servidor web (Apache, Nginx, etc.)

## Instalación

1. Clone o descargue este repositorio en su servidor web

2. Instale las dependencias usando Composer:

```bash
composer install
```

3. Configure la conexión a la base de datos:

Abra el archivo `config.php` y modifique las siguientes constantes según su configuración:

```php
define('DB_HOST', 'localhost'); // Host de la base de datos
define('DB_USER', 'root');      // Usuario de la base de datos
define('DB_PASS', '');          // Contraseña de la base de datos
define('DB_NAME', 'sistema_inventario'); // Nombre de la base de datos
```

4. Asegúrese de que el directorio de carga tenga permisos de escritura

## Estructura de los archivos Excel

### Excel de Bienes

| Bienes       | Tipo        |
|--------------|-------------|
| Computador   | Serial      |
| Impresora    | Cantidad    |
| ...          | ...         |

### Excel de Ubicaciones

| Bien         | Ubicación   |
|--------------|-------------|
| Computador   | Oficina 1   |
| Impresora    | Recepción   |
| ...          | ...         |

## Uso del sistema

1. Acceda al sistema a través de su navegador web: `http://su-servidor/ruta-al-sistema/`

2. En la página principal, seleccione un archivo Excel y especifique el tipo de datos (Bienes o Ubicaciones)

3. Haga clic en "Cargar" para procesar el archivo

4. Una vez procesado, podrá ver una vista previa de los datos cargados

5. Utilice los enlaces "Ver Bienes" o "Ver Ubicaciones" para consultar todos los registros almacenados

## Características

- Carga de archivos Excel (.xlsx, .xls)
- Validación de estructura de archivos
- Inserción masiva de datos en la base de datos
- Vista previa de datos cargados
- Consulta de registros almacenados

## Estructura de la base de datos

### Tabla: bienes

- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- bien (VARCHAR)
- tipo (VARCHAR)
- fecha_registro (TIMESTAMP)

### Tabla: ubicaciones

- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- bien (VARCHAR)
- ubicacion (VARCHAR)
- fecha_registro (TIMESTAMP)

## Resolución de problemas

Si experimenta algún problema durante la instalación o uso del sistema, verifique lo siguiente:

1. La extensión PHP mysqli está habilitada
2. Composer está instalado correctamente
3. Los permisos de escritura son correctos
4. La configuración de la base de datos es correcta

## Notas adicionales

- El sistema crea automáticamente la base de datos y las tablas necesarias si no existen
- Solo se procesan las filas que contienen datos en todas las columnas requeridas
- Se muestran hasta 5 registros en la vista previa después de la carga
