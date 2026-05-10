<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stores one weather snapshot per culture per day.
 * Logged passively every time a parcelle page is visited,
 * and also via the daily cron command (app:log-weather-daily).
 */
#[ORM\Entity]
#[ORM\Table(name: 'culture_weather_log')]
#[ORM\UniqueConstraint(name: 'uniq_culture_date', columns: ['culture_id', 'log_date'])]
class CultureWeatherLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Foreign key — stored as plain int (same pattern as ParcelleHistorique).
     * We use onDelete CASCADE so logs are removed when the culture is deleted.
     */
    #[ORM\Column(name: 'culture_id', type: 'integer')]
    private int $cultureId;

    #[ORM\Column(name: 'log_date', type: 'date')]
    private \DateTimeInterface $logDate;

    #[ORM\Column(name: 'temp_min', type: 'float')]
    private float $tempMin = 0;

    #[ORM\Column(name: 'temp_max', type: 'float')]
    private float $tempMax = 0;

    #[ORM\Column(name: 'temp_moy', type: 'float')]
    private float $tempMoy = 0;

    #[ORM\Column(type: 'integer')]
    private int $humidity = 0;

    /** Wind speed in km/h */
    #[ORM\Column(name: 'wind_kmh', type: 'float')]
    private float $windKmh = 0;

    /** OpenWeatherMap weather condition ID (e.g. 800 = clear, 500 = rain) */
    #[ORM\Column(name: 'weather_id', type: 'integer')]
    private int $weatherId = 800;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $description = null;

    /** Rainfall in mm — not always available from free OWM tier, nullable */
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $rainfall = null;

    // ── Getters & Setters ─────────────────────────────────────────────────────

    public function getId(): ?int { return $this->id; }

    public function getCultureId(): int { return $this->cultureId; }
    public function setCultureId(int $v): self { $this->cultureId = $v; return $this; }

    public function getLogDate(): \DateTimeInterface { return $this->logDate; }
    public function setLogDate(\DateTimeInterface $v): self { $this->logDate = $v; return $this; }

    public function getTempMin(): float { return $this->tempMin; }
    public function setTempMin(float $v): self { $this->tempMin = $v; return $this; }

    public function getTempMax(): float { return $this->tempMax; }
    public function setTempMax(float $v): self { $this->tempMax = $v; return $this; }

    public function getTempMoy(): float { return $this->tempMoy; }
    public function setTempMoy(float $v): self { $this->tempMoy = $v; return $this; }

    public function getHumidity(): int { return $this->humidity; }
    public function setHumidity(int $v): self { $this->humidity = $v; return $this; }

    public function getWindKmh(): float { return $this->windKmh; }
    public function setWindKmh(float $v): self { $this->windKmh = $v; return $this; }

    public function getWeatherId(): int { return $this->weatherId; }
    public function setWeatherId(int $v): self { $this->weatherId = $v; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): self { $this->description = $v; return $this; }

    public function getRainfall(): ?float { return $this->rainfall; }
    public function setRainfall(?float $v): self { $this->rainfall = $v; return $this; }

    // ── Derived helpers used by HarvestIaService ──────────────────────────────

    public function isStormDay(): bool
    {
        return $this->weatherId >= 200 && $this->weatherId < 300;
    }

    public function isHeavyRainDay(): bool
    {
        return $this->weatherId >= 500 && $this->weatherId < 600;
    }

    public function isHeatStressDay(): bool
    {
        return $this->tempMax > 38.0;
    }

    public function isFrostDay(): bool
    {
        return $this->tempMin < 2.0;
    }

    public function isHighHumidityDay(): bool
    {
        return $this->humidity > 85;
    }

    public function isHighWindDay(): bool
    {
        return $this->windKmh > 50.0;
    }
}
