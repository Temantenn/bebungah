<?php

namespace App\Services;

class QrisService
{
    public function generateDynamic(string $masterString, $amount): string
    {
        // 1. Memeriksa validitas (harus punya Tag 63 di akhir)
        if (strpos($masterString, "6304") === false) {
            return $masterString;
        }

        // 2. Parse komponen QRIS
        $tags = $this->parseQris($masterString);

        // 3. Update Tag 01 dari Static (11) ke Dynamic (12)
        $tags["01"] = "12";

        // 4. Update/Add Tag 54 (Transaction Amount)
        $tags["54"] = (string) $amount;

        // 5. Build QRIS Baru
        return $this->buildQris($tags);
    }

    private function parseQris(string $qrisContent): array
    {
        $tags = [];
        $i = 0;
        $len = strlen($qrisContent);
        
        while ($i < $len - 8) { // Abaikan 6304 + CRC 4-digit di akhir (total 8 char)
            $tag = substr($qrisContent, $i, 2);
            $length = (int) substr($qrisContent, $i + 2, 2);
            $value = substr($qrisContent, $i + 4, $length);
            
            $tags[$tag] = $value;
            $i += 4 + $length;
        }
        
        return $tags;
    }

    private function buildQris(array $tags): string
    {
        ksort($tags); // Urutkan key/tag ascending
        $res = "";
        
        foreach ($tags as $tag => $val) {
            if ($tag === "63") continue; // Abaikan jika ada tag 63 di dictionary, karena akan ditambah di akhir
            $res .= $tag . str_pad((string)strlen($val), 2, '0', STR_PAD_LEFT) . $val;
        }

        $res .= "6304";
        $crc = $this->crc16($res);
        return $res . $crc;
    }

    /**
     * CRC-16/CCITT-FALSE calculation
     */
    private function crc16($data): string
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $x = (($crc >> 8) ^ ord($data[$i])) & 0xFF;
            $x ^= $x >> 4;
            $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ ($x)) & 0xFFFF;
        }
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
