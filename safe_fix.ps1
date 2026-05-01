Write-Host "=== CORRECTIONS SANS RISQUE ===" -ForegroundColor Cyan

# 1. Ajouter cascade remove (100% sur)
$file = "src/Entity/Produit.php"
$content = Get-Content $file -Raw
if ($content -notmatch 'cascade: \["remove"\]' -and $content -match 'OneToMany.*Stock') {
    $content = $content -replace '(OneToMany\(targetEntity: Stock::class, mappedBy: .produit.)', '$1cascade: ["remove"], '
    Set-Content $file -Value $content -NoNewline
    Write-Host "[OK] Cascade remove ajoute" -ForegroundColor Green
} else {
    Write-Host "[INFO] Cascade remove deja present ou non applicable" -ForegroundColor Yellow
}

# 2. Ajouter constructeur pour created_at si absent
$entities = @('PasswordReset', 'UserFace', 'UserSession')
foreach ($entity in $entities) {
    $file = "src/Entity/$entity.php"
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        if ($content -notmatch 'public function __construct' -and $content -match 'created_at') {
            $construct = @'

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
'@
            $content = $content -replace '(\})$', "$construct`n}"
            Set-Content $file -Value $content -NoNewline
            Write-Host "[OK] Constructeur ajoute pour $entity" -ForegroundColor Green
        } else {
            Write-Host "[INFO] $entity a deja un constructeur" -ForegroundColor Yellow
        }
    }
}

Write-Host ""
Write-Host "=== CORRECTIONS TERMINEES ===" -ForegroundColor Green
Write-Host "Commande a executer: php bin/console cache:clear" -ForegroundColor Yellow