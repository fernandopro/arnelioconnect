
  

            <!-- Content -->
             <div class="comidas-body-content">
            <h2>Hola Comidas</h2>
            <p>
                Estoy muy contento de mostrar estas comidas desde el día 
                <strong><?php echo esc_html( wp_date( get_option('date_format') . ' ' . get_option('time_format'), $start_datetime->getTimestamp() ) ) ?></strong>
                hasta que finalize el 
                <strong><?php echo esc_html(wp_date( get_option('date_format') . ' ' . get_option('time_format'), $end_datetime->getTimestamp() )) ?></strong>.
                Muchas felicidades y hasta la Próxima!
            </p>
        </div>
        <!-- End Content -->
