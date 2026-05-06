<?php
// src/Service/MailService.php
namespace App\Service;

use App\Entity\Culture;
use App\Entity\Parcelle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Psr\Log\LoggerInterface;

/**
 * MailService — Symfony port of Java EmailService + EmailTemplates.
 *
 * Sends HTML e-mails for:
 *  - Culture alerts  (retard / récolte prévue / maturité)
 *  - Parcelle alerts (surface pleine / culture ajoutée / culture supprimée)
 *  - Daily digest
 *  - Welcome / test
 */
class MailService
{
    // ── Branding ─────────────────────────────────────────────────────
    private const FROM_NAME  = 'AgriSense-360';
    private const BRAND_GREEN = '#2d6a4f';
    private const BRAND_LIGHT = '#52b788';

    // ── Colours per état (mirrors Java EmailTemplates) ────────────────
    private const ETAT_COLOR = [
        'Récolte en Retard' => '#e63946',
        'Récolte Prévue'    => '#f4a261',
        'Maturité'          => '#2d6a4f',
        'Croissance'        => '#52b788',
        'Semis'             => '#a8dadc',
    ];

    // ── Icons per état ────────────────────────────────────────────────
    private const ETAT_ICON = [
        'Récolte en Retard' => '🚨',
        'Récolte Prévue'    => '⏰',
        'Maturité'          => '✅',
        'Croissance'        => '🌿',
        'Semis'             => '🌱',
    ];

    public function __construct(
        private MailerInterface  $mailer,
        private LoggerInterface  $logger,
        private string           $fromEmail,    // bind from .env
        private string           $toEmail,      // bind from .env
    ) {}

    // ═══════════════════════════════════════════════════════════════════
    //  PUBLIC API
    // ═══════════════════════════════════════════════════════════════════

    /** Quick connectivity test (mirrors Java sendTestEmail). */
    public function sendTestEmail(): bool
    {
        return $this->send(
            'AgriSense-360 — Connexion Confirmée ✅',
            $this->buildTestHtml()
        );
    }

    /** Alert when a culture's état changes (mirrors Java sendCultureAlert). */
    public function sendCultureAlert(Culture $c): bool
    {
        $etat    = $c->getEtat() ?? 'Inconnu';
        $icon    = self::ETAT_ICON[$etat]  ?? '🌾';
        $subject = sprintf('%s Culture "%s" — %s', $icon, $c->getNom(), $etat);

        return $this->send($subject, $this->buildCultureAlertHtml($c));
    }

    /** Alert when a parcelle's status changes (mirrors Java sendParcelleAlert). */
    public function sendParcelleAlert(Parcelle $p, string $reason): bool
    {
        $subject = sprintf('🗺️ Parcelle "%s" — %s', $p->getNom(), $reason);
        return $this->send($subject, $this->buildParcelleAlertHtml($p, $reason));
    }

    /** Daily digest of all cultures (mirrors Java sendDailyDigest). */
    public function sendDailyDigest(array $cultures): bool
    {
        $date    = (new \DateTime())->format('d/m/Y');
        $subject = sprintf('📊 Rapport Quotidien AgriSense — %s', $date);
        return $this->send($subject, $this->buildDailyDigestHtml($cultures));
    }

    public function sendTodayHarvestDigest(array $cultures): bool
    {
        $date    = (new \DateTime())->format('d/m/Y');
        $subject = sprintf('🌾 Récoltes prévues aujourd\'hui — %s', $date);
        return $this->send($subject, $this->buildDailyDigestHtml($cultures));
    }

    /** Welcome / onboarding e-mail. */
    public function sendWelcomeEmail(string $userName = 'Agriculteur'): bool
    {
        return $this->send(
            '🌱 Bienvenue sur AgriSense-360 !',
            $this->buildWelcomeHtml($userName)
        );
    }

    // ═══════════════════════════════════════════════════════════════════
    //  PRIVATE — SEND HELPER
    // ═══════════════════════════════════════════════════════════════════

