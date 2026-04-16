<?php

namespace App\Service;

use App\Entity\Animal;

class VeterinaryReportEmailContentBuilder
{
    public function buildBody(array $atRisk, string $notes): string
    {
        $sb = '';
        $sb .= "Animal Health Report\n";
        $sb .= 'Date: ' . (new \DateTimeImmutable('today'))->format('Y-m-d') . "\n\n";

        if ($atRisk === []) {
            $sb .= "Good news — all monitored animals are currently healthy.\n";
        } else {
            $sb .= 'Animals requiring attention (' . count($atRisk) . "):\n";
            $sb .= "----------------------------------------\n";
            foreach ($atRisk as $a) {
                $type = $a->getType() !== null ? $a->getType() : 'unknown';
                $status = $a->getHealthStatus() ?? '';
                $loc = $a->getLocation() !== null ? $a->getLocation() : '-';
                $sb .= '  * Ear Tag #' . $a->getEarTag()
                    . '  [' . $type . ']'
                    . '  Status: ' . $status
                    . '  Location: ' . $loc
                    . "\n";
            }
        }

        if ($notes !== '') {
            $sb .= "\nAdditional Notes:\n";
            $sb .= "----------------------------------------\n";
            $sb .= $notes . "\n";
        }

        $sb .= "\n-- Sent from AgriSense 360";

        return $sb;
    }
}
