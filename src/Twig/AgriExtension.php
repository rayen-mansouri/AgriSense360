<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * AgriSense360 Twig Extension
 *
 * WHY THIS EXISTS:
 * Our Twig templates call helper functions like:
 *   {{ etatToCssClass(culture.etat) }}
 *   {{ etatToEmoji(culture.etat) }}
 *   {{ cultureTypeEmoji(culture.typeCulture) }}
 *
 * Twig does not have PHP functions natively, so we register them here.
 * This mirrors the CSS class logic in Java CultureController/CultureService.
 *
 * HOW TO REGISTER:
 * Symfony auto-discovers this class because it extends AbstractExtension
 * and is in App\Twig namespace. No additional config needed.
 */
class AgriExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('etatToCssClass', [$this, 'etatToCssClass']),
            new TwigFunction('etatToEmoji',    [$this, 'etatToEmoji']),
            new TwigFunction('cultureTypeEmoji', [$this, 'cultureTypeEmoji']),
        ];
    }

    /**
     * Maps état string → CSS class.
     * Mirrors CultureService::getEtatClass() in PHP / same logic in Java CultureController
     */
    public function etatToCssClass(?string $etat): string
    {
        if (!$etat) return 'etat-semis';
        $l = mb_strtolower($etat);
        if (str_contains($l, 'retard'))                                    return 'etat-recolte-en-retard';
        if (str_contains($l, 'prévue') || str_contains($l, 'prevue'))     return 'etat-recolte-prevue';
        if (str_contains($l, 'maturit'))                                   return 'etat-maturite';
        if (str_contains($l, 'croiss'))                                    return 'etat-croissance';
        return 'etat-semis';
    }

    /**
     * Returns an emoji for each état — used in badge display
     */
    public function etatToEmoji(?string $etat): string
    {
        if (!$etat) return '🌱';
        $l = mb_strtolower($etat);
        if (str_contains($l, 'retard'))  return '⚠️';
        if (str_contains($l, 'prévue') || str_contains($l, 'prevue')) return '🌾';
        if (str_contains($l, 'maturit')) return '✅';
        if (str_contains($l, 'croiss'))  return '📈';
        return '🌱'; // Semis
    }

    /**
     * Returns a fallback emoji for culture cards without images
     */
    public function cultureTypeEmoji(?string $type): string
    {
        return match($type) {
            'Céréales'      => '🌾',
            'Légumes'       => '🥕',
            'Fruits'        => '🍎',
            'Ornementales'  => '🌸',
            default         => '🌿',
        };
    }
}