    private function send(string $subject, string $html): bool
    {
        try {
            $email = (new Email())
                ->from(new Address($this->fromEmail, self::FROM_NAME))
                ->to($this->toEmail)
                ->subject($subject)
                ->html($html);

            $this->mailer->send($email);
            $this->logger->info('[MailService] Sent: ' . $subject);
            return true;
        } catch (\Throwable $e) {
            $this->logger->error('[MailService] Failed: ' . $e->getMessage());
            return false;
        }
    }

    // ═══════════════════════════════════════════════════════════════════
    //  PRIVATE — HTML BUILDERS  (mirrors Java EmailTemplates)
    // ═══════════════════════════════════════════════════════════════════

    /** Shared outer shell — same card layout as the Java template. */
    private function wrap(string $bodyInner): string
    {
        $year  = date('Y');
        $green = self::BRAND_GREEN;
        $light = self::BRAND_LIGHT;

        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
          <meta charset="UTF-8"/>
          <meta name="viewport" content="width=device-width,initial-scale=1"/>
          <title>AgriSense-360</title>
        </head>
        <body style="margin:0;padding:0;background:#f0f4f0;font-family:'Segoe UI',Arial,sans-serif;">
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f0;padding:30px 0;">
            <tr><td align="center">
              <table width="600" cellpadding="0" cellspacing="0"
                     style="background:#fff;border-radius:12px;overflow:hidden;
                            box-shadow:0 4px 20px rgba(0,0,0,.10);">

                <!-- HEADER -->
                <tr>
                  <td style="background:linear-gradient(135deg,{$green},{$light});
                              padding:30px;text-align:center;">
                    <div style="font-size:42px;margin-bottom:8px;">🌿</div>
                    <h1 style="margin:0;color:#fff;font-size:26px;letter-spacing:1px;">
                      AgriSense<span style="opacity:.75;">-360</span>
                    </h1>
                    <p style="margin:6px 0 0;color:rgba(255,255,255,.85);font-size:13px;">
                      Système de Gestion Agricole Intelligent
                    </p>
                  </td>
                </tr>

                <!-- BODY -->
                <tr><td style="padding:30px 36px;">{$bodyInner}</td></tr>

                <!-- FOOTER -->
                <tr>
                  <td style="background:#f8faf8;padding:20px 36px;text-align:center;
                              border-top:1px solid #e8f0e8;">
                    <p style="margin:0;font-size:12px;color:#888;">
                      © {$year} AgriSense-360 · Système automatisé — merci de ne pas répondre à cet e-mail.
                    </p>
                  </td>
                </tr>

              </table>
            </td></tr>
          </table>
        </body>
        </html>
        HTML;
    }

    // ── Test e-mail ───────────────────────────────────────────────────
    private function buildTestHtml(): string
    {
        $now   = (new \DateTime())->format('d/m/Y H:i');
        $green = self::BRAND_GREEN;

        $body = <<<HTML
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:56px;margin-bottom:12px;">✅</div>
          <h2 style="color:{$green};margin:0 0 8px;">Connexion E-mail Réussie !</h2>
          <p style="color:#666;font-size:15px;margin:0;">
            Votre configuration SMTP AgriSense-360 fonctionne parfaitement.
          </p>
        </div>

        <div style="background:#f8faf8;border-radius:8px;padding:20px;margin:20px 0;
                    border-left:4px solid {$green};">
          <h3 style="color:{$green};margin:0 0 12px;font-size:15px;">📋 Détails de configuration</h3>
          <table width="100%" cellpadding="4" cellspacing="0" style="font-size:14px;color:#444;">
            <tr>
              <td style="color:#888;width:40%;">Système :</td>
              <td><strong>AgriSense-360</strong></td>
            </tr>
            <tr>
              <td style="color:#888;">Date / Heure :</td>
              <td><strong>{$now}</strong></td>
            </tr>
            <tr>
              <td style="color:#888;">Protocole :</td>
              <td><strong>SMTP / STARTTLS</strong></td>
            </tr>
            <tr>
              <td style="color:#888;">Statut :</td>
              <td><strong style="color:{$green};">✅ Opérationnel</strong></td>
            </tr>
          </table>
        </div>

        <p style="text-align:center;color:#555;font-size:14px;margin:20px 0 0;">
          🌱 Les notifications AgriSense-360 sont maintenant actives.
        </p>
        HTML;

        return $this->wrap($body);
    }

