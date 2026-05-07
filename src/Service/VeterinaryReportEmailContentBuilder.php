<?php

namespace App\Service;

class VeterinaryReportEmailContentBuilder
{
    public function buildBody(array $atRisk, string $notes): string
    {
        $sb = "Animal Health Report\n";
        $sb .= 'Date: ' . (new \DateTimeImmutable('today'))->format('Y-m-d') . "\n\n";
        if ($atRisk === []) {
            $sb .= "Good news — all monitored animals are currently healthy.\n";
        } else {
            $sb .= 'Animals requiring attention (' . count($atRisk) . "):\n";
            foreach ($atRisk as $a) {
                $sb .= '* Ear Tag #' . $a->getEarTag() . ' [' . ($a->getType() ?? 'unknown') . "] Status: " . ($a->getHealthStatus() ?? '-') . "\n";
            }
        }
        if ($notes !== '') {
            $sb .= "\nAdditional Notes:\n" . $notes . "\n";
        }

        return $sb;
    }
}
