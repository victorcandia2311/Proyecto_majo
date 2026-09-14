<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class ReciboPDF
{
    public static function generar($venta, $detalles)
    {
        $options = new Options();

        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = '
        <!DOCTYPE html>
        <html lang="es">

        <head>

            <meta charset="UTF-8">

            <style>

                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    margin: 35px;
                }

                .titulo {
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                }

                .subtitulo {
                    text-align: center;
                    font-size: 14px;
                    margin-bottom: 25px;
                }

                .datos {
                    margin-bottom: 20px;
                }

                .datos p {
                    margin: 5px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 15px;
                }

                th {
                    background-color: #eeeeee;
                }

                th, td {
                    border: 1px solid #999999;
                    padding: 8px;
                }

                .centro {
                    text-align: center;
                }

                .derecha {
                    text-align: right;
                }

                .total {
                    text-align: right;
                    font-size: 16px;
                    font-weight: bold;
                    margin-top: 20px;
                }

                .footer {
                    text-align: center;
                    margin-top: 35px;
                    font-size: 11px;
                }

            </style>

        </head>

        <body>

            <div class="titulo">
                STRONGFIT
            </div>

            <div class="subtitulo">
                RECIBO DE VENTA
            </div>

            <div class="datos">

                <p>
                    <strong>N.º de venta:</strong>
                    ' . htmlspecialchars($venta['id_venta']) . '
                </p>

                <p>
                    <strong>Fecha:</strong>
                    ' . htmlspecialchars($venta['fecha_hora']) . '
                </p>

                <p>
                    <strong>Cliente:</strong>
                    ' . htmlspecialchars(
                        $venta['cliente_nombre'] ?? 'Cliente general'
                    ) . '
                </p>

                <p>
                    <strong>Documento:</strong>
                    ' . htmlspecialchars(
                        $venta['cliente_documento'] ?? '-'
                    ) . '
                </p>

                <p>
                    <strong>Método de pago:</strong>
                    ' . htmlspecialchars($venta['metodo_pago']) . '
                </p>

            </div>

            <table>

                <thead>

                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>
        ';

        foreach ($detalles as $detalle) {

            $html .= '
                    <tr>

                        <td>
                            ' . htmlspecialchars(
                                $detalle['nombre_producto']
                            ) . '
                        </td>

                        <td class="centro">
                            ' . htmlspecialchars(
                                $detalle['cantidad']
                            ) . '
                        </td>

                        <td class="derecha">
                            S/ ' . number_format(
                                $detalle['precio_unitario'],
                                2
                            ) . '
                        </td>

                        <td class="derecha">
                            S/ ' . number_format(
                                $detalle['subtotal'],
                                2
                            ) . '
                        </td>

                    </tr>
            ';
        }

        $html .= '
                </tbody>

            </table>

            <div class="total">

                TOTAL:
                S/ ' . number_format(
                    $venta['total_venta'],
                    2
                ) . '

            </div>

            <div class="footer">

                Gracias por su compra.

            </div>

        </body>

        </html>
        ';

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream(
            'Recibo_Venta_' . $venta['id_venta'] . '.pdf',
            [
                'Attachment' => true
            ]
        );
    }
}