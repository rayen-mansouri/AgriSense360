$ErrorActionPreference = 'Stop'
$base = 'http://127.0.0.1:8002'
$stamp = [DateTime]::Now.ToString('yyyyMMddHHmmss')
$userEmail = "user.$stamp@example.com"
$adminEmail = "admin.$stamp@example.com"

function Get-Status([string]$url, $session) {
    $r = Invoke-WebRequest -Uri $url -WebSession $session -UseBasicParsing
    return $r.StatusCode
}

$userSess = New-Object Microsoft.PowerShell.Commands.WebRequestSession
Invoke-WebRequest -Uri "$base/auth/signup?mode=user" -WebSession $userSess -UseBasicParsing | Out-Null
Invoke-WebRequest -Uri "$base/auth/signup?mode=user" -Method Post -WebSession $userSess -Body @{ first_name='Smoke'; last_name='User'; email=$userEmail; password='Strong!234' } -UseBasicParsing | Out-Null

$userRoutes = @('/home','/management/animals','/management/equipments','/management/stock','/management/culture','/management/workers','/management/users')
$userRouteResults = foreach($r in $userRoutes){ "USER $r => $(Get-Status "$base$r" $userSess)" }

$userCrudResults = @()
$userCrudResults += "USER create equipment => $((Invoke-WebRequest -Uri "$base/management/equipments" -Method Post -WebSession $userSess -Body @{ form_type='equipment'; name='SmokeEq'; type='Tractor'; status='Ready'; purchase_date='2026-04-06' } -UseBasicParsing).StatusCode)"
$userCrudResults += "USER create worker => $((Invoke-WebRequest -Uri "$base/management/workers/save-worker" -Method Post -WebSession $userSess -Body @{ last_name='Wk'; first_name='One'; position='Role'; salary='900'; availability='Available' } -UseBasicParsing).StatusCode)"
$userCrudResults += "USER create animal => $((Invoke-WebRequest -Uri "$base/management/animals/save" -Method Post -WebSession $userSess -Body @{ ear_tag='7001'; type='cow'; weight='350'; birth_date='2024-01-01'; entry_date='2024-02-01'; origin='BORN_IN_FARM'; vaccinated='1'; location='barn' } -UseBasicParsing).StatusCode)"
$userCrudResults += "USER update profile => $((Invoke-WebRequest -Uri "$base/management/users" -Method Post -WebSession $userSess -Body @{ last_name='User2'; first_name='Smoke2'; email=$userEmail; password='Strong!234' } -UseBasicParsing).StatusCode)"

$adminSess = New-Object Microsoft.PowerShell.Commands.WebRequestSession
Invoke-WebRequest -Uri "$base/auth/signup?mode=admin" -WebSession $adminSess -UseBasicParsing | Out-Null
Invoke-WebRequest -Uri "$base/auth/signup?mode=admin" -Method Post -WebSession $adminSess -Body @{ first_name='Smoke'; last_name='Admin'; email=$adminEmail; password='Strong!234' } -UseBasicParsing | Out-Null

$adminRoutes = @('/admin/home','/admin/management/animals','/admin/management/equipments','/admin/management/stock','/admin/management/culture','/admin/management/workers','/admin/management/users','/admin/profile')
$adminRouteResults = foreach($r in $adminRoutes){ "ADMIN $r => $(Get-Status "$base$r" $adminSess)" }

$adminWorkersPage = Invoke-WebRequest -Uri "$base/admin/management/workers" -WebSession $adminSess -UseBasicParsing
$uid = 1
$m = [regex]::Match($adminWorkersPage.Content, '<option value="(\d+)"[^>]*selected')
if($m.Success){ $uid = [int]$m.Groups[1].Value }

$adminCrudResults = @()
$adminCrudResults += "ADMIN create worker => $((Invoke-WebRequest -Uri "$base/admin/management/workers/save-worker" -Method Post -WebSession $adminSess -Body @{ user_id=$uid; last_name='AdmW'; first_name='One'; position='Role'; salary='1000'; availability='Available' } -UseBasicParsing).StatusCode)"
$adminCrudResults += "ADMIN create equipment => $((Invoke-WebRequest -Uri "$base/admin/management/equipments?user_id=$uid" -Method Post -WebSession $adminSess -Body @{ target_user_id=$uid; form_type='equipment'; name='AdmEq'; type='Seeder'; status='Ready'; purchase_date='2026-04-06' } -UseBasicParsing).StatusCode)"
$adminCrudResults += "ADMIN create user => $((Invoke-WebRequest -Uri "$base/admin/management/users" -Method Post -WebSession $adminSess -Body @{ user_action='create'; last_name='Managed'; first_name='User'; email="managed.$stamp@example.com"; password='Strong!234'; status='Active'; role_name='USER' } -UseBasicParsing).StatusCode)"
$adminCrudResults += "ADMIN update profile => $((Invoke-WebRequest -Uri "$base/admin/profile" -Method Post -WebSession $adminSess -Body @{ last_name='Admin2'; first_name='Smoke2'; email=$adminEmail; password='Strong!234' } -UseBasicParsing).StatusCode)"

'=== ROUTE CHECKS ==='
$userRouteResults
$adminRouteResults
'=== CRUD ACTIONS ==='
$userCrudResults
$adminCrudResults