    // ── Culture alert ─────────────────────────────────────────────────
    private function buildCultureAlertHtml(Culture $c): string
    {
        $etat     = $c->getEtat() ?? 'Inconnu';
        $color    = self::ETAT_COLOR[$etat]  ?? '#888';
        $icon     = self::ETAT_ICON[$etat]   ?? '🌾';
        $nom      = htmlspecialchars($c->getNom());
        $type     = htmlspecialchars((string)$c->getTypeCulture());
        $surface  = number_format((float)$c->getSurface(), 2);
        $dp       = $c->getDatePlantation()?->format('d/m/Y') ?? '—';
        $dr       = $c->getDateRecolte()?->format('d/m/Y')    ?? '—';
        $parcelle = htmlspecialchars((string)($c->getParcelle()?->getNom() ?? '—'));
        $now      = (new \DateTime())->format('d/m/Y H:i');
        $green    = self::BRAND_GREEN;

        // Days until harvest
        $daysLabel = '—';
        if ($c->getDateRecolte()) {
            $diff = (new \DateTime('today'))->diff($c->getDateRecolte());
            $days = (int)$diff->days * ($c->getDateRecolte() >= new \DateTime('today') ? 1 : -1);
            $daysLabel = $days >= 0
                ? "Dans {$days} jour(s)"
                : abs($days) . ' jour(s) de retard';
        }

        $body = <<<HTML
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:52px;margin-bottom:10px;">{$icon}</div>
          <h2 style="color:{$color};margin:0 0 6px;">Alerte Culture</h2>
          <span style="background:{$color};color:#fff;padding:4px 14px;border-radius:20px;
                       font-size:13px;font-weight:600;">{$etat}</span>
        </div>

        <div style="background:#f8faf8;border-radius:8px;padding:20px;margin-bottom:20px;
                    border-left:4px solid {$color};">
          <h3 style="color:{$green};margin:0 0 14px;font-size:15px;">🌾 Informations de la culture</h3>
          <table width="100%" cellpadding="5" cellspacing="0" style="font-size:14px;color:#444;">
            <tr><td style="color:#888;width:45%;">Nom :</td><td><strong>{$nom}</strong></td></tr>
            <tr><td style="color:#888;">Type :</td><td>{$type}</td></tr>
            <tr><td style="color:#888;">Surface :</td><td>{$surface} m²</td></tr>
            <tr><td style="color:#888;">Parcelle :</td><td>{$parcelle}</td></tr>
            <tr><td style="color:#888;">Date plantation :</td><td>{$dp}</td></tr>
            <tr><td style="color:#888;">Date récolte :</td><td>{$dr}</td></tr>
            <tr>
              <td style="color:#888;">Récolte :</td>
              <td><strong style="color:{$color};">{$daysLabel}</strong></td>
            </tr>
          </table>
        </div>

        <div style="background:{$color}15;border:1px solid {$color}40;border-radius:8px;
                    padding:14px;text-align:center;margin-bottom:16px;">
          <p style="margin:0;color:{$color};font-weight:600;font-size:14px;">
            {$icon} État actuel : <strong>{$etat}</strong>
          </p>
        </div>

        <p style="text-align:center;color:#999;font-size:12px;margin:0;">
          Notification générée le {$now}
        </p>
        HTML;

        return $this->wrap($body);
    }

