<?php
/* 
 * Calculadora avazada
 * Solicitar al usuario la iluminación disponible en su hogar
 * @author Miguel A García Fustes
 * @date  de  de 2021
 * @version 1.0.0
 * 
 * Ofrecemos 5 tipos de iluminación para los cuales utilizaremos los siguientes consumos:
 * halógena = 60 W
 * bajo consumo = 30 W
 * Incandescente = 50 W
 * Fluorescente = 36 W
 * LED = 15 W
 */

$tab = 'iluminacion';
$tabNombre = 'Iluminación';
$espacios = array('Salón', 'Cocina', 'Baño', 'Habitación 1', 'Habitación 2','','','');

?>

<table class="table table-hover">
    <thead class="rotated-header">
        <tr>
            <th>Espazo</th>
            <th>
                <div class="rotated-header-container">
                    <div class="rotated-header-content">Halógena</div>
                </div>
            </th>
            <th>
                <div class="rotated-header-container">
                    <div class="rotated-header-content">Baixo consumo</div>
                </div>
            </th>                     
            <th>
                <div class="rotated-header-container">
                    <div class="rotated-header-content">Incandescente</div>
                </div>
            </th>                     
            <th>
                <div class="rotated-header-container">
                    <div class="rotated-header-content">Fluorescente</div>
                </div>
            </th>                     
            <th>
                <div class="rotated-header-container">
                    <div class="rotated-header-content">LED</div>
                </div>
            </th>                     
            <th>Unidades</th>
            <th colspan="2">Uso semanal</th>
            <th>Consumo</th>
        </tr>
    </thead>
    <tbody>
        <?php $numEspacio = 1; ?>
        <?php foreach ($espacios as $espacio) : ?>
            <tr id="<?php echo $numEspacio; ?>" data-tab="<?php echo $tab; ?>" data-tipo-espacio="5">
                <td>
                    <!-- Nombre del espacio -->
                    <input 
                        type="text" 
                        class="espacio" 
                        value="<?php echo $espacio; ?>" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_nombre_espacio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][nombre_espacio]" 
                        data-espacio="<?php echo $numEspacio; ?>"
                    />
                </td>
                <!-- tipos de iluminación -->
                <td>
                    <!-- Halógena -->
                    <input 
                        type="radio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][potencia]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_potencia_halogena"
                        class="radio"
                        onchange="setConsumo(this)"
                        data-espacio="<?php echo $numEspacio; ?>"
                        value="60"
                        checked="true"
                    >
                </td>
                <td>
                    <!-- Bajo consumo -->
                    <input 
                        type="radio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][potencia]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_potencia_bajo_consumo"
                        class="radio"
                        onchange="setConsumo(this)"
                        data-espacio="<?php echo $numEspacio; ?>"
                        value="30"
                    >
                </td>
                <td>
                    <!-- Incandescente -->
                    <input 
                        type="radio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][potencia]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_potencia_incandescente"
                        class="radio"
                        onchange="setConsumo(this)"
                        data-espacio="<?php echo $numEspacio; ?>"
                        value="50"
                    >
                </td>
                <td>
                    <!-- Fluorescente -->
                    <input 
                        type="radio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][potencia]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_potencia_fluorescente"
                        class="radio"
                        onchange="setConsumo(this)"
                        data-espacio="<?php echo $numEspacio; ?>"
                        value="36"
                    >
                </td>
                <td>
                    <!-- LED -->
                    <input 
                        type="radio" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][potencia]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_potencia_led"
                        class="radio"
                        onchange="setConsumo(this)"
                        data-espacio="<?php echo $numEspacio; ?>"
                        value="15"
                    >
                </td>                                           
                <td>
                    <!-- Unidades -->
                    <input 
                        type="number" 
                        class="unidades" 
                        value="0" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_unidades" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][unidades]" 
                        data-espacio="<?php echo $numEspacio; ?>" 
                        min="0" 
                        step="1" 
                        onchange="setConsumo(this)" 
                    />
                </td>
                <td>
                    <!-- Selector de horas -->
                    <input 
                        type="number" 
                        min="0" 
                        max="24" 
                        step="1"
                        class="horas"
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][horas]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_horas"
                        value="0"
                        data-espacio="<?php echo $numEspacio; ?>" 
                        onchange="setConsumo(this)" 
                    />
                    <label for="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_horas"> h.</label>
                </td>
                <td>
                    <!-- Selector de minutos -->
                    <input 
                        type="number" 
                        min="0" 
                        max="55" 
                        step="5" 
                        class="minutos" 
                        name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][min]" 
                        id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_min"
                        value="0"
                        data-espacio="<?php echo $numEspacio; ?>" 
                        onchange="setConsumo(this)" 
                    />
                    <label for="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_min"> min.</label>
                </td>
                <td>
                    <div id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_consumo" class="consumo-anual-aparato" style="display: none;">
                        <span id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_consumo_total_etiqueta"></span>
                        <span> kWh</span><br>
                        <span>anuales</span>
                    </div>
                    <input type="hidden" id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_consumo_total">
                    <input type="hidden" name="equipos[<?php echo $tab; ?>][<?php echo $numEspacio; ?>][tipo]" id="<?php echo $tab; ?>_<?php echo $numEspacio; ?>_tipo" value="5">
                </td>
            </tr>
            <?php $numEspacio++; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" class="total-columna-consumo">
                <span>Consumo total <?php echo $tabNombre; ?>:</span>
                <span class="consumo-total-valor" id="total_consumo_<?php echo $tab; ?>"></span>
                <span class="consumo-total-unidad">kWh/año.</span>
                <input type="hidden" id="<?php echo $tab; ?>_consumo_total" value="0" />
                <input type="hidden" id="<?php echo $tab; ?>_nombre" name="equipos[<?php echo $tab; ?>][nombre]" value="<?php echo $tabNombre; ?>" />
            </td>
        </tr>
    </tfoot>
</table>