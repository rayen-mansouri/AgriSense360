param(
    [string]$BaseUrl = 'https://885bcd438c784f.lhr.life'
)

$ErrorActionPreference = 'Stop'

$base = $BaseUrl

function Assert-Contains($html, $needle, $message) {
    if ($html -notmatch [regex]::Escape($needle)) {
        throw $message
    }
}

# USER FLOW
$ur = Get-Random
$userEmail = "publicuser$ur@example.com"
$userPass = 'Secret123!'
$userCookie = Join-Path $env:TEMP "agri-public-user-$ur.txt"
Remove-Item $userCookie -ErrorAction SilentlyContinue

curl.exe -k -s -c $userCookie -b $userCookie -o NUL -w "user-signup:%{http_code}`n" -X POST --data-urlencode "first_name=Public" --data-urlencode "last_name=User" --data-urlencode "email=$userEmail" --data-urlencode "password=$userPass" "$base/auth/signup?mode=user"
curl.exe -k -s -b $userCookie -o NUL -w "user-page-after-signup:%{http_code}`n" "$base/management/equipments"
curl.exe -k -s -b $userCookie -o NUL -w "user-logout:%{http_code}`n" "$base/logout"
curl.exe -k -s -c $userCookie -b $userCookie -o NUL -w "user-login:%{http_code}`n" -X POST --data-urlencode "email=$userEmail" --data-urlencode "password=$userPass" "$base/auth/login?mode=user"

curl.exe -k -s -b $userCookie -o NUL -w "user-create-equipment:%{http_code}`n" -X POST --data-urlencode 'form_type=equipment' --data-urlencode 'name=Public User Rig' --data-urlencode 'type=Tractor' --data-urlencode 'status=Ready' --data-urlencode 'purchase_date=2026-04-06' "$base/management/equipments"
$userPage = curl.exe -k -s -b $userCookie "$base/management/equipments"
Assert-Contains $userPage 'Public User Rig' 'User equipment creation not visible'
$userEquipIdMatch = [regex]::Match($userPage, 'data-edit-url="/management/equipments/(\d+)/edit"')
if (-not $userEquipIdMatch.Success) { throw 'User equipment id not found' }
$userEquipId = $userEquipIdMatch.Groups[1].Value
$userEquipTokenMatch = [regex]::Match($userPage, '(?s)action="/management/equipments/' + $userEquipId + '/delete".*?name="_token" value="([^"]+)"')
if (-not $userEquipTokenMatch.Success) { throw 'User equipment token not found' }
$userEquipToken = $userEquipTokenMatch.Groups[1].Value

curl.exe -k -s -b $userCookie -o NUL -w "user-update-equipment:%{http_code}`n" -X POST --data-urlencode 'name=Public User Rig Pro' --data-urlencode 'type=Tractor XL' --data-urlencode 'status=Service' --data-urlencode 'purchase_date=2026-04-05' "$base/management/equipments/$userEquipId/edit"
$userPage = curl.exe -k -s -b $userCookie "$base/management/equipments"
Assert-Contains $userPage 'Public User Rig Pro' 'User equipment update not visible'

curl.exe -k -s -b $userCookie -o NUL -w "user-create-maintenance:%{http_code}`n" -X POST --data-urlencode 'form_type=maintenance' --data-urlencode "equipment_id=$userEquipId" --data-urlencode 'maintenance_date=2026-04-06' --data-urlencode 'maintenance_type=Inspection' --data-urlencode 'cost=123.45' "$base/management/equipments"
$userPage = curl.exe -k -s -b $userCookie "$base/management/equipments"
Assert-Contains $userPage 'Inspection' 'User maintenance creation not visible'
$userMaintIdMatch = [regex]::Match($userPage, 'data-edit-url="/management/equipments/maintenance/(\d+)/edit"')
if (-not $userMaintIdMatch.Success) { throw 'User maintenance id not found' }
$userMaintId = $userMaintIdMatch.Groups[1].Value
$userMaintTokenMatch = [regex]::Match($userPage, '(?s)action="/management/equipments/maintenance/' + $userMaintId + '/delete".*?name="_token" value="([^"]+)"')
if (-not $userMaintTokenMatch.Success) { throw 'User maintenance token not found' }
$userMaintToken = $userMaintTokenMatch.Groups[1].Value

curl.exe -k -s -b $userCookie -o NUL -w "user-delete-maintenance:%{http_code}`n" -X POST --data-urlencode "_token=$userMaintToken" "$base/management/equipments/maintenance/$userMaintId/delete"
curl.exe -k -s -b $userCookie -o NUL -w "user-delete-equipment:%{http_code}`n" -X POST --data-urlencode "_token=$userEquipToken" "$base/management/equipments/$userEquipId/delete"
$userFinal = curl.exe -k -s -b $userCookie "$base/management/equipments"
if (($userFinal -match 'Public User Rig Pro') -or ($userFinal -match '123.45')) { throw 'User delete verification failed' }
Write-Host 'user-flow:ok'

# ADMIN FLOW
$ar = Get-Random
$adminEmail = "publicadmin$ar@example.com"
$adminPass = 'Secret123!'
$adminCookie = Join-Path $env:TEMP "agri-public-admin-$ar.txt"
Remove-Item $adminCookie -ErrorAction SilentlyContinue

