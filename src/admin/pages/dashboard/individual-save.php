<?php
// $new_value y $old_value están disponibles y $new_value se pasa por referencia

switch ($key) {
    case '':

        break;

    default:

        break;
}



// Verificamos si la clave está en el array de dateTransientAdmin
if (in_array($key, $dateTransientAdmin)) {

    $timezone = wp_timezone();

    // Obtener el timestamp actual según la zona horaria de WordPress
    $current_date = new DateTime('now', $timezone);
    $current_date->setTime($current_date->format('H'), $current_date->format('i'), 0);

    // Start date and time
    $start_date_input = sanitize_text_field($new_value['start_date']);
    $start_time_input = sanitize_text_field($new_value['start_time']);
    $start_date       = DateTime::createFromFormat('Y-m-d', $start_date_input, $timezone);
    if ($start_date) {
        $start_date->setTime($start_date->format('H'), $start_date->format('i'), 0);
    }
    $start_time       = DateTime::createFromFormat('H:i', $start_time_input, $timezone);
    if ($start_time) {
        $start_time->setTime($start_time->format('H'), $start_time->format('i'), 0);
    }


    $start_datetime   = $start_date_input . ' ' . $start_time_input;
    $start_dateTime   = DateTime::createFromFormat('Y-m-d H:i', $start_datetime, $timezone);
    if ($start_dateTime) {
        $start_dateTime->setTime($start_dateTime->format('H'), $start_dateTime->format('i'), 0);
        $start_dateTime->setTimezone($timezone);
        $new_value['start'] = $start_dateTime->getTimestamp();
    }


    // End date and time
    $end_date_input = sanitize_text_field($new_value['end_date']);
    $end_time_input = sanitize_text_field($new_value['end_time']);
    $end_date       = DateTime::createFromFormat('Y-m-d', $end_date_input, $timezone);
    if ($end_date) {
        $end_date->setTime($end_date->format('H'), $end_date->format('i'), 0);
    }
    $end_time       = DateTime::createFromFormat('H:i', $end_time_input, $timezone);
    if ($end_time) {
        $end_time->setTime($end_time->format('H'), $end_time->format('i'), 0);
    }

    $end_datetime = $end_date_input . ' ' . $end_time_input;
    $end_dateTime = DateTime::createFromFormat('Y-m-d H:i', $end_datetime, $timezone);
    if ($end_dateTime) {
        $end_dateTime->setTime($end_dateTime->format('H'), $end_dateTime->format('i'), 0);
        $end_dateTime->setTimezone($timezone);
        $new_value['end'] = $end_dateTime->getTimestamp();
    }


    // Verificar si las fechas son válidas
    if ($start_dateTime && $end_dateTime) {

        // Verificar si el checkbox está marcado
        $check = isset($new_value['check']) ? absint($new_value['check']) : 0;

        if ($check == 1 && $start_dateTime->getTimestamp() !== $end_dateTime->getTimestamp() && $current_date->getTimestamp() <= $end_dateTime->getTimestamp()) {

            // Preparar los nuevos valores para guardar
            $new_value = [
                'check'      => 0,
                'start'      => $new_value['start'],
                'end'        => $new_value['end'],
                'start_date' => $start_date->getTimestamp(),
                'start_time' => $start_time->getTimestamp(),
                'end_date'   => $end_date->getTimestamp(),
                'end_time'   => $end_time->getTimestamp(),
            ];

            // Contenido del transient
            $content = [
                'date'    => $new_value,
                'content' => '',
            ];

            // Guardar el transient
            set_transient($key, $content);
        } else {
            // Si no se cumple la condición
            if (!get_transient($key)) {
                $new_value = $default_options[$key];
            } else {
                $transient = get_transient($key);
                $new_value = [
                    'check'      => absint($transient['date']['check']),
                    'start'      => sanitize_text_field($transient['date']['start']),
                    'end'        => sanitize_text_field($transient['date']['end']),
                    'start_date' => sanitize_text_field($transient['date']['start_date']),
                    'start_time' => sanitize_text_field($transient['date']['start_time']),
                    'end_date'   => sanitize_text_field($transient['date']['end_date']),
                    'end_time'   => sanitize_text_field($transient['date']['end_time']),
                ];
            }
        }
    } else {
        // Si las fechas no son válidas
        $new_value = $default_options[$key];
    }
}


// Verificamos si la clave está en el array de compareTimeField
if (in_array($key, $compareTimeField)) {

    $timezone = wp_timezone();

    // Obtener el timestamp actual según la zona horaria de WordPress
    $current_date = new DateTime('now', $timezone);
    $current_date->setTime($current_date->format('H'), $current_date->format('i'), 0);

    // Start date and time
    $start_date_input = sanitize_text_field($new_value['start_date']);
    $start_time_input = sanitize_text_field($new_value['start_time']);
    $start_date       = DateTime::createFromFormat('Y-m-d', $start_date_input, $timezone);
    if ($start_date) {
        $start_date->setTime($start_date->format('H'), $start_date->format('i'), 0);
    }
    $start_time       = DateTime::createFromFormat('H:i', $start_time_input, $timezone);
    if ($start_time) {
        $start_time->setTime($start_time->format('H'), $start_time->format('i'), 0);
    }


    $start_datetime   = $start_date_input . ' ' . $start_time_input;
    $start_dateTime   = DateTime::createFromFormat('Y-m-d H:i', $start_datetime, $timezone);
    if ($start_dateTime) {
        $start_dateTime->setTime($start_dateTime->format('H'), $start_dateTime->format('i'), 0);
        $start_dateTime->setTimezone($timezone);
        $new_value['start'] = $start_dateTime->getTimestamp();
    }


    // End date and time
    $end_date_input = sanitize_text_field($new_value['end_date']);
    $end_time_input = sanitize_text_field($new_value['end_time']);
    $end_date       = DateTime::createFromFormat('Y-m-d', $end_date_input, $timezone);
    if ($end_date) {
        $end_date->setTime($end_date->format('H'), $end_date->format('i'), 0);
    }
    $end_time       = DateTime::createFromFormat('H:i', $end_time_input, $timezone);
    if ($end_time) {
        $end_time->setTime($end_time->format('H'), $end_time->format('i'), 0);
    }

    $end_datetime = $end_date_input . ' ' . $end_time_input;
    $end_dateTime = DateTime::createFromFormat('Y-m-d H:i', $end_datetime, $timezone);
    if ($end_dateTime) {
        $end_dateTime->setTime($end_dateTime->format('H'), $end_dateTime->format('i'), 0);
        $end_dateTime->setTimezone($timezone);
        $new_value['end'] = $end_dateTime->getTimestamp();
    }



    // Verificar si las fechas son válidas
    if ($start_dateTime && $end_dateTime) {


        if ($start_dateTime->getTimestamp() !== $end_dateTime->getTimestamp() && $current_date->getTimestamp() <= $end_dateTime->getTimestamp()) {

            // Preparar los nuevos valores para guardar
            $new_value = [
                'start'      => $new_value['start'],
                'end'        => $new_value['end'],
                'start_date' => $start_date->getTimestamp(),
                'start_time' => $start_time->getTimestamp(),
                'end_date'   => $end_date->getTimestamp(),
                'end_time'   => $end_time->getTimestamp(),
            ];
        } else {
            $new_value = $old_value;
        }
    } else {
        // Si las fechas no son válidas
        $new_value = $default_options[$key];
    }
}