    // ── Parcelle alert ────────────────────────────────────────────────
    private function buildParcelleAlertHtml(Parcelle $p, string $reason): string
    {
        $nom       = htmlspecialchars($p->getNom());
        $surface   = number_format((float)$p->getSurface(), 2);
        $restant   = number_format((float)$p->getSurfaceRestant(), 2);
        $statut    = htmlspecialchars($p->getStatut() ?? '—');
        $local     = htmlspecialchars($p->getLocalisation() ?? '—');
        $now       = (new \DateTime())->format('d/m/Y H:i');
        $green     = self::BRAND_GREEN;
        $statColor = $p->getStatut() === 'Occupée' ? '#e63946' : $green;

        $pct = $p->getSurface() > 0
            ? min(100, round(($p->getSurface() - $p->getSurfaceRestant()) / $p->getSurface() * 100))
            : 0;

        $body = <<<HTML
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:52px;margin-bottom:10px;">🗺️</div>
          <h2 style="color:{$green};margin:0 0 6px;">Alerte Parcelle</h2>
          <p style="color:#666;font-size:14px;margin:0;">{$reason}</p>
        </div>

        <div style="background:#f8faf8;border-radius:8px;padding:20px;margin-bottom:20px;
                    border-left:4px solid {$green};">
          <h3 style="color:{$green};margin:0 0 14px;font-size:15px;">📍 Détails de la parcelle</h3>
          <table width="100%" cellpadding="5" cellspacing="0" style="font-size:14px;color:#444;">
            <tr><td style="color:#888;width:45%;">Nom :</td><td><strong>{$nom}</strong></td></tr>
            <tr><td style="color:#888;">Localisation :</td><td>{$local}</td></tr>
            <tr><td style="color:#888;">Surface totale :</td><td>{$surface} m²</td></tr>
            <tr><td style="color:#888;">Surface restante :</td><td>{$restant} m²</td></tr>
            <tr>
              <td style="color:#888;">Statut :</td>
              <td><strong style="color:{$statColor};">{$statut}</strong></td>
            </tr>
          </table>
        </div>

        <!-- Progress bar -->
        <div style="margin-bottom:20px;">
          <div style="display:flex;justify-content:space-between;font-size:12px;
                      color:#888;margin-bottom:6px;">
            <span>Utilisation de la surface</span><span>{$pct}%</span>
          </div>
          <div style="background:#e8f0e8;border-radius:6px;height:10px;overflow:hidden;">
            <div style="background:{$statColor};width:{$pct}%;height:100%;
                        border-radius:6px;transition:width .3s;"></div>
          </div>
        </div>

        <p style="text-align:center;color:#999;font-size:12px;margin:0;">
          Notification générée le {$now}
        </p>
        HTML;

        return $this->wrap($body);
    }

    // ── Daily digest ──────────────────────────────────────────────────
    private function buildDailyDigestHtml(array $cultures): string
    {
        $date  = (new \DateTime())->format('d/m/Y');
        $total = count($cultures);
        $green = self::BRAND_GREEN;

        // Counts per état
        $counts = [];
        foreach ($cultures as $c) {
            $e = $c->getEtat() ?? 'Inconnu';
            $counts[$e] = ($counts[$e] ?? 0) + 1;
        }

        // Stats cards
        $retard  = $counts['Récolte en Retard'] ?? 0;
        $prevue  = $counts['Récolte Prévue']    ?? 0;
        $matur   = $counts['Maturité']           ?? 0;

        // Build culture rows (only alerting ones first, then others)
        $rows = '';
        $priority = ['Récolte en Retard', 'Récolte Prévue', 'Maturité', 'Croissance', 'Semis'];
        usort($cultures, function ($a, $b) use ($priority) {
            $ai = array_search($a->getEtat(), $priority);
            $bi = array_search($b->getEtat(), $priority);
            return ($ai === false ? 99 : $ai) <=> ($bi === false ? 99 : $bi);
        });

        foreach ($cultures as $c) {
            $etat    = $c->getEtat() ?? 'Inconnu';
            $color   = self::ETAT_COLOR[$etat] ?? '#888';
            $icon    = self::ETAT_ICON[$etat]  ?? '🌾';
            $nom     = htmlspecialchars($c->getNom());
            $parcelle = htmlspecialchars((string)($c->getParcelle()?->getNom() ?? '—'));
            $dr      = $c->getDateRecolte()?->format('d/m/Y') ?? '—';

            $rows .= <<<HTML
            <tr style="border-bottom:1px solid #f0f4f0;">
              <td style="padding:10px 8px;font-size:14px;color:#333;">{$icon} {$nom}</td>
              <td style="padding:10px 8px;font-size:13px;color:#666;">{$parcelle}</td>
              <td style="padding:10px 8px;font-size:13px;color:#666;">{$dr}</td>
              <td style="padding:10px 8px;">
                <span style="background:{$color};color:#fff;padding:2px 10px;
                             border-radius:12px;font-size:12px;font-weight:600;">{$etat}</span>
              </td>
            </tr>
            HTML;
        }

        $statsBlock = $this->statCard('Total cultures', (string)$total, '🌾', $green)
                    . $this->statCard('En retard', (string)$retard, '🚨', '#e63946')
                    . $this->statCard('Récolte prévue', (string)$prevue, '⏰', '#f4a261')
                    . $this->statCard('Maturité', (string)$matur, '✅', $green);

        $body = <<<HTML
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:48px;margin-bottom:10px;">📊</div>
          <h2 style="color:{$green};margin:0 0 6px;">Rapport Quotidien</h2>
          <p style="color:#888;font-size:14px;margin:0;">{$date}</p>
        </div>

        <!-- Stats row -->
        <table width="100%" cellpadding="0" cellspacing="8" style="margin-bottom:24px;">
          <tr>{$statsBlock}</tr>
        </table>

        <!-- Culture table -->
        <div style="background:#f8faf8;border-radius:8px;overflow:hidden;margin-bottom:16px;">
          <div style="background:{$green};padding:12px 16px;">
            <h3 style="margin:0;color:#fff;font-size:14px;">🌱 Détail des cultures</h3>
          </div>
          <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
            <tr style="background:#eef4ee;">
              <th style="padding:10px 8px;text-align:left;color:{$green};font-size:12px;">Culture</th>
              <th style="padding:10px 8px;text-align:left;color:{$green};font-size:12px;">Parcelle</th>
              <th style="padding:10px 8px;text-align:left;color:{$green};font-size:12px;">Récolte</th>
              <th style="padding:10px 8px;text-align:left;color:{$green};font-size:12px;">État</th>
            </tr>
            {$rows}
          </table>
        </div>
        HTML;

        return $this->wrap($body);
    }

