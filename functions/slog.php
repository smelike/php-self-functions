<?php

function slog($log_file, $log_data)
{

        $log_file .= '_' . date('Y-m-d');
        if (is_array($log_data) AND join("", $log_data))
        {
            $log_data = join("\t", $log_data) . "\r\n";
        } else if($log_data) {
            $log_data .= "\r\n";
        } else {
            exit(0);
        }

        return file_put_contents($log_file, $log_data, FILE_APPEND);
}
