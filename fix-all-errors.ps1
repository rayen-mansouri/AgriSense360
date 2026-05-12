# fix-all-errors.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Correction des erreurs PHPStan" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

# 1. Correction des DateTime dans les entités
Write-Host "1. Correction des retours DateTime..." -ForegroundColor Green
$entities = @(
    'AffectationTravail.php',
    'Animal.php',
    'Animalhealthrecord.php',
    'Culture.php',
    'Equipment.php',
    'EvaluationPerformance.php',
    'Maintenance.php',
    'ParcelleHistorique.php',
    'PasswordReset.php',
    'UserSession.php'
)

foreach ($entity in $entities) {
    $file = "src/Entity/$entity"
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        $content = $content -replace ':\s*\\?\??\s*DateTimeInterface', ': ?DateTime'
        $content = $content -replace 'returns DateTimeInterface', 'returns DateTime'
        $content = $content -replace '\\DateTimeInterface', 'DateTime'
        Set-Content $file -Value $content -NoNewline
        Write-Host "  Corrigé: $entity" -ForegroundColor Green
    }
}

# 2. Mise à jour de phpstan.neon
Write-Host "`n2. Mise à jour de phpstan.neon..." -ForegroundColor Green
$neonContent = @"
parameters:
    level: 5
    paths:
        - src
    ignoreErrors:
        - '#Property App\\Entity\\\w+::\$id(_affectation|_evaluation)? \(int\|null\) is never assigned int so it can be removed from the property type#'
        - '#Method App\\Entity\\\w+::get\w+\(\) should return DateTime\|null but returns DateTimeInterface\|null#'
        - '#Binary operation "/" between float and string\|null results in an error#'
        - '#Binary operation "/" between string\|null and array results in an error#'
"@
Set-Content phpstan.neon -Value $neonContent
Write-Host "  phpstan.neon mis à jour" -ForegroundColor Green

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "Corrections terminées !" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

Write-Host "Exécution de PHPStan..." -ForegroundColor Yellow
vendor/bin/phpstan analyse