    /** Small stat card cell. */
    private function statCard(string $label, string $value, string $icon, string $color): string
    {
        return <<<HTML
        <td style="width:25%;padding:4px;">
          <div style="background:{$color}15;border:1px solid {$color}40;border-radius:8px;
                      padding:14px;text-align:center;">
            <div style="font-size:24px;margin-bottom:4px;">{$icon}</div>
            <div style="font-size:24px;font-weight:700;color:{$color};">{$value}</div>
            <div style="font-size:11px;color:#888;margin-top:2px;">{$label}</div>
          </div>
        </td>
        HTML;
    }

    // ── Welcome e-mail ────────────────────────────────────────────────
    private function buildWelcomeHtml(string $userName): string
    {
        $name  = htmlspecialchars($userName);
        $date  = (new \DateTime())->format('d/m/Y');
        $green = self::BRAND_GREEN;

        $body = <<<HTML
        <div style="text-align:center;margin-bottom:28px;">
          <div style="font-size:60px;margin-bottom:12px;">🌱</div>
          <h2 style="color:{$green};margin:0 0 8px;">Bienvenue, {$name} !</h2>
          <p style="color:#666;font-size:15px;margin:0;">
            Votre compte AgriSense-360 est prêt.
          </p>
        </div>

        <div style="background:#f8faf8;border-radius:8px;padding:20px;margin-bottom:20px;
                    border-left:4px solid {$green};">
          <h3 style="color:{$green};margin:0 0 14px;font-size:15px;">
            🚀 Ce que vous pouvez faire avec AgriSense-360
          </h3>
          <ul style="margin:0;padding-left:18px;color:#555;font-size:14px;line-height:1.8;">
            <li>📍 Gérer vos <strong>parcelles</strong> et leur surface disponible</li>
            <li>🌾 Suivre vos <strong>cultures</strong> et leurs stades de croissance</li>
            <li>📸 Analyser vos cultures par <strong>photo IA</strong></li>
            <li>🌦️ Consulter les <strong>prévisions météo</strong> en temps réel</li>
            <li>📊 Recevoir des <strong>rapports automatiques</strong> par e-mail</li>
          </ul>
        </div>

        <p style="text-align:center;color:#999;font-size:12px;margin:0;">
          Compte activé le {$date}
        </p>
        HTML;

        return $this->wrap($body);
    }
}
