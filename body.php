<?php
if(!empty($_GET["page"]))
    switch ($_GET["page"]) {
        case 'producto':
            echo '<h1 class="page-header">Producto</h1>';
            require_once 'pages/producto_form.php';
            break;
        
        case 'productos':
            echo '<h1 class="page-header">Productos</h1>';
            require_once 'pages/producto_table.php';
            break;
        
        case 'ingreso':
            echo '<h1 class="page-header">Ingreso</h1>';
            require_once 'pages/movimiento.php';
            break;        
            
        case 'salida':
            echo '<h1 class="page-header">Salida</h1>';
            require_once 'pages/movimiento.php';
            break;
        
        case 'movimientos':
            # code...
            break;
            
        case 'venta':
            echo '<h1 class="page-header">Venta</h1>';
                require_once 'pages/carrito.php';
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
            # code...
            break;
    }