curl.exe -k -s -c $adminCookie -b $adminCookie -o NUL -w "admin-signup:%{http_code}`n" -X POST --data-urlencode "first_name=Public" --data-urlencode "last_name=Admin" --data-urlencode "email=$adminEmail" --data-urlencode "password=$adminPass" "$base/auth/signup?mode=admin"
curl.exe -k -s -b $adminCookie -o NUL -w "admin-page-after-signup:%{http_code}`n" "$base/admin/management/equipments"
curl.exe -k -s -b $adminCookie -o NUL -w "admin-logout:%{http_code}`n" "$base/logout"
curl.exe -k -s -c $adminCookie -b $adminCookie -o NUL -w "admin-login:%{http_code}`n" -X POST --data-urlencode "email=$adminEmail" --data-urlencode "password=$adminPass" "$base/auth/login?mode=admin"

$adminPage = curl.exe -k -s -b $adminCookie "$base/admin/management/equipments"
$selectedUserMatch = [regex]::Match($adminPage, '<option value="(\d+)" selected')
if (-not $selectedUserMatch.Success) { throw 'Admin selected user id not found' }
$selectedUserId = $selectedUserMatch.Groups[1].Value

curl.exe -k -s -b $adminCookie -o NUL -w "admin-create-equipment:%{http_code}`n" -X POST --data-urlencode "target_user_id=$selectedUserId" --data-urlencode 'form_type=equipment' --data-urlencode 'name=Public Admin Rig' --data-urlencode 'type=Drone' --data-urlencode 'status=Ready' --data-urlencode 'purchase_date=2026-04-06' "$base/admin/management/equipments?user_id=$selectedUserId"
$adminPage = curl.exe -k -s -b $adminCookie "$base/admin/management/equipments?user_id=$selectedUserId"
Assert-Contains $adminPage 'Public Admin Rig' 'Admin equipment creation not visible'
$adminEquipIdMatch = [regex]::Match($adminPage, 'data-edit-url="/admin/management/equipments/(\d+)/edit\?user_id=' + $selectedUserId + '"')
if (-not $adminEquipIdMatch.Success) { throw 'Admin equipment id not found' }
$adminEquipId = $adminEquipIdMatch.Groups[1].Value
$adminEquipTokenMatch = [regex]::Match($adminPage, '(?s)action="/admin/management/equipments/' + $adminEquipId + '/delete\?user_id=' + $selectedUserId + '".*?name="_token" value="([^"]+)"')
if (-not $adminEquipTokenMatch.Success) { throw 'Admin equipment token not found' }
$adminEquipToken = $adminEquipTokenMatch.Groups[1].Value

curl.exe -k -s -b $adminCookie -o NUL -w "admin-update-equipment:%{http_code}`n" -X POST --data-urlencode 'name=Public Admin Rig Pro' --data-urlencode 'type=Drone XL' --data-urlencode 'status=Service' --data-urlencode 'purchase_date=2026-04-05' "$base/admin/management/equipments/$adminEquipId/edit?user_id=$selectedUserId"
$adminPage = curl.exe -k -s -b $adminCookie "$base/admin/management/equipments?user_id=$selectedUserId"
Assert-Contains $adminPage 'Public Admin Rig Pro' 'Admin equipment update not visible'

curl.exe -k -s -b $adminCookie -o NUL -w "admin-create-maintenance:%{http_code}`n" -X POST --data-urlencode "target_user_id=$selectedUserId" --data-urlencode 'form_type=maintenance' --data-urlencode "equipment_id=$adminEquipId" --data-urlencode 'maintenance_date=2026-04-06' --data-urlencode 'maintenance_type=Inspection' --data-urlencode 'cost=222.22' "$base/admin/management/equipments?user_id=$selectedUserId"
$adminPage = curl.exe -k -s -b $adminCookie "$base/admin/management/equipments?user_id=$selectedUserId"
Assert-Contains $adminPage '222.22' 'Admin maintenance creation not visible'
$adminMaintIdMatch = [regex]::Match($adminPage, 'data-edit-url="/admin/management/equipments/maintenance/(\d+)/edit\?user_id=' + $selectedUserId + '"')
if (-not $adminMaintIdMatch.Success) { throw 'Admin maintenance id not found' }
$adminMaintId = $adminMaintIdMatch.Groups[1].Value
$adminMaintTokenMatch = [regex]::Match($adminPage, '(?s)action="/admin/management/equipments/maintenance/' + $adminMaintId + '/delete\?user_id=' + $selectedUserId + '".*?name="_token" value="([^"]+)"')
if (-not $adminMaintTokenMatch.Success) { throw 'Admin maintenance token not found' }
$adminMaintToken = $adminMaintTokenMatch.Groups[1].Value

curl.exe -k -s -b $adminCookie -o NUL -w "admin-delete-maintenance:%{http_code}`n" -X POST --data-urlencode "_token=$adminMaintToken" "$base/admin/management/equipments/maintenance/$adminMaintId/delete?user_id=$selectedUserId"
curl.exe -k -s -b $adminCookie -o NUL -w "admin-delete-equipment:%{http_code}`n" -X POST --data-urlencode "_token=$adminEquipToken" "$base/admin/management/equipments/$adminEquipId/delete?user_id=$selectedUserId"
$adminFinal = curl.exe -k -s -b $adminCookie "$base/admin/management/equipments?user_id=$selectedUserId"
if (($adminFinal -match 'Public Admin Rig Pro') -or ($adminFinal -match '222.22')) { throw 'Admin delete verification failed' }
Write-Host 'admin-flow:ok'

Write-Host 'public-smoke:ok'
