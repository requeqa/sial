<?php
if(!empty($_GET["page"]))
    switch ($_GET["page"]) {
        case 'producto':
            echo '<h1 class="page-header">Maestro de Producto</h1>';
            require_once 'pages/producto.php';
            break;
        case 'sesion':
            echo '<h1 class="page-header">Iniciar como admin</h1>';
            require_once 'pages/sesion.php';
            break;
        
        case 'kardex':
            echo '<h1 class="page-header">Cardex Producto</h1>';
            require_once 'pages/kardex.php';
            break;
        
        case 'ingreso':
            echo '<h1 class="page-header">Ingreso</h1>';
            require_once 'pages/ingreso.php';
            break;        
            
        case 'salida':
            echo '<h1 class="page-header">Salida</h1>';
            require_once 'pages/salida.php';
            break;
        
        case 'movimientos':
            require_once 'pages/movimientos.php';
            break;
            
        case 'venta':
            echo '<h1 class="page-header">Venta</h1>';
                require_once 'pages/venta.php';
                break;
             
        case 'medida':
            echo '<h1 class="page-header">Medida</h1>';
            require_once 'pages/medida.php';
            break;
             
        case 'marca':
            echo '<h1 class="page-header">Marca</h1>';
            require_once 'pages/marca.php';
            break;
                    
        default:
            echo '<h1 class="page-header">TEST</h1>';
           // require_once 'pages/DEMO.php';
            break;
    }

