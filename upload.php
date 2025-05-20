<?php
// Incluir autoloader de Composer y configuración
require 'vendor/autoload.php';
require 'config.php';

// Establecer cabeceras para respuesta JSON
header('Content-Type: application/json');

// Array de respuesta
$response = [
    'success' => false,
    'message' => '',
    'preview' => []
];

// Verificar si se ha enviado un archivo
if (!isset($_FILES['excelFile']) || $_FILES['excelFile']['error'] !== UPLOAD_ERR_OK) {
    $response['message'] = 'No se ha recibido un archivo válido.';
    echo json_encode($response);
    exit;
}

// Verificar tipo de Excel seleccionado
if (!isset($_POST['excelType']) || empty($_POST['excelType'])) {
    $response['message'] = 'Debe seleccionar un tipo de Excel.';
    echo json_encode($response);
    exit;
}

// Obtener extensión del archivo
$fileExt = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);
if (!in_array($fileExt, ['xlsx', 'xls'])) {
    $response['message'] = 'El archivo debe ser Excel (.xlsx o .xls).';
    echo json_encode($response);
    exit;
}

// Tipo de Excel
$excelType = $_POST['excelType'];

// Cargar la biblioteca PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // Conexión a la base de datos
    $conn = connectDB();
    
    // Cargar el archivo Excel
    $inputFileName = $_FILES['excelFile']['tmp_name'];
    $spreadsheet = IOFactory::load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();
    
    // Verificar que haya datos
    if (count($data) <= 1) {
        $response['message'] = 'El archivo Excel no contiene datos suficientes.';
        echo json_encode($response);
        exit;
    }
    
    // Obtener cabeceras
    $headers = array_shift($data);
    
    // Validar estructura según el tipo
    if ($excelType === 'bienes') {
        if (count($headers) < 2 || !in_array('Bienes', $headers) || !in_array('Tipo', $headers)) {
            $response['message'] = 'El archivo debe contener las columnas "Bienes" y "Tipo".';
            echo json_encode($response);
            exit;
        }
        
        // Índices de columnas
        $bienIndex = array_search('Bienes', $headers);
        $tipoIndex = array_search('Tipo', $headers);
        
        // Preparar consulta
        $stmt = $conn->prepare("INSERT INTO bienes (bien, tipo) VALUES (?, ?)");
        
        // Contador de registros insertados
        $insertedCount = 0;
        $previewData = [];
        
        // Procesar cada fila
        foreach ($data as $row) {
            // Verificar que la fila tenga datos
            if (empty($row[$bienIndex]) || empty($row[$tipoIndex])) {
                continue;
            }
            
            // Insertar en la base de datos
            $stmt->bind_param("ss", $row[$bienIndex], $row[$tipoIndex]);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $insertedCount++;
                
                // Añadir a la vista previa (máximo 5 registros)
                if (count($previewData) < 5) {
                    $previewData[] = [
                        'Bien' => $row[$bienIndex],
                        'Tipo' => $row[$tipoIndex]
                    ];
                }
            }
        }
        
        $stmt->close();
        
        if ($insertedCount > 0) {
            $response['success'] = true;
            $response['message'] = "Se han insertado $insertedCount registros correctamente.";
            $response['preview'] = $previewData;
        } else {
            $response['message'] = 'No se ha podido insertar ningún registro.';
        }
        
    } elseif ($excelType === 'ubicaciones') {
        // Validar estructura para ubicaciones
        if (count($headers) < 2 || !in_array('Bien', $headers) || !in_array('Ubicación', $headers)) {
            $response['message'] = 'El archivo debe contener las columnas "Bien" y "Ubicación".';
            echo json_encode($response);
            exit;
        }
        
        // Índices de columnas
        $bienIndex = array_search('Bien', $headers);
        $ubicacionIndex = array_search('Ubicación', $headers);
        
        // Preparar consulta
        $stmt = $conn->prepare("INSERT INTO ubicaciones (bien, ubicacion) VALUES (?, ?)");
        
        // Contador de registros insertados
        $insertedCount = 0;
        $previewData = [];
        
        // Procesar cada fila
        foreach ($data as $row) {
            // Verificar que la fila tenga datos
            if (empty($row[$bienIndex]) || empty($row[$ubicacionIndex])) {
                continue;
            }
            
            // Insertar en la base de datos
            $stmt->bind_param("ss", $row[$bienIndex], $row[$ubicacionIndex]);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $insertedCount++;
                
                // Añadir a la vista previa (máximo 5 registros)
                if (count($previewData) < 5) {
                    $previewData[] = [
                        'Bien' => $row[$bienIndex],
                        'Ubicación' => $row[$ubicacionIndex]
                    ];
                }
            }
        }
        
        $stmt->close();
        
        if ($insertedCount > 0) {
            $response['success'] = true;
            $response['message'] = "Se han insertado $insertedCount registros correctamente.";
            $response['preview'] = $previewData;
        } else {
            $response['message'] = 'No se ha podido insertar ningún registro.';
        }
        
    } else {
        $response['message'] = 'Tipo de Excel no reconocido.';
    }
    
    $conn->close();
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
