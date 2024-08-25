<?php

function formatRupiah($nominal, $prefix = 'Rp')
{
    // Pastikan nilai nominal adalah integer
    if (!is_int($nominal)) {
        $nominal = (int) $nominal;
    }

    return $prefix .number_format($nominal, 0, ',', '.');
